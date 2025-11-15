<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => json_encode(['en' => 'Service 1', 'ar' => 'الخدمة 1']),
                'short_desc' => json_encode(['en' => 'Fast and secure service 1', 'ar' => 'الخدمة 1 سريعة وآمنة']),
                'long_desc' => json_encode(['en' => 'Reliable and fast service 1 with 24/7 support', 'ar' => 'الخدمة 1 موثوق وسريع مع دعم فني على مدار الساعة']),
                'slug' => json_encode(['en' => 'service-1', 'ar' => 'الخدمة-1']),
                'meta_title' => json_encode(['en' => 'Service 1', 'ar' => 'الخدمة 1']),
                'meta_desc' => json_encode(['en' => 'Reliable and fast service 1 with 24/7 support', 'ar' => 'الخدمة 1 موثوق وسريع مع دعم فني على مدار الساعة']),
                'status' => 1,
                'show_in_home' => 1,
                'show_in_header' => 1,
                'index' => 1,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => json_encode(['en' => 'Service 2', 'ar' => 'الخدمة 2']),
                'short_desc' => json_encode(['en' => 'Fast and secure service 2', 'ar' => 'الخدمة 2 سريعة وآمنة']),
                'long_desc' => json_encode(['en' => 'Reliable and fast service 2 with 24/7 support', 'ar' => 'الخدمة 2 موثوق وسريع مع دعم فني على مدار الساعة']),
                'slug' => json_encode(['en' => 'service-2', 'ar' => 'الخدمة-2']),
                'meta_title' => json_encode(['en' => 'Service 2', 'ar' => 'الخدمة 2']),
                'meta_desc' => json_encode(['en' => 'Reliable and fast service 2 with 24/7 support', 'ar' => 'الخدمة 2 موثوق وسريع مع دعم فني على مدار الساعة']),
                'status' => 1,
                'show_in_home' => 1,
                'show_in_header' => 1,
                'index' => 1,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => json_encode(['en' => 'Service 3', 'ar' => 'الخدمة 3']),
                'short_desc' => json_encode(['en' => 'Fast and secure service 3', 'ar' => 'الخدمة 3 سريعة وآمنة']),
                'long_desc' => json_encode(['en' => 'Reliable and fast service 3 with 24/7 support', 'ar' => 'الخدمة 3 موثوق وسريع مع دعم فني على مدار الساعة']),
                'slug' => json_encode(['en' => 'service-3', 'ar' => 'الخدمة-3']),
                'meta_title' => json_encode(['en' => 'Service 3', 'ar' => 'الخدمة 3']),
                'meta_desc' => json_encode(['en' => 'Reliable and fast service 3 with 24/7 support', 'ar' => 'الخدمة 3 موثوق وسريع مع دعم فني على مدار الساعة']),
                'status' => 1,
                'show_in_home' => 1,
                'show_in_header' => 1,
                'index' => 1,
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        foreach ($data as $item) {
            Service::create($item);
        }
    }
}
