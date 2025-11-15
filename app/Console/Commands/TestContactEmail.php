<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting;

class TestContactEmail extends Command
{
    protected $signature = 'contact:test {email?}';
    protected $description = 'Send a test contact form notification email';

    public function handle()
    {
        $testEmail = $this->argument('email') ?? config('mail.from.address');

        $this->info('Contact Form Email Test');
        $this->line(str_repeat('=', 50));
        $this->newLine();
        $this->line('Recipient: ' . $testEmail);
        $this->newLine();

        if (!$this->confirm('Send test email?', true)) {
            $this->warn('Operation cancelled');
            return Command::SUCCESS;
        }

        $this->newLine();
        $this->line('Sending test email...');

        try {
            $appName = Setting::where('key', 'site_name')
                ->where('lang', 'en')
                ->first()?->value ?? config('app.name', 'Application');

            $htmlContent = $this->buildTestEmailTemplate($appName);

            Mail::html($htmlContent, function ($mail) use ($testEmail, $appName) {
                $mail->to($testEmail)
                    ->subject("Test Contact Form - {$appName}");
            });

            $this->newLine();
            $this->info('Test email sent successfully');
            $this->line('Check inbox: ' . $testEmail);
            $this->newLine();

            // Show mail configuration
            $this->line('Mail Configuration:');
            $this->table(
                ['Setting', 'Value'],
                [
                    ['MAIL_MAILER', config('mail.default')],
                    ['MAIL_HOST', config('mail.mailers.smtp.host')],
                    ['MAIL_PORT', config('mail.mailers.smtp.port')],
                    ['MAIL_FROM', config('mail.from.address')],
                ]
            );

            $this->newLine();
            $this->line(str_repeat('=', 50));
        } catch (\Exception $e) {
            $this->newLine();
            $this->error('Failed to send test email');
            $this->error('Error: ' . $e->getMessage());
            $this->newLine();
            $this->line('Check logs: storage/logs/laravel.log');

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

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
