<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use App\Models\SiteAddress;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OfflineController extends Controller
{
    /**
     * Get offline page data
     */
    public function getOfflineData(Request $request)
    {
        try {
            // Get language from request or default to current locale
            $lang = $request->get('lang', app()->getLocale());

            // Cache key for offline data
            $cacheKey = "offline_data_{$lang}";

            // Try to get from cache first
            $data = Cache::remember($cacheKey, 3600, function () use ($lang) {
                return $this->buildOfflineData($lang);
            });

            return response()->json($data);
        } catch (\Exception $e) {
            // Return fallback data in case of error
            return response()->json($this->getFallbackData($request->get('lang', app()->getLocale())));
        }
    }

    /**
     * Build offline data from database
     */
    private function buildOfflineData($lang)
    {
        // Get site settings
        $settings = Setting::where('lang', 'all')
            ->orWhere('lang', $lang)
            ->pluck('value', 'key')
            ->toArray();

        // Get site name in current language
        $siteName = $settings['site_name'] ?? 'Tulip';

        // Get phones
        $phones = Phone::active()
            ->orderBy('order', 'asc')
            ->get()
            ->map(function ($phone) {
                return [
                    'name' => $phone->name,
                    'phone' => ($phone->code ?? '') . $phone->phone,
                    'email' => $phone->email,
                ];
            });

        // Get site addresses
        $addresses = SiteAddress::active()
            ->orderBy('order', 'asc')
            ->get()
            ->map(function ($address) {
                return [
                    'title' => $address->title,
                    'address' => $address->address,
                ];
            });

        // Build social media links
        $socialLinks = [
            'whatsapp' => $settings['site_whatsapp'] ? 'https://wa.me/' . ltrim($settings['site_whatsapp'], '+') : null,
            'facebook' => $settings['site_facebook'] ?? null,
            'twitter' => $settings['site_twitter'] ?? null,
            'instagram' => $settings['site_instagram'] ?? null,
            'youtube' => $settings['site_youtube'] ?? null,
            'linkedin' => $settings['site_linkedin'] ?? null,
            'tiktok' => $settings['site_tiktok'] ?? null,
            'snapchat' => $settings['site_snapchat'] ?? null,
            'pinterest' => $settings['site_pinterest'] ?? null,
            'telegram' => $settings['site_telegram'] ?? null,
        ];

        // Filter out empty social links
        $socialLinks = array_filter($socialLinks, function ($link) {
            return !empty($link) && $link !== '#';
        });

        return [
            'siteName' => $siteName,
            'phones' => $phones,
            'addresses' => $addresses,
            'socialLinks' => $socialLinks,
            'siteEmail' => $settings['site_email'] ?? null,
            'language' => $lang,
        ];
    }

    /**
     * Get fallback data when database is not available
     */
    private function getFallbackData($lang)
    {
        $isArabic = $lang === 'ar';

        return [
            'siteName' => 'Tulip',
            'phones' => [
                [
                    'name' => $isArabic ? 'اتصل بنا' : 'Call Us',
                    'phone' => '+20-xxx-xxx-xxxx',
                    'email' => 'info@tulip.com',
                ]
            ],
            'addresses' => [
                [
                    'title' => $isArabic ? 'العنوان' : 'Address',
                    'address' => $isArabic ? 'القاهرة، مصر' : 'Cairo, Egypt',
                ]
            ],
            'socialLinks' => [
                'whatsapp' => 'https://wa.me/201234567890',
                'facebook' => 'https://facebook.com/tulip',
                'twitter' => 'https://twitter.com/tulip',
                'instagram' => 'https://instagram.com/tulip',
                'linkedin' => 'https://linkedin.com/company/tulip',
                'youtube' => 'https://youtube.com/tulip',
            ],
            'siteEmail' => 'info@tulip.com',
            'language' => $lang,
        ];
    }
}
