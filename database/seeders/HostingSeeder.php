<?php

namespace Database\Seeders;

use App\Models\Dashboard\Hosting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HostingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hosting::factory()->count(30)->create();
        $data = [
            [
                'name_ar' => 'الاستضافة المشتركة',
                'name_en' => 'Shared Hosting',
                'short_desc_ar' => 'استضافة مشتركة سريعة وآمنة',
                'short_desc_en' => 'Fast and secure shared hosting',
                'long_desc_ar' => 'استضافة مشتركة موثوقة وسريعة مع دعم فني على مدار الساعة',
                'long_desc_en' => 'Reliable and fast shared hosting with 24/7 support',
                'status' => 1,
                'show_in_home'=> 1,
                'show_in_header'=> 1,
                'slug_ar' => 'الاستضافة-المشتركة',
                'slug_en' => 'shared-hosting',
                'meta_title_ar' => 'استضافة مشتركة',
                'meta_title_en' => 'Shared Hosting',
                'meta_desc_ar' => 'استضافة مشتركة موثوقة وسريعة مع دعم فني على مدار الساعة',
                'meta_desc_en' => 'Reliable and fast shared hosting with 24/7 support',
                'index' => 1,
            ],
            [
                'name_ar' => 'استضافة VPS',
                'name_en' => 'VPS Hosting',
                'short_desc_ar' => 'استضافة VPS مرنة وقابلة للتخصيص',
                'short_desc_en' => 'Flexible and customizable VPS hosting',
                'long_desc_ar' => 'استضافة VPS موثوقة مع موارد مخصصة وأداء عالٍ',
                'long_desc_en' => 'Reliable VPS hosting with dedicated resources and high performance',
                'status' => 1,
                'show_in_home'=> 1,
                'show_in_header'=> 1,
                'slug_ar' => 'استضافة-vps',
                'slug_en' => 'vps-hosting',
                'meta_title_ar' => 'استضافة VPS',
                'meta_title_en' => 'VPS Hosting',
                'meta_desc_ar' => 'استضافة VPS موثوقة مع موارد مخصصة وأداء عالٍ',
                'meta_desc_en' => 'Reliable VPS hosting with dedicated resources and high performance',
                'index' => 1,
            ],
            [
                'name_ar' => 'استضافة مخصصة',
                'name_en' => 'Dedicated Hosting',
                'short_desc_ar' => 'استضافة مخصصة عالية الأداء',
                'short_desc_en' => 'High-performance dedicated hosting',
                'long_desc_ar' => 'استضافة مخصصة مع موارد كاملة وأداء عالٍ',
                'long_desc_en' => 'Dedicated hosting with full resources and high performance',
                'status' => 1,
                'show_in_home'=> 1,
                'show_in_header'=> 1,
                'slug_ar' => 'استضافة-مخصصة',
                'slug_en' => 'dedicated-hosting',
                'meta_title_ar' => 'استضافة مخصصة',
                'meta_title_en' => 'Dedicated Hosting',
                'meta_desc_ar' => 'استضافة مخصصة مع موارد كاملة وأداء عالٍ',
                'meta_desc_en' => 'Dedicated hosting with full resources and high performance',
                'index' => 1,
            ],
            [
                'name_ar' => 'استضافة ووردبريس',
                'name_en' => 'WordPress Hosting',
                'short_desc_ar' => 'استضافة ووردبريس سريعة وآمنة',
                'short_desc_en' => 'Fast and secure WordPress hosting',
                'long_desc_ar' => 'استضافة ووردبريس موثوقة مع دعم فني على مدار الساعة',
                'long_desc_en' => 'Reliable WordPress hosting with 24/7 support',
                'status' => 1,
                'show_in_home'=> 1,
                'show_in_header'=> 1,
                'slug_ar' => 'استضافة-ووردبريس',
                'slug_en' => 'wordpress-hosting',
                'meta_title_ar' => 'استضافة ووردبريس',
                'meta_title_en' => 'WordPress Hosting',
                'meta_desc_ar' => 'استضافة ووردبريس موثوقة مع دعم فني على مدار الساعة',
                'meta_desc_en' => 'Reliable WordPress hosting with 24/7 support',
                'index' => 1,
            ]

        ];

        Hosting::insert($data);
    }
}
