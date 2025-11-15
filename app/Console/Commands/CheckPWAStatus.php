<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckPWAStatus extends Command
{
    protected $signature = 'pwa:check';
    protected $description = 'Check PWA installation requirements and status';

    public function handle()
    {
        $this->info('PWA Installation Requirements Check');
        $this->line(str_repeat('=', 60));
        $this->newLine();

        $allGood = true;

        // Check 1: Service Worker
        $this->line('1. Service Worker');
        if (file_exists(public_path('sw.js'))) {
            $this->info('   ✓ Service Worker exists: public/sw.js');
        } else {
            $this->error('   ✗ Service Worker not found');
            $allGood = false;
        }

        // Check 2: Manifest
        $this->newLine();
        $this->line('2. Manifest');
        try {
            $response = @file_get_contents(url('/manifest.json'));
            if ($response) {
                $manifest = json_decode($response, true);
                $this->info('   ✓ Manifest is accessible');
                $this->line('     Name: ' . ($manifest['name'] ?? 'Not set'));
                $this->line('     Short Name: ' . ($manifest['short_name'] ?? 'Not set'));
                $this->line('     Start URL: ' . ($manifest['start_url'] ?? 'Not set'));
                $this->line('     Display: ' . ($manifest['display'] ?? 'Not set'));

                // Check icons
                $iconCount = count($manifest['icons'] ?? []);
                $this->line('     Icons: ' . $iconCount . ' found');

                $has192 = false;
                $has512 = false;

                foreach ($manifest['icons'] ?? [] as $icon) {
                    if (str_contains($icon['sizes'], '192x192')) {
                        $has192 = true;
                    }
                    if (str_contains($icon['sizes'], '512x512')) {
                        $has512 = true;
                    }
                }

                if ($has192 && $has512) {
                    $this->info('     ✓ Required icon sizes present (192x192, 512x512)');
                } else {
                    $this->warn('     ! Missing required icon sizes');
                    if (!$has192) $this->line('       - 192x192 missing');
                    if (!$has512) $this->line('       - 512x512 missing');
                    $allGood = false;
                }
            } else {
                $this->error('   ✗ Manifest not accessible');
                $allGood = false;
            }
        } catch (\Exception $e) {
            $this->error('   ✗ Error loading manifest: ' . $e->getMessage());
            $allGood = false;
        }

        // Check 3: Required Icon Files
        $this->newLine();
        $this->line('3. PWA Icon Files (public/)');
        $requiredIcons = [
            'icon-192x192.png' => '192x192',
            'icon-512x512.png' => '512x512',
        ];

        $iconsMissing = [];
        foreach ($requiredIcons as $filename => $size) {
            if (file_exists(public_path($filename))) {
                $this->info('   ✓ ' . $filename . ' exists');
            } else {
                $this->warn('   ! ' . $filename . ' not found');
                $iconsMissing[] = $filename;
            }
        }

        // Check 4: HTTPS (or localhost)
        $this->newLine();
        $this->line('4. HTTPS/Localhost');
        $url = url('/');
        if (
            str_starts_with($url, 'https://') ||
            str_contains($url, 'localhost') ||
            str_contains($url, '.test') ||
            str_contains($url, '127.0.0.1')
        ) {
            $this->info('   ✓ Valid URL: ' . $url);
        } else {
            $this->error('   ✗ PWA requires HTTPS (current: ' . $url . ')');
            $allGood = false;
        }

        // Check 5: Meta tags in HTML
        $this->newLine();
        $this->line('5. HTML Meta Tags');
        $headPath = resource_path('views/components/website/partials/_head.blade.php');
        $headContent = file_get_contents($headPath);

        if (str_contains($headContent, 'rel="manifest"')) {
            $this->info('   ✓ Manifest link tag present in HTML');
        } else {
            $this->error('   ✗ Manifest link tag missing');
            $allGood = false;
        }

        if (str_contains($headContent, 'theme-color')) {
            $this->info('   ✓ Theme color meta tag present');
        } else {
            $this->warn('   ! Theme color meta tag missing (recommended)');
        }

        // Summary
        $this->newLine();
        $this->line(str_repeat('=', 60));

        if ($allGood && empty($iconsMissing)) {
            $this->info('✓ All requirements met! PWA should be installable.');
            $this->newLine();
            $this->line('If install prompt still doesn\'t appear:');
            $this->line('  1. Clear browser cache (Ctrl+Shift+Del)');
            $this->line('  2. Check browser console for errors (F12)');
            $this->line('  3. Try Chrome/Edge (best PWA support)');
            $this->line('  4. Visit site 2-3 times (engagement requirement)');
            $this->line('  5. Check if already installed (chrome://apps)');
        } else {
            $this->warn('! Some requirements not met');
            $this->newLine();

            if (!empty($iconsMissing)) {
                $this->line('To fix icon issues:');
                $this->line('  1. Create icons with these sizes:');
                foreach ($iconsMissing as $icon) {
                    $this->line('     - ' . $icon);
                }
                $this->line('  2. Place them in: public/');
                $this->line('  3. Or use online tool: https://realfavicongenerator.net/');
            }
        }

        return $allGood ? Command::SUCCESS : Command::FAILURE;
    }
}
