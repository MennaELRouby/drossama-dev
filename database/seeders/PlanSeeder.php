<?php

namespace Database\Seeders;

use App\Models\Dashboard\Hosting;
use App\Models\Dashboard\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $hostings = Hosting::all();

        foreach ($hostings as $hosting) {
            $plans = [
                [
                    'name_en' => 'Basic',
                    'name_ar' => 'أساسي',
                    'lable' => 'Best for beginners',
                    'monthly_price' => 5.99,
                    'yearly_price' => 59.99,
                    'slug_en' => Str::slug('Basic'),
                    'slug_ar' => Str::slug('أساسي'),
                    'status' => true,
                    'show_in_home' => true,
                    
                    'index' => 1
                ],
                [
                    'name_en' => 'Standard',
                    'name_ar' => 'قياسي',
                    'lable' => 'Most popular plan',
                    'monthly_price' => 9.99,
                    'yearly_price' => 99.99,
                    'slug_en' => Str::slug('Standard'),
                    'slug_ar' => Str::slug('قياسي'),
                    'status' => true,
                    'show_in_home' => true,
                    'meta_title_en' => 'Standard Plan',
                    'meta_title_ar' => 'الخطة القياسية',
                    'meta_desc_en' => 'Perfect for growing businesses.',
                    'meta_desc_ar' => 'مثالي للأعمال المتنامية.',
                    'index' => 2
                ],
                [
                    'name_en' => 'Premium',
                    'name_ar' => 'مميز',
                    'lable' => 'All-inclusive package',
                    'monthly_price' => 14.99,
                    'yearly_price' => 149.99,
                    'slug_en' => Str::slug('Premium'),
                    'slug_ar' => Str::slug('مميز'),
                    'status' => true,
                    'show_in_home' => true,
                    'meta_title_en' => 'Premium Plan',
                    'meta_title_ar' => 'الخطة المميزة',
                    'meta_desc_en' => 'All features with top performance.',
                    'meta_desc_ar' => 'جميع الميزات مع أفضل أداء.',
                    'index' => 3
                ]
            ];

            foreach ($plans as $plan) {
                $slug = Str::slug($plan['name_en']) . '-' . $hosting->id;
                
                
                    Plan::create(array_merge($plan, [
                        'hosting_id' => $hosting->id,
                        'slug_en' => $slug,
                        'slug_ar' => $slug,
                        'icon' => null,
                        'alt_icon' => null,
                        'image' => null,
                        'alt_image' => null,
                    ]));
                
            }
        }
    }
}
