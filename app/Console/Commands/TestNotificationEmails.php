<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestNotificationEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to verify notification recipients are configured correctly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Test Notification Email');
        $this->line(str_repeat('=', 50));
        $this->newLine();

        // Get all notification emails
        $emails = $this->getNotificationEmails();

        if (empty($emails)) {
            $this->error('No email addresses configured');
            $this->line('Please configure notification emails in Settings');
            return Command::FAILURE;
        }

        $this->line('Recipients (' . count($emails) . '):');
        foreach ($emails as $email) {
            $this->line('  • ' . $email);
        }
        $this->newLine();

        if (!$this->confirm('Send test email to these addresses?', true)) {
            $this->warn('Operation cancelled');
            return Command::SUCCESS;
        }

        $this->newLine();
        $this->line('Sending test email...');

        try {
            $siteName = Setting::where('key', 'site_name')
                ->where('lang', 'en')
                ->first()?->value ?? config('app.name', 'Application');

            $htmlContent = $this->buildTestEmailTemplate($siteName);

            Mail::html($htmlContent, function ($mail) use ($emails, $siteName) {
                $mail->to($emails)
                    ->subject("Test Notification - {$siteName}");
            });

            $this->newLine();
            $this->info('Test email sent successfully');
            $this->line('Please check the inbox for:');
            foreach ($emails as $email) {
                $this->line('  • ' . $email);
            }
            $this->newLine();
            $this->line(str_repeat('=', 50));
        } catch (\Exception $e) {
            $this->newLine();
            $this->error('Failed to send test email');
            $this->error('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    /**
     * Get all notification emails
     */
    protected function getNotificationEmails()
    {
        $primaryEmail = Setting::where('key', 'site_email')
            ->where('lang', 'all')
            ->first()?->value;

        $emails = [];
        if ($primaryEmail) {
            $emails[] = $primaryEmail;
        }

        $notificationEmailsSetting = Setting::where('key', 'notification_emails')
            ->where('lang', 'all')
            ->first()?->value;

        if ($notificationEmailsSetting) {
            $additionalEmails = preg_split('/[\n,]+/', $notificationEmailsSetting);

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
     * Build test email template
     */
    protected function buildTestEmailTemplate($appName)
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
        .note {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 4px;
            padding: 15px;
            margin: 20px 0;
        }
        .note strong {
            color: #856404;
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
            
            <div class='note'>
                <strong>Note:</strong> This is a test message. Actual notifications will contain relevant content and data.
            </div>
        </div>
        <div class='footer'>
            <p>Automated test notification</p>
            <p>© " . date('Y') . " {$appName}</p>
        </div>
    </div>
</body>
</html>";
    }
}
