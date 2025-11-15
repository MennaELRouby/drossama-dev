<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PwaSetting;

class PwaSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PwaSetting::create([
            'name_ar' => 'ديار',
            'name_en' => 'Diyar',
            'short_name_ar' => 'ديار',
            'short_name_en' => 'Diyar',
            'description_ar' => 'تطبيق ويب تقدمي لديار',
            'description_en' => 'Progressive Web App for Diyar',
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
                    'url' => '/ar',
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
                ],
                [
                    'name' => 'منتجاتنا',
                    'short_name' => 'المنتجات',
                    'description' => 'منتجاتنا المتاحة',
                    'url' => '/ar/products',
                    'icons' => [
                        [
                            'src' => '/favicon.ico',
                            'sizes' => '16x16 32x32 48x48'
                        ]
                    ]
                ],
                [
                    'name' => 'اتصل بنا',
                    'short_name' => 'اتصل بنا',
                    'description' => 'تواصل معنا',
                    'url' => '/ar/contact',
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
