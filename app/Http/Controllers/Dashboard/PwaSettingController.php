<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PwaSetting;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PwaSettingController extends Controller
{
    /**
     * Display PWA settings (single setting approach)
     */
    public function index()
    {
        $pwaSetting = PwaSetting::firstOr(function () {
            // Create default PWA setting if none exists
            return PwaSetting::create([
                'name_ar' => 'ديار للتطوير العقاري',
                'name_en' => 'Diyar',
                'short_name_ar' => 'ديار للتطوير',
                'short_name_en' => 'Diyar D',
                'description_ar' => 'خدمات تطوير الويب والحلول الرقمية المتكاملة',
                'description_en' => 'Comprehensive web development services and digital solutions',
                'theme_color' => '#007bff',
                'background_color' => '#ffffff',
                'start_url' => '/',
                'scope' => '/',
                'orientation' => 'portrait-primary',
                'display' => 'standalone',
                'lang' => 'ar',
                'dir' => 'rtl',
                'status' => true,
            ]);
        });

        return view('Dashboard.PwaSettings.index', compact('pwaSetting'));
    }

    /**
     * Show the form for editing PWA settings
     */
    public function edit(PwaSetting $pwaSetting)
    {
        return view('Dashboard.PwaSettings.edit', compact('pwaSetting'));
    }

    /**
     * Update PWA settings
     */
    public function update(Request $request, PwaSetting $pwaSetting)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'short_name_ar' => 'required|string|max:50',
            'short_name_en' => 'required|string|max:50',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'theme_color' => 'required|string|max:7',
            'background_color' => 'required|string|max:7',
            'start_url' => 'required|string',
            'scope' => 'required|string',
            'orientation' => 'required|string',
            'display' => 'required|string',
            'lang' => 'required|string|max:5',
            'dir' => 'required|string|max:3',
        ]);

        $pwaSetting->update($request->all());

        // Clear cache
        Cache::forget('pwa_settings');

        return redirect()->route('dashboard.pwa-settings.index')
            ->with('success', 'تم تحديث إعدادات PWA بنجاح');
    }

    /**
     * Regenerate PWA icons from current logo
     */
    public function regenerateIcons(Request $request)
    {
        try {
            // Get current logo
            $logoSetting = Setting::where('key', 'site_logo')
                ->where('lang', 'all')
                ->first();

            if (!$logoSetting || !$logoSetting->value) {
                return back()->with('error', __('dashboard.no_logo_found'));
            }

            $logoValue = $logoSetting->value;

            // Skip if it's a full URL (external or noimage.png)
            if (str_starts_with($logoValue, 'http://') || str_starts_with($logoValue, 'https://')) {
                return back()->with('error', __('dashboard.logo_is_external_url'));
            }

            // Skip if it's the default noimage placeholder
            if (str_contains($logoValue, 'noimage.png')) {
                return back()->with('error', __('dashboard.please_upload_logo_first'));
            }

            // Build logo path - try multiple locations
            $logoPath = null;

            // Try configurations folder
            $configPath = 'configurations/' . basename($logoValue);
            if (Storage::disk('public')->exists($configPath)) {
                $logoPath = storage_path('app/public/' . $configPath);
            }

            // Try settings folder
            if (!$logoPath) {
                $settingsPath = 'settings/' . basename($logoValue);
                if (Storage::disk('public')->exists($settingsPath)) {
                    $logoPath = storage_path('app/public/' . $settingsPath);
                }
            }

            // Try direct path in storage
            if (!$logoPath && Storage::disk('public')->exists($logoValue)) {
                $logoPath = storage_path('app/public/' . $logoValue);
            }

            if (!$logoPath || !file_exists($logoPath)) {
                return back()->with('error', __('dashboard.logo_file_not_found') . ' (' . basename($logoValue) . ')');
            }

            // Check GD extension
            if (!extension_loaded('gd')) {
                return back()->with('error', __('dashboard.gd_extension_required'));
            }

            // Generate icons
            $sizes = [72, 96, 128, 144, 152, 192, 384, 512];
            $successCount = 0;

            foreach ($sizes as $size) {
                $outputPath = public_path("icon-{$size}x{$size}.png");

                $sourceImage = @imagecreatefromstring(file_get_contents($logoPath));
                if (!$sourceImage) continue;

                $resizedImage = imagecreatetruecolor($size, $size);
                imagealphablending($resizedImage, false);
                imagesavealpha($resizedImage, true);

                $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
                imagefilledrectangle($resizedImage, 0, 0, $size, $size, $transparent);

                $sourceWidth = imagesx($sourceImage);
                $sourceHeight = imagesy($sourceImage);

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

                imagepng($resizedImage, $outputPath, 9);
                imagedestroy($resizedImage);
                imagedestroy($sourceImage);

                $successCount++;
            }

            // Clear manifest cache
            Cache::forget('pwa_settings');

            if ($successCount === count($sizes)) {
                return back()->with('success', __('dashboard.icons_generated_successfully', ['count' => $successCount]));
            } else {
                return back()->with('warning', __('dashboard.icons_partially_generated', ['count' => $successCount, 'total' => count($sizes)]));
            }
        } catch (\Exception $e) {
            Log::error('PWA Icons regeneration failed: ' . $e->getMessage());
            return back()->with('error', __('dashboard.icons_generation_failed') . ': ' . $e->getMessage());
        }
    }
}
