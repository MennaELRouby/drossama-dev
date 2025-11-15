<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Phone;
use App\Models\Setting;

class UpdateServiceWorker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sw:update {--force : Force update even if no changes detected}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Service Worker with latest phone numbers and site data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Updating Service Worker with latest data...');

        try {
            // Get current phone data
            $phones = Phone::active()
                ->orderBy('order', 'asc')
                ->get()
                ->map(function ($phone) {
                    return [
                        'name' => $phone->name,
                        'phone' => ($phone->code ?? '') . $phone->phone,
                        'email' => $phone->email,
                        'type' => $phone->type,
                    ];
                });

            // Get site settings
            $settings = Setting::where('lang', 'all')
                ->pluck('value', 'key')
                ->toArray();

            $siteName = $settings['site_name'] ?? config('app.name', 'Tulip');
            $siteEmail = $settings['site_email'] ?? 'info@site.com';

            // Read current Service Worker file
            $swPath = public_path('sw.js');
            if (!File::exists($swPath)) {
                $this->error('❌ Service Worker file not found at: ' . $swPath);
                return 1;
            }

            $swContent = File::get($swPath);

            // Update cache version to force refresh
            $newVersion = 'tulip-v' . time();
            $swContent = preg_replace(
                "/const CACHE_NAME = 'tulip-v[^']*';/",
                "const CACHE_NAME = '{$newVersion}';",
                $swContent
            );

            // Write updated Service Worker
            File::put($swPath, $swContent);

            $this->info('✅ Service Worker updated successfully!');
            $this->info("📱 Found {$phones->count()} active phone numbers");
            $this->info("🏢 Site name: {$siteName}");
            $this->info("📧 Site email: {$siteEmail}");
            $this->info("🔄 Cache version updated to: {$newVersion}");

            // Clear application cache to ensure API returns fresh data
            $this->call('cache:clear');
            $this->info('🧹 Application cache cleared');

            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Failed to update Service Worker: ' . $e->getMessage());
            return 1;
        }
    }
}
