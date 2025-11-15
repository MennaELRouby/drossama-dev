<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GeneratePWAIcons extends Command
{
    protected $signature = 'pwa:generate-icons {source?}';
    protected $description = 'Generate PWA icons from source image';

    public function handle()
    {
        $this->info('PWA Icon Generator');
        $this->line(str_repeat('=', 60));
        $this->newLine();

        // Get source image
        $sourcePath = $this->argument('source');

        if (!$sourcePath) {
            $this->line('Looking for logo in storage...');

            // Try to find logo from settings
            $logoSetting = \App\Models\Setting::where('key', 'site_logo')
                ->where('lang', 'all')
                ->first();

            if ($logoSetting) {
                // Get raw value (without accessor) to avoid getting full URL
                $rawValue = $logoSetting->getAttributes()['value'] ?? null;

                if ($rawValue) {
                    $this->line('Found logo setting: ' . $rawValue);

                    // Try multiple locations
                    $locations = [
                        'configurations/' . basename($rawValue),
                        'settings/' . basename($rawValue),
                        $rawValue
                    ];

                    foreach ($locations as $location) {
                        if (Storage::disk('public')->exists($location)) {
                            $sourcePath = storage_path('app/public/' . $location);
                            $this->info('Found logo file: ' . $sourcePath);
                            break;
                        }
                    }

                    if (!$sourcePath) {
                        $this->warn('Logo setting exists but file not found in storage');
                        $this->line('Looking in: ' . implode(', ', $locations));
                    }
                } else {
                    $this->warn('Logo setting is empty or null');
                }
            } else {
                $this->warn('No site_logo setting found in database');
            }
        }

        if (!$sourcePath || !file_exists($sourcePath)) {
            $this->error('Source image not found!');
            $this->newLine();
            $this->line('Usage:');
            $this->line('  php artisan pwa:generate-icons /path/to/logo.png');
            $this->line('  php artisan pwa:generate-icons public/logo.png');
            return Command::FAILURE;
        }

        // Check if GD extension is available
        if (!extension_loaded('gd')) {
            $this->error('GD extension is not installed!');
            $this->line('Install it with: sudo apt-get install php-gd');
            return Command::FAILURE;
        }

        $this->newLine();
        $this->line('Source: ' . $sourcePath);
        $this->newLine();

        // Sizes to generate
        $sizes = [
            72,
            96,
            128,
            144,
            152,
            192,
            384,
            512
        ];

        $this->line('Generating icons...');
        $this->newLine();

        $allGood = true;

        foreach ($sizes as $size) {
            try {
                $outputPath = public_path("icon-{$size}x{$size}.png");

                // Read source image
                $sourceImage = imagecreatefromstring(file_get_contents($sourcePath));

                if (!$sourceImage) {
                    $this->error("  ✗ Failed to read source image");
                    continue;
                }

                // Create new image with target size
                $resizedImage = imagecreatetruecolor($size, $size);

                // Enable alpha blending for transparency
                imagealphablending($resizedImage, false);
                imagesavealpha($resizedImage, true);

                // Fill with transparent background
                $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
                imagefilledrectangle($resizedImage, 0, 0, $size, $size, $transparent);

                // Get source dimensions
                $sourceWidth = imagesx($sourceImage);
                $sourceHeight = imagesy($sourceImage);

                // Resize and copy
                imagecopyresampled(
                    $resizedImage,
                    $sourceImage,
                    0,
                    0,
                    0,
                    0,
                    $size,
                    $size,
                    $sourceWidth,
                    $sourceHeight
                );

                // Save
                imagepng($resizedImage, $outputPath, 9);

                // Clean up
                imagedestroy($resizedImage);
                imagedestroy($sourceImage);

                $this->info("  ✓ Generated: icon-{$size}x{$size}.png");
            } catch (\Exception $e) {
                $this->error("  ✗ Failed to generate {$size}x{$size}: " . $e->getMessage());
                $allGood = false;
            }
        }

        $this->newLine();
        $this->line(str_repeat('=', 60));

        if ($allGood) {
            $this->info('✓ All icons generated successfully!');
            $this->newLine();
            $this->line('Next steps:');
            $this->line('  1. Clear browser cache');
            $this->line('  2. Reload the website');
            $this->line('  3. Check with: php artisan pwa:check');
        } else {
            $this->warn('! Some icons failed to generate');
        }

        return $allGood ? Command::SUCCESS : Command::FAILURE;
    }
}