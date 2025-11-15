<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class EmailTestController extends Controller
{
    /**
     * Show email test page
     */
    public function index()
    {
        // Check permission
        $this->authorize('settings.edit');

        // Get notification emails
        $primaryEmail = Setting::where('key', 'site_email')
            ->where('lang', 'all')
            ->first()?->value;

        $notificationEmails = Setting::where('key', 'notification_emails')
            ->where('lang', 'all')
            ->first()?->value;

        $emails = $this->getAllEmails($primaryEmail, $notificationEmails);

        return view('Dashboard.Settings.test-email', compact('emails', 'primaryEmail'));
    }

    /**
     * Send test email
     */
    public function send(Request $request)
    {
        // Check permission
        $this->authorize('settings.edit');

        // Rate limiting - max 3 attempts per minute
        $key = 'email-test:' . $request->user()->id;

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', __('dashboard.too_many_attempts', ['seconds' => $seconds]));
        }

        RateLimiter::hit($key, 60); // 60 seconds

        $request->validate([
            'recipient' => 'required|email',
            'test_type' => 'required|in:notification,contact'
        ]);

        try {
            $appName = Setting::where('key', 'site_name')
                ->where('lang', app()->getLocale())
                ->first()?->value ?? config('app.name', 'Application');

            $recipient = $request->recipient;
            $testType = $request->test_type;

            if ($testType === 'notification') {
                $htmlContent = $this->buildNotificationTestEmail($appName);
                $subject = __('dashboard.test_notification') . ' - ' . $appName;
            } else {
                $htmlContent = $this->buildContactTestEmail($appName);
                $subject = __('dashboard.test_contact_form') . ' - ' . $appName;
            }

            Mail::html($htmlContent, function ($mail) use ($recipient, $subject) {
                $mail->to($recipient)->subject($subject);
            });

            return back()->with('success', __('dashboard.test_email_sent_successfully', ['email' => $recipient]));
        } catch (\Exception $e) {
            return back()->with('error', __('dashboard.failed_to_send_email') . ': ' . $e->getMessage());
        }
    }

    /**
     * Get all notification emails
     */
    private function getAllEmails($primaryEmail, $notificationEmails)
    {
        $emails = [];

        if ($primaryEmail) {
            $emails[] = $primaryEmail;
        }

        if ($notificationEmails) {
            $additionalEmails = preg_split('/[\n,]+/', $notificationEmails);
            foreach ($additionalEmails as $email) {
                $email = trim($email);
                if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emails[] = $email;
                }
            }
        }

        return array_filter(array_unique($emails));
    }

    /**
     * Build notification test email template
     */
    private function buildNotificationTestEmail($appName)
    {
        $timestamp = date('Y-m-d H:i:s');

        return "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <style>
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container { 
            max-width: 600px; 
            margin: 40px auto; 
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; 
            padding: 40px 20px; 
            text-align: center; 
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content { 
            padding: 40px 30px; 
        }
        .alert {
            background: #d4edda;
            border-left: 4px solid #28a745;
            border-radius: 4px;
            padding: 20px;
            margin: 20px 0;
        }
        .alert h2 {
            color: #155724;
            margin: 0 0 10px 0;
            font-size: 18px;
        }
        .alert p {
            color: #155724;
            margin: 0;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box strong {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }
        .info-box p {
            margin: 0;
            color: #666;
            line-height: 1.8;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 13px;
            border-top: 1px solid #e9ecef;
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>Test Notification</h1>
            <p style='margin: 10px 0 0 0; opacity: 0.9; font-size: 14px;'>Email System Verification</p>
        </div>
        <div class='content'>
            <div class='alert'>
                <h2>✓ System Operational</h2>
                <p>If you received this message, your notification system is configured correctly.</p>
            </div>
            
            <div class='info-box'>
                <strong>Test Details</strong>
                <p>
                    <strong>Application:</strong> {$appName}<br>
                    <strong>Timestamp:</strong> {$timestamp}<br>
                    <strong>Purpose:</strong> Verify email delivery
                </p>
            </div>
            
            <p style='color: #666; line-height: 1.8;'>
                This email confirms that your notification system is working as expected. 
                All future notifications will be delivered to this address.
            </p>
        </div>
        <div class='footer'>
            <p>Automated test notification from dashboard</p>
            <p>© " . date('Y') . " {$appName}</p>
        </div>
    </div>
</body>
</html>";
    }

    /**
     * Build contact form test email template
     */
    private function buildContactTestEmail($appName)
    {
        $timestamp = date('Y-m-d H:i:s');

        return "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <style>
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container { 
            max-width: 600px; 
            margin: 40px auto; 
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; 
            padding: 40px 20px; 
            text-align: center; 
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content { 
            padding: 40px 30px; 
        }
        .alert {
            background: #d4edda;
            border-left: 4px solid #28a745;
            border-radius: 4px;
            padding: 20px;
            margin: 20px 0;
        }
        .alert h2 {
            color: #155724;
            margin: 0 0 10px 0;
            font-size: 18px;
        }
        .alert p {
            color: #155724;
            margin: 0;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box h3 {
            margin: 0 0 15px 0;
            color: #333;
            font-size: 16px;
        }
        .info-box p {
            margin: 8px 0;
            color: #666;
            line-height: 1.6;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 13px;
            border-top: 1px solid #e9ecef;
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>Contact Form Test</h1>
            <p style='margin: 10px 0 0 0; opacity: 0.9; font-size: 14px;'>Email Delivery Verification</p>
        </div>
        <div class='content'>
            <div class='alert'>
                <h2>✓ Test Successful</h2>
                <p>If you received this message, the contact form email system is working correctly.</p>
            </div>
            
            <div class='info-box'>
                <h3>Test Information</h3>
                <p><strong>Application:</strong> {$appName}</p>
                <p><strong>Timestamp:</strong> {$timestamp}</p>
                <p><strong>System:</strong> Laravel Mail System</p>
            </div>
            
            <p style='margin-top: 30px; color: #666; line-height: 1.8;'>
                This confirms that contact form submissions will be delivered successfully. 
                Actual contact messages will follow the same delivery pattern with user-submitted content.
            </p>
        </div>
        <div class='footer'>
            <p>Automated test from contact form system</p>
            <p>© " . date('Y') . " {$appName}</p>
        </div>
    </div>
</body>
</html>";
    }
}
