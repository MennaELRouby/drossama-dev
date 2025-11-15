<?php

namespace Database\Seeders;

use App\Models\Dashboard\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => json_encode(['en' => 'Home', 'ar' => 'الرئيسية','fr' => 'Accueil']),
                'segment' => '/',
                'parent_id' => null,
                'order' => 1,
                'status' => true,
            ],
            [
                'name' => json_encode(['en' => 'About Us', 'ar' => 'من نحن','fr' => 'À propos de nous']),
                'segment' => '/about-us',
                'parent_id' => null,
                'order' => 2,
                'status' => true,
            ],

            [
                'name' => json_encode(['en' => 'Our Services', 'ar' => 'الخدمات','fr' => 'Nos services']),
                'segment' => '/services',
                'parent_id' => null,
                'order' => 3,
                'status' => true,
            ],
            [
                'name' => json_encode(['en' => 'Our Products', 'ar' => 'المنتجات','fr' => 'Nos produits']),
                'segment' => '/products',
                'parent_id' => null,
                'order' => 4,
                'status' => true,
            ],
            [
                'name' => json_encode(['en' => 'Our Projects', 'ar' => 'المشاريع','fr' => 'Nos projets']),
                'segment' => '/projects',
                'parent_id' => null,
                'order' => 5,
                'status' => true,
            ],
            [
                'name' => json_encode(['en' => 'careers', 'ar' => 'الوظائف','fr' => 'Nos carrières']),
                'segment' => '/careers',
                'parent_id' => null,
                'order' => 5,
                'status' => true,
            ],

            [
                'name' => json_encode(['en' => 'News & Articles', 'ar' => 'الأخبار والمقالات','fr' => 'Actualités et articles']),
                'segment' => '/blogs',
                'parent_id' => null,
                'order' => 6,
                'status' => true,
            ],
            [
                'name' => json_encode(['en' => 'Contact Us', 'ar' => 'تواصل معنا','fr' => 'Contactez-nous']),
                'segment' => '/contact-us',
                'parent_id' => null,
                'order' => 7,
                'status' => true,
            ],
            // مثال على قائمة رئيسية بدون رابط
            [
                'name' => json_encode(['en' => 'Media', 'ar' => 'الميديا','fr' => 'Média']),
                'segment' => '#',
                'parent_id' => null,
                'order' => 8,
                'status' => true,
            ]
        ];

        foreach ($data as $item) {
            Menu::updateOrCreate(
                ['segment' => $item['segment']],
                $item
            );
        }

        // إضافة القوائم الفرعية لقائمة "الميديا"
        $mediaMenu = Menu::where('segment', '#')->first();

        if ($mediaMenu) {
            $subMenus = [
                [
                    'name' => json_encode(['en' => 'Photos', 'ar' => ' صور','fr' => 'photos']),
                    'segment' => '/gallery-photos',
                    'parent_id' => $mediaMenu->id,
                    'order' => 1,
                    'status' => true,
                ],
                [
                    'name' => json_encode(['en' => 'Videos', 'ar' => 'فيديوهات','fr' => 'vidéos']),
                    'segment' => '/gallery-videos',
                    'parent_id' => $mediaMenu->id,
                    'order' => 2,
                    'status' => true,
                ]
            ];

            foreach ($subMenus as $subMenu) {
                Menu::updateOrCreate(
                    ['segment' => $subMenu['segment']],
                    $subMenu
                );
            }
        }
    }
}