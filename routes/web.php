<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Root redirect - MUST BE FIRST  
Route::get('/', function () {
    // Always redirect to Arabic (default locale) with proper URL structure
    return redirect('/ar');
})->name('root.redirect');

// Redirect root URL to default locale
Route::get('/redirect-root', function () {
    $locale = LaravelLocalization::getCurrentLocale();
    if (!$locale) {
        $locale = LaravelLocalization::getDefaultLocale();
    }
    return redirect(LaravelLocalization::getLocalizedURL($locale));
});

// Authentication routes
Auth::routes();

// Offline page route
Route::get('/offline', function () {
    // Get site settings
    $site_name = \App\Models\Setting::where('key', 'site_name')->first();
    $whatsapp_number = \App\Models\Setting::where('key', 'site_whatsapp')->first();

    $settings = (object) [
        'site_name' => $site_name ? $site_name->value : config('app.name', 'Tulip'),
        'whatsapp_number' => $whatsapp_number ? $whatsapp_number->value : null
    ];

    // Load dynamic contact info with error handling
    $phones = collect();
    $site_addresses = collect();

    try {
        $phones = \App\Models\Phone::active()->get();
    } catch (\Exception $e) {
        Log::warning('Failed to load phones for offline page: ' . $e->getMessage());
    }

    try {
        $site_addresses = \App\Models\SiteAddress::active()->orderBy('order')->get();
    } catch (\Exception $e) {
        Log::warning('Failed to load site addresses for offline page: ' . $e->getMessage());
    }

    // Load social media links
    $socialMediaLinks = [
        'whatsapp' => config('settings.site_whatsapp') ? 'https://wa.me/' . ltrim(config('settings.site_whatsapp'), '+') : '#',
        'facebook' => config('settings.site_facebook') ?? '#',
        'twitter' => config('settings.site_twitter') ?? '#',
        'instagram' => config('settings.site_instagram') ?? '#',
        'youtube' => config('settings.site_youtube') ?? '#',
        'linkedin' => config('settings.site_linkedin') ?? '#',
        'tiktok' => config('settings.site_tiktok') ?? '#',
        'snapchat' => config('settings.site_snapchat') ?? '#',
        'pinterest' => config('settings.site_pinterest') ?? '#',
        'telegram' => config('settings.site_telegram') ?? '#',
    ];

    return view('offline', compact('settings', 'phones', 'site_addresses', 'socialMediaLinks'));
})->name('offline');

// API endpoint for offline page data
Route::get('/api/offline-data', [\App\Http\Controllers\OfflineController::class, 'getOfflineData'])->name('api.offline-data');

// Dynamic manifest.json
Route::get('/manifest.json', [\App\Http\Controllers\ManifestController::class, 'manifest'])->name('manifest');

// Dynamic robots.txt - make it accessible from both root and subdirectory
Route::get('/robots.txt', function () {
    $robotsContent = "User-agent: *\nAllow: /\n\n# Sitemap\nSitemap: " . url('/sitemap.xml') . "\n\n# Block sensitive directories\nDisallow: /dashboard/\nDisallow: /admin/\nDisallow: /storage/\nDisallow: /vendor/\nDisallow: /config/\nDisallow: /database/\nDisallow: /bootstrap/cache/\nDisallow: /.env\nDisallow: /composer.json\nDisallow: /composer.lock\nDisallow: /artisan\n\n# Allow important files\nAllow: /storage/uploads/\nAllow: /assets/\n\n# Crawl delay (optional)\n# Crawl-delay: 1";

    return response($robotsContent)
        ->header('Content-Type', 'text/plain')
        ->header('Cache-Control', 'public, max-age=3600'); // Cache for 1 hour
})->name('robots');


// Website routes are loaded in bootstrap/app.php via localized routing
