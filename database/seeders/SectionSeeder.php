<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'key' => 'products',
                'name' => json_encode(['en' => 'OUR Products', 'ar' => 'منتجاتنا']),
                'title' => json_encode(['en' => 'OUR Products', 'ar' => 'منتجاتنا']),
                'short_desc' => json_encode(['en' => 'Our Products', 'ar' => 'منتجاتنا']),
                'long_desc' => json_encode(['en' => 'Our Products', 'ar' => 'منتجاتنا']),
                'status' => 1,
            ],
            [
                'key' => 'about',
                'name' => json_encode(['en' => 'OUR About', 'ar' => 'عن الشركة']),
                'title' => json_encode(['en' => 'OUR About', 'ar' => 'عن الشركة']),
                'short_desc' => json_encode(['en' => 'Our About', 'ar' => 'عن الشركة']),
                'long_desc' => json_encode(['en' => 'Our About', 'ar' => 'عن الشركة']),
                'status' => 1,
            ],
            [
                'key' => 'services',
                'name' => json_encode(['en' => 'OUR Services', 'ar' => 'خدماتنا']),
                'title' => json_encode(['en' => 'OUR Services', 'ar' => 'خدماتنا']),
                'short_desc' => json_encode(['en' => 'Our Services', 'ar' => 'خدماتنا']),
                'long_desc' => json_encode(['en' => 'Our Services', 'ar' => 'خدماتنا']),
                'status' => 1,
            ],
            [
                'key' => 'projects',
                'name' => json_encode(['en' => 'OUR Projects', 'ar' => 'مشاريعنا']),
                'title' => json_encode(['en' => 'OUR Projects', 'ar' => 'مشاريعنا']),
                'short_desc' => json_encode(['en' => 'Our Projects', 'ar' => 'مشاريعنا']),
                'long_desc' => json_encode(['en' => 'Our Projects', 'ar' => 'مشاريعنا']),
                'status' => 1,
            ],
            [
                'key' => 'contact',
                'name' => json_encode(['en' => 'Contact Us', 'ar' => 'تواصل معنا']),
                'title' => json_encode(['en' => 'Contact Us', 'ar' => 'تواصل معنا']),
                'short_desc' => json_encode(['en' => 'Contact Us', 'ar' => 'تواصل معنا']),
                'long_desc' => json_encode(['en' => 'Contact Us', 'ar' => 'تواصل معنا']),
                'status' => 1,
            ],
            [
                'key' => 'blogs',
                'name' => json_encode(['en' => 'OUR Blogs', 'ar' => 'مدوناتنا']),
                'title' => json_encode(['en' => 'OUR Blogs', 'ar' => 'مدوناتنا']),
                'short_desc' => json_encode(['en' => 'Interesting articles updated daily', 'ar' => 'مقالات مثيرة للاهتمام يتم تحديثها يوميًا']),
                'long_desc' => json_encode(['en' => 'Interesting articles updated daily', 'ar' => 'مقالات مثيرة للاهتمام يتم تحديثها يوميًا']),
                'status' => 1,
            ],
        ];

        foreach ($data as $item) {
            Section::create($item);
        }
    }
}
