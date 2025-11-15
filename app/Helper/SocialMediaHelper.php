<?php

namespace App\Helper;

class SocialMediaHelper
{
    /**
     * Get social media links array from config settings
     *
     * @return array
     */
    public static function getSocialMediaLinks(): array
    {
        return [
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
    }
}
