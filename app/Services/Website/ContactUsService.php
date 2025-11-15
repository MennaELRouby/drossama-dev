<?php

namespace App\Services\Website;

use App\Models\ContactUs;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactUsService
{
    public function store($data)
    {
        DB::beginTransaction();

        try {
            // Create the ContactUs
            $contactUs = ContactUs::create($data);

            // Send email notification
            $this->sendEmailNotification($contactUs);

            DB::commit();

            return true;
        } catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Send email notification about new contact message
     */
    protected function sendEmailNotification(ContactUs $contactUs)
    {
        try {
            // Get admin email from settings or use default
            $adminEmail = Setting::where('key', 'site_email')
                ->where('lang', 'all')
                ->first()?->value ?? config('mail.from.address');

            if (!$adminEmail) {
                Log::warning('No admin email configured for contact form notifications');
                return;
            }

            // Get site name from settings
            $siteName = Setting::where('key', 'site_name')
                ->where('lang', app()->getLocale())
                ->first()?->value ?? Setting::where('key', 'site_name')
                ->where('lang', 'ar')
                ->first()?->value ?? config('app.name', 'Website');

            // Prepare email data
            $name = $contactUs->name ?? 'Not specified';
            $phone = $contactUs->phone ?? 'Not specified';
            $email = $contactUs->email ?? 'Not specified';
            $company = $contactUs->company ?? 'Not specified';
            $message = $contactUs->message ?? 'Not specified';

            // Get service name if service_id exists
            $service = 'Not specified';
            if ($contactUs->service_id) {
                $serviceModel = \App\Models\Service::find($contactUs->service_id);
                $service = $serviceModel ? $serviceModel->name : 'Not specified';
            }

            // Get product name if product_id exists
            $product = null;
            if ($contactUs->product_id) {
                $productModel = \App\Models\Product::find($contactUs->product_id);
                $product = $productModel ? $productModel->name : null;
            }

            // Build HTML email content
            $htmlContent = $this->buildEmailTemplate($name, $phone, $email, $company, $service, $product, $message, $siteName);

            // Get notification emails (can be multiple)
            $notificationEmails = $this->getNotificationEmails($adminEmail);

            // Send email
            Mail::html($htmlContent, function ($mail) use ($notificationEmails, $name, $siteName) {
                $mail->to($notificationEmails)
                    ->subject("📩 New message from {$siteName} - {$name}");
            });
        } catch (\Exception $e) {
            // Log error but don't throw - we don't want email failure to break contact form
            Log::error('Failed to send contact form notification email', [
                'error' => $e->getMessage(),
                'contact_id' => $contactUs->id ?? null
            ]);
        }
    }

    /**
     * Get list of emails to receive notifications
     * Emails are managed from Settings in the dashboard
     */
    protected function getNotificationEmails($primaryEmail)
    {
        // Primary email from Settings
        $emails = [$primaryEmail];

        // Get additional emails from settings
        $notificationEmailsSetting = Setting::where('key', 'notification_emails')
            ->where('lang', 'all')
            ->first()?->value;

        if ($notificationEmailsSetting) {
            //   Emails by comma or new line Separated by comma or new line 
            $additionalEmails = preg_split('/[\n,]+/', $notificationEmailsSetting);

            foreach ($additionalEmails as $email) {
                $email = trim($email);
                if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emails[] = $email;
                }
            }
        }

        // Remove duplicate and empty emails
        $emails = array_filter(array_unique($emails));

        return $emails;
    }
    /**
     * Build beautiful HTML email template
     */
    protected function buildEmailTemplate($name, $phone, $email, $company, $service, $product, $message, $siteName)
    {
        // Build fields only if they have actual values (not "Not specified" or empty)
        $fields = '';

        // Name field (always show)
        if ($name && $name !== 'Not specified') {
            $fields .= "
            <div class='field'>
                <div class='label'>👤 Name:</div>
                <div class='value'>{$name}</div>
            </div>";
        }

        // Email field (always show)
        if ($email && $email !== 'Not specified') {
            $fields .= "
            <div class='field'>
                <div class='label'>📧 Email:</div>
                <div class='value'>{$email}</div>
            </div>";
        }

        // Phone field (only if provided)
        if ($phone && $phone !== 'Not specified') {
            $fields .= "
            <div class='field'>
                <div class='label'>📱 Phone:</div>
                <div class='value'>{$phone}</div>
            </div>";
        }

        // Company field (only if provided)
        if ($company && $company !== 'Not specified') {
            $fields .= "
            <div class='field'>
                <div class='label'>🏢 Company:</div>
                <div class='value'>{$company}</div>
            </div>";
        }

        // Service field (only if provided)
        if ($service && $service !== 'Not specified') {
            $fields .= "
            <div class='field'>
                <div class='label'>🧑 Service:</div>
                <div class='value'>{$service}</div>
            </div>";
        }

        // Product field (only if provided)
        if ($product && $product !== 'Not specified') {
            $fields .= "
            <div class='field'>
                <div class='label'>📦 Product:</div>
                <div class='value'>{$product}</div>
            </div>";
        }

        // Message field (always show)
        if ($message && $message !== 'Not specified') {
            $fields .= "
            <div class='field'>
                <div class='label'>📧 Message:</div>
                <div class='value'>" . nl2br(htmlspecialchars($message)) . "</div>
            </div>";
        }

        // Sending date (always show)
        $fields .= "
            <div class='field'>
                <div class='label'>🕐 Sending Date:</div>
                <div class='value'>" . date('Y-m-d H:i:s') . "</div>
            </div>";

        // Build product field if exists
        $productField = '';
        if ($product && $product !== 'Not specified') {
            $productField = "
            <div class='field'>
                <div class='label'>📦 Product:</div>
                <div class='value'>{$product}</div>
            </div>";
        }

        return "<!DOCTYPE html>
<html dir='rtl' lang='ar'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            direction: rtl; 
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container { 
            max-width: 600px; 
            margin: 20px auto; 
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header { 
            background: #164852; 
            color: white; 
            padding: 30px 20px; 
            text-align: center; 
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
        }
        .content { 
            background: #f5f5f5; 
            padding: 30px 20px; 
        }
        .field { 
            margin: 15px 0; 
            padding: 15px; 
            background: white; 
            border-right: 4px solid #7FC3C2; 
            border-radius: 4px;
        }
        .label { 
            font-weight: bold; 
            color: #164852; 
            font-size: 14px;
            margin-bottom: 8px;
        }
        .value { 
            color: #333; 
            font-size: 16px;
            line-height: 1.6;
        }
        .footer {
            background: #f9f9f9;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #e0e0e0;
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h2>📩 رسالة جديدة من {$siteName}</h2>
        </div>
        <div class='content'>
            {$fields}
        </div>
        <div class='footer'>
            <p>هذه رسالة تلقائية من نظام إدارة المحتوى - {$siteName}</p>
            <p>© " . date('Y') . " جميع الحقوق محفوظة</p>
        </div>
    </div>
</body>
</html>";
    }
}
