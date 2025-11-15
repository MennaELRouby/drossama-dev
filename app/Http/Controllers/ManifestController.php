<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\PwaSetting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ManifestController extends Controller
{
    /**
     * Generate dynamic manifest.json
     */
    public function manifest(): JsonResponse
    {
        try {
            // Get current locale
            $currentLocale = app()->getLocale();

            // Get PWA settings from database with cache
            $pwaSettings = Cache::remember('pwa_settings', 3600, function () {
                return PwaSetting::getActiveSettings();
            });

            // Ensure we have settings (fallback to defaults if null)
            if (!$pwaSettings) {
                $pwaSettings = PwaSetting::getDefaultSettings();
            }

            // Get site name and description based on current locale with fallbacks
            $siteName = $currentLocale === 'ar' ?
                ($pwaSettings->name_ar ?? \App\Helper\Path::AppName('site_name')) : ($pwaSettings->name_en ?? \App\Helper\Path::AppName('site_name'));

            $siteDescription = $currentLocale === 'ar' ?
                ($pwaSettings->description_ar ?? strip_tags(config('configrations.site_description', 'Progressive Web App'))) : ($pwaSettings->description_en ?? strip_tags(config('configrations.site_description', 'Progressive Web App')));

            $siteShortName = $currentLocale === 'ar' ?
                ($pwaSettings->short_name_ar ?? \App\Helper\Path::AppName('site_name')) : ($pwaSettings->short_name_en ?? \App\Helper\Path::AppName('site_name'));

            // Get theme colors with fallbacks
            $themeColor = $pwaSettings->theme_color ?? '#1e40af';
            $backgroundColor = $pwaSettings->background_color ?? '#ffffff';

            // Use website logo from settings
            $logoUrl = \App\Helper\Path::AppLogo('site_logo');

            // Get current locale
            $isRTL = $currentLocale === 'ar';

            // Generate shortcuts based on PWA settings
            $shortcuts = $pwaSettings->shortcuts ?? $this->generateDefaultShortcuts($currentLocale);

            // Ensure shortcuts is an array
            if (is_string($shortcuts)) {
                $shortcuts = json_decode($shortcuts, true) ?? $this->generateDefaultShortcuts($currentLocale);
            }

            if (!is_array($shortcuts)) {
                $shortcuts = $this->generateDefaultShortcuts($currentLocale);
            }

            // Ensure all shortcuts have icons
            foreach ($shortcuts as &$shortcut) {
                if (!isset($shortcut['icons']) || empty($shortcut['icons'])) {
                    $shortcut['icons'] = $this->getShortcutIcons();
                }
            }

            // Generate icons array
            $icons = $this->generateIcons($logoUrl);

            // Get current base URL dynamically
            $baseUrl = url('/');
            $currentPath = request()->getPathInfo();

            // Extract subdirectory automatically from the current URL
            $subdirectory = '';
            $parsedUrl = parse_url($baseUrl);
            $path = $parsedUrl['path'] ?? '';

            // Remove trailing slash and get the subdirectory
            $path = rtrim($path, '/');
            if ($path && $path !== '/') {
                $subdirectory = $path;
            }

            $manifest = [
                'name' => $siteName,
                'short_name' => $siteShortName,
                'description' => $siteDescription,
                'start_url' => $pwaSettings->start_url ?: ($subdirectory . '/' . $currentLocale),
                'display' => $pwaSettings->display,
                'background_color' => $backgroundColor,
                'theme_color' => $themeColor,
                'orientation' => $pwaSettings->orientation,
                'icons' => $icons,
                'categories' => $this->ensureArray($pwaSettings->categories ?? ['business', 'productivity', 'utilities']),
                'lang' => $pwaSettings->lang,
                'dir' => $pwaSettings->dir,
                'scope' => $pwaSettings->scope ?: ($subdirectory . '/'),
                'prefer_related_applications' => false,
                'related_applications' => [],
                'screenshots' => [],
                'shortcuts' => $shortcuts
            ];

            return response()->json($manifest)
                ->header('Content-Type', 'application/manifest+json')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate') // Force refresh
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Manifest generation error: ' . $e->getMessage());

            // Return a minimal valid manifest as fallback
            $fallbackManifest = [
                'name' => \App\Helper\Path::AppName('site_name'),
                'short_name' => \App\Helper\Path::AppName('site_name'),
                'description' => strip_tags(config('configrations.site_description', 'Progressive Web App')),
                'start_url' => '/',
                'display' => 'standalone',
                'background_color' => '#ffffff',
                'theme_color' => '#1e40af',
                'orientation' => 'portrait',
                'icons' => [
                    [
                        'src' => asset('favicon.ico'),
                        'sizes' => '16x16 32x32 48x48',
                        'type' => 'image/x-icon'
                    ]
                ],
                'lang' => 'ar',
                'dir' => 'rtl',
                'scope' => '/',
                'shortcuts' => $this->generateDefaultShortcuts('ar')
            ];

            return response()->json($fallbackManifest)
                ->header('Content-Type', 'application/manifest+json')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }
    }

    /**
     * Generate default shortcuts if none are set in PWA settings
     */
    private function generateDefaultShortcuts(string $locale): array
    {
        $shortcuts = [];

        // Get current base URL dynamically
        $baseUrl = url('/');
        $parsedUrl = parse_url($baseUrl);
        $path = $parsedUrl['path'] ?? '';

        // Remove trailing slash and get the subdirectory
        $path = rtrim($path, '/');
        $subdirectory = ($path && $path !== '/') ? $path : '';

        // Home shortcut
        $shortcuts[] = [
            'name' => $locale === 'ar' ? 'الصفحة الرئيسية' : 'Home',
            'short_name' => $locale === 'ar' ? 'الرئيسية' : 'Home',
            'description' => $locale === 'ar' ? 'الصفحة الرئيسية للموقع' : 'Website Homepage',
            'url' => $subdirectory . '/' . $locale,
            'icons' => $this->getShortcutIcons()
        ];

        // Services shortcut
        $shortcuts[] = [
            'name' => $locale === 'ar' ? 'الخدمات' : 'Services',
            'short_name' => $locale === 'ar' ? 'الخدمات' : 'Services',
            'description' => $locale === 'ar' ? 'خدماتنا المتاحة' : 'Our Services',
            'url' => $subdirectory . '/' . $locale . '/services',
            'icons' => $this->getShortcutIcons()
        ];

        return $shortcuts;
    }

    /**
     * Generate shortcuts based on available menus/pages
     */
    private function generateShortcuts(string $locale): array
    {
        $shortcuts = [];

        // Get current base URL dynamically
        $baseUrl = url('/');
        $parsedUrl = parse_url($baseUrl);
        $path = $parsedUrl['path'] ?? '';

        // Remove trailing slash and get the subdirectory
        $path = rtrim($path, '/');
        $subdirectory = ($path && $path !== '/') ? $path : '';

        // Home shortcut
        $shortcuts[] = [
            'name' => $locale === 'ar' ? 'الصفحة الرئيسية' : 'Home',
            'short_name' => $locale === 'ar' ? 'الرئيسية' : 'Home',
            'description' => $locale === 'ar' ? 'الصفحة الرئيسية للموقع' : 'Website Homepage',
            'url' => $subdirectory . '/' . $locale,
            'icons' => [
                [
                    'src' => asset('favicon.ico'),
                    'sizes' => '16x16 32x32 48x48'
                ]
            ]
        ];

        // Services shortcut
        $shortcuts[] = [
            'name' => $locale === 'ar' ? 'الخدمات' : 'Services',
            'short_name' => $locale === 'ar' ? 'الخدمات' : 'Services',
            'description' => $locale === 'ar' ? 'خدماتنا المتاحة' : 'Our Services',
            'url' => $subdirectory . '/' . $locale . '/services',
            'icons' => [
                [
                    'src' => asset('favicon.ico'),
                    'sizes' => '16x16 32x32 48x48'
                ]
            ]
        ];

        // Products shortcut
        $shortcuts[] = [
            'name' => $locale === 'ar' ? 'المنتجات' : 'Products',
            'short_name' => $locale === 'ar' ? 'المنتجات' : 'Products',
            'description' => $locale === 'ar' ? 'منتجاتنا المتاحة' : 'Our Products',
            'url' => $subdirectory . '/' . $locale . '/products',
            'icons' => [
                [
                    'src' => asset('favicon.ico'),
                    'sizes' => '16x16 32x32 48x48'
                ]
            ]
        ];

        // Contact shortcut
        $shortcuts[] = [
            'name' => $locale === 'ar' ? 'اتصل بنا' : 'Contact Us',
            'short_name' => $locale === 'ar' ? 'اتصل بنا' : 'Contact',
            'description' => $locale === 'ar' ? 'تواصل معنا' : 'Get in Touch',
            'url' => $subdirectory . '/' . $locale . '/contact',
            'icons' => [
                [
                    'src' => asset('favicon.ico'),
                    'sizes' => '16x16 32x32 48x48'
                ]
            ]
        ];

        return $shortcuts;
    }

    /**
     * Generate icons array based on website logo
     */
    public function generateIcons(string $logoUrl): array
    {
        $icons = [];

        // Add favicon if it exists
        $faviconPath = public_path('favicon.ico');
        if (file_exists($faviconPath)) {
            $icons[] = [
                'src' => asset('favicon.ico'),
                'sizes' => '16x16 32x32 48x48',
                'type' => 'image/x-icon'
            ];
        }

        // Check for dedicated PWA icons in public directory
        $pwaIconSizes = [
            '72x72' => 'icon-72x72.png',
            '96x96' => 'icon-96x96.png',
            '128x128' => 'icon-128x128.png',
            '144x144' => 'icon-144x144.png',
            '152x152' => 'icon-152x152.png',
            '192x192' => 'icon-192x192.png',
            '384x384' => 'icon-384x384.png',
            '512x512' => 'icon-512x512.png'
        ];

        foreach ($pwaIconSizes as $size => $filename) {
            $iconPath = public_path($filename);

            // If dedicated PWA icon exists, use it
            if (file_exists($iconPath)) {
                $icons[] = [
                    'src' => asset($filename),
                    'sizes' => $size,
                    'type' => 'image/png',
                    'purpose' => 'any'
                ];
            } else {
                // Fallback to website logo
                $icons[] = [
                    'src' => $logoUrl,
                    'sizes' => $size,
                    'type' => 'image/png',
                    'purpose' => 'any'
                ];
            }
        }

        // Add maskable icons for better display on Android
        foreach (['192x192', '512x512'] as $size) {
            $icons[] = [
                'src' => $logoUrl,
                'sizes' => $size,
                'type' => 'image/png',
                'purpose' => 'maskable'
            ];
        }

        return $icons;
    }

    /**
     * Generate screenshots for PWA Install UI
     */
    private function generateScreenshots(): array
    {
        $screenshots = [];

        // Check if we have screenshot images
        $mobileScreenshot = public_path('assets/website/images/screenshot-mobile.png');
        $desktopScreenshot = public_path('assets/website/images/screenshot-desktop.png');

        // Mobile screenshot (narrow)
        if (file_exists($mobileScreenshot)) {
            $screenshots[] = [
                'src' => asset('assets/website/images/screenshot-mobile.png'),
                'sizes' => '390x844',
                'type' => 'image/png',
                'form_factor' => 'narrow'
            ];
        }

        // Desktop screenshot (wide)
        if (file_exists($desktopScreenshot)) {
            $screenshots[] = [
                'src' => asset('assets/website/images/screenshot-desktop.png'),
                'sizes' => '1280x720',
                'type' => 'image/png',
                'form_factor' => 'wide'
            ];
        }

        return $screenshots;
    }

    /**
     * Get icons for shortcuts (96x96 recommended)
     */
    private function getShortcutIcons(): array
    {
        $icons = [];

        // Use dynamic logo for shortcuts (always use current logo)
        $websiteLogo = \App\Helper\Path::AppLogo('site_logo');

        $icons[] = [
            'src' => $websiteLogo,
            'sizes' => '96x96',
            'type' => 'image/webp'
        ];

        return $icons;
    }

    /**
     * Ensure a value is an array
     */
    private function ensureArray($value): array
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [$value];
        }

        if (is_array($value)) {
            return $value;
        }

        return [$value];
    }
}
