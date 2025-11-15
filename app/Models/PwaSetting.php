<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PwaSetting extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'short_name_ar',
        'short_name_en',
        'description_ar',
        'description_en',
        'theme_color',
        'background_color',
        'start_url',
        'scope',
        'orientation',
        'display',
        'lang',
        'dir',
        'shortcuts',
        'categories',
        'status'
    ];

    protected $casts = [
        'shortcuts' => 'array',
        'categories' => 'array',
        'status' => 'boolean'
    ];

    /**
     * Get the current active PWA settings
     */
    public static function getActiveSettings()
    {
        return self::where('status', true)->first() ?? self::getDefaultSettings();
    }

    /**
     * Get default PWA settings
     */
    public static function getDefaultSettings()
    {
        return new self([
            'name_ar' => 'DHI Egypt',
            'name_en' => 'DHI Egypt',
            'short_name_ar' => 'DHI Egypt',
            'short_name_en' => 'DHI Egypt',
            'description_ar' => strip_tags(config('configrations.site_description', 'Progressive Web App')),
            'description_en' => strip_tags(config('configrations.site_description', 'Progressive Web App')),
            'theme_color' => '#1e40af',
            'background_color' => '#ffffff',
            'start_url' => '/',
            'scope' => '/',
            'orientation' => 'portrait',
            'display' => 'standalone',
            'lang' => 'ar',
            'dir' => 'rtl',
            'shortcuts' => [
                [
                    'name' => 'الصفحة الرئيسية',
                    'short_name' => 'الرئيسية',
                    'description' => 'الصفحة الرئيسية للموقع',
                    'url' => '/',
                    'icons' => [
                        [
                            'src' => '/favicon.ico',
                            'sizes' => '16x16 32x32 48x48'
                        ]
                    ]
                ],
                [
                    'name' => 'خدماتنا',
                    'short_name' => 'الخدمات',
                    'description' => 'خدماتنا المتاحة',
                    'url' => '/ar/services',
                    'icons' => [
                        [
                            'src' => '/favicon.ico',
                            'sizes' => '16x16 32x32 48x48'
                        ]
                    ]
                ]
            ],
            'categories' => ['business', 'productivity', 'utilities'],
            'status' => true
        ]);
    }
}
