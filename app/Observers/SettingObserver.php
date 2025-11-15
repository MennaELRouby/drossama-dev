<?php

namespace App\Observers;

use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SettingObserver
{
    /**
     * Handle the Setting "updated" event.
     */
    public function updated(Setting $setting): void
    {
        // Check if any site_logo was updated (any language)
        if ($setting->key === 'site_logo' && $setting->isDirty('value')) {
            // Get raw value (without accessor) to avoid getting full URL
            $rawValue = $setting->getAttributes()['value'] ?? null;

            if ($rawValue) {
                Log::info("PWA Icons: Logo updated (lang: {$setting->lang}), triggering regeneration");

                // If not 'all', also update 'all' to keep them in sync
                if ($setting->lang !== 'all') {
                    Setting::updateOrCreate(
                        ['key' => 'site_logo', 'lang' => 'all'],
                        ['value' => $rawValue]
                    );
                    Log::info("PWA Icons: Synced logo to lang='all'");
                }

                $this->regeneratePWAIcons($rawValue);
            }
        }
    }

    /**
     * Handle the Setting "created" event.
     */
    public function created(Setting $setting): void
    {
        // Also regenerate icons when logo is first created (any language)
        if ($setting->key === 'site_logo') {
            // Get raw value (without accessor)
            $rawValue = $setting->getAttributes()['value'] ?? null;

            if ($rawValue) {
                Log::info("PWA Icons: Logo created (lang: {$setting->lang}), triggering regeneration");

                // If not 'all', also create 'all'
                if ($setting->lang !== 'all') {
                    Setting::updateOrCreate(
                        ['key' => 'site_logo', 'lang' => 'all'],
                        ['value' => $rawValue]
                    );
                    Log::info("PWA Icons: Created logo for lang='all'");
                }

                $this->regeneratePWAIcons($rawValue);
            }
        }
    }

    /**
     * Regenerate PWA icons from the new logo
     */
    private function regeneratePWAIcons(string $logoValue): void
    {
        try {
            // Skip if it's a full URL
            if (str_starts_with($logoValue, 'http://') || str_starts_with($logoValue, 'https://')) {
                Log::info('PWA Icons: Logo is external URL, skipping auto-generation');
                return;
            }

            // Skip if it's the default noimage placeholder
            if (str_contains($logoValue, 'noimage.png')) {
                Log::info('PWA Icons: Logo is placeholder image, skipping auto-generation');
                return;
            }

            // Build the full path to the logo - try multiple locations
            $logoPath = null;

            // Check in configurations folder
            $configPath = 'configurations/' . basename($logoValue);
            if (Storage::disk('public')->exists($configPath)) {
                $logoPath = storage_path('app/public/' . $configPath);
            }

            // Check in settings folder
            if (!$logoPath) {
                $settingsPath = 'settings/' . basename($logoValue);
                if (Storage::disk('public')->exists($settingsPath)) {
                    $logoPath = storage_path('app/public/' . $settingsPath);
                }
            }

            // Check direct path
            if (!$logoPath && Storage::disk('public')->exists($logoValue)) {
                $logoPath = storage_path('app/public/' . $logoValue);
            }

            if (!$logoPath || !file_exists($logoPath)) {
                Log::warning('PWA Icons: Logo file not found at: ' . ($logoValue ?? 'null'));
                return;
            }

            Log::info('PWA Icons: Auto-generating icons from new logo: ' . $logoPath);

            // Check if GD extension is available
            if (!extension_loaded('gd')) {
                Log::warning('PWA Icons: GD extension not available, skipping auto-generation');
                return;
            }

            // Generate icons
            $sizes = [72, 96, 128, 144, 152, 192, 384, 512];

            foreach ($sizes as $size) {
                $outputPath = public_path("icon-{$size}x{$size}.png");

                // Read source image
                $sourceImage = @imagecreatefromstring(file_get_contents($logoPath));

                if (!$sourceImage) {
                    Log::warning("PWA Icons: Failed to read source image for size {$size}x{$size}");
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
            }

            Log::info('PWA Icons: Successfully generated all icon sizes');

            // Clear manifest cache
            Artisan::call('cache:forget', ['key' => 'pwa_settings']);
        } catch (\Exception $e) {
            Log::error('PWA Icons: Auto-generation failed: ' . $e->getMessage());
        }
    }
}