<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => json_encode(['en' => 'Project 1', 'ar' => 'مشروع 1']),
                'short_desc' => json_encode(['en' => 'Fast and secure project 1', 'ar' => 'مشروع 1 سريع وآمن']),
                'long_desc' => json_encode(['en' => 'Reliable and fast project 1 with 24/7 support', 'ar' => 'مشروع 1 موثوق وسريع مع دعم فني على مدار الساعة']),
                'slug' => json_encode(['en' => 'project-1', 'ar' => 'مشروع-1']),
                'meta_title' => json_encode(['en' => 'Project 1', 'ar' => 'مشروع 1']),
                'meta_desc' => json_encode(['en' => 'Reliable and fast project 1 with 24/7 support', 'ar' => 'مشروع 1 موثوق وسريع مع دعم فني على مدار الساعة']),
                'status' => 1,
                'show_in_home' => 1,
                'show_in_header' => 1,
                'index' => 1,
                'category_id' => 4,
                'alt_image' => 'مشروع 1',
                'alt_icon' => 'مشروع 1',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => json_encode(['en' => 'Project 2', 'ar' => 'مشروع 2']),
                'short_desc' => json_encode(['en' => 'Fast and secure project 2', 'ar' => 'مشروع 2 سريع وآمن']),
                'long_desc' => json_encode(['en' => 'Reliable and fast project 2 with 24/7 support', 'ar' => 'مشروع 2 موثوق وسريع مع دعم فني على مدار الساعة']),
                'slug' => json_encode(['en' => 'project-2', 'ar' => 'مشروع-2']),
                'meta_title' => json_encode(['en' => 'Project 2', 'ar' => 'مشروع 2']),
                'meta_desc' => json_encode(['en' => 'Reliable and fast project 2 with 24/7 support', 'ar' => 'مشروع 2 موثوق وسريع مع دعم فني على مدار الساعة']),
                'status' => 1,
                'show_in_home' => 1,
                'show_in_header' => 1,
                'index' => 1,
                'category_id' => 5,
                'alt_image' => 'مشروع 2',
                'alt_icon' => 'مشروع 2',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => json_encode(['en' => 'Project 3', 'ar' => 'مشروع 3']),
                'short_desc' => json_encode(['en' => 'Fast and secure project 3', 'ar' => 'مشروع 3 سريع وآمن']),
                'long_desc' => json_encode(['en' => 'Reliable and fast project 3 with 24/7 support', 'ar' => 'مشروع 3 موثوق وسريع مع دعم فني على مدار الساعة']),
                'slug' => json_encode(['en' => 'project-3', 'ar' => 'مشروع-3']),
                'meta_title' => json_encode(['en' => 'Project 3', 'ar' => 'مشروع 3']),
                'meta_desc' => json_encode(['en' => 'Reliable and fast project 3 with 24/7 support', 'ar' => 'مشروع 3 موثوق وسريع مع دعم فني على مدار الساعة']),
                'status' => 1,
                'show_in_home' => 1,
                'show_in_header' => 1,
                'index' => 1,
                'category_id' => 6,
                'alt_image' => 'مشروع 3',
                'alt_icon' => 'مشروع 3',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        foreach ($data as $item) {
            Project::create($item);
        }
    }
}
