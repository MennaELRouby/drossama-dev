<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class CheckNotificationEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display all notification email addresses configured in settings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Notification Email Addresses');
        $this->line(str_repeat('=', 50));
        $this->newLine();

        // Get primary email
        $primaryEmail = Setting::where('key', 'site_email')
            ->where('lang', 'all')
            ->first()?->value ?? 'Not configured';

        // Get notification emails
        $notificationEmailsSetting = Setting::where('key', 'notification_emails')
            ->where('lang', 'all')
            ->first()?->value;

        $this->line('<fg=cyan>Primary Email:</>');
        $this->line('  ' . $primaryEmail);
        $this->newLine();

        if ($notificationEmailsSetting) {
            // Split emails
            $emails = preg_split('/[\n,]+/', $notificationEmailsSetting);
            $validEmails = [];

            foreach ($emails as $email) {
                $email = trim($email);
                if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $validEmails[] = $email;
                }
            }

            if (count($validEmails) > 0) {
                $this->line('<fg=green>Additional Recipients (' . count($validEmails) . '):</>');
                foreach ($validEmails as $index => $email) {
                    $this->line('  ' . ($index + 1) . '. ' . $email);
                }
                $this->newLine();

                $this->line('<fg=yellow>Total Recipients:</>');
                $allEmails = array_merge([$primaryEmail], $validEmails);
                $allEmails = array_filter(array_unique($allEmails));
                $this->line('  ' . count($allEmails) . ' email(s)');
            } else {
                $this->warn('No additional email addresses configured');
            }
        } else {
            $this->warn('No additional email addresses configured');
            $this->line('  Configure them in: Settings > Notification Emails');
        }

        $this->newLine();
        $this->line(str_repeat('=', 50));

        return Command::SUCCESS;
    }
}
