<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => json_encode(['en' => 'Category 1', 'ar' => 'الفئة 1']),
                'slug' => json_encode(['en' => 'category-1', 'ar' => 'الفئة-1']),
                'parent_id' => null,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 1,
                'show_in_home' => 1,
                'show_in_header' => 1,
            ],
            [
                'name' => json_encode(['en' => 'Category 2', 'ar' => 'الفئة 2']),
                'slug' => json_encode(['en' => 'category-2', 'ar' => 'الفئة-2']),
                'parent_id' => null,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 1,
                'show_in_home' => 1,
                'show_in_header' => 1,
            ],
            [
                'name' => json_encode(['en' => 'Category 3', 'ar' => 'الفئة 3']),
                'slug' => json_encode(['en' => 'category-3', 'ar' => 'الفئة-3']),
                'parent_id' => null,
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 1,
                'show_in_home' => 1,
                'show_in_header' => 1,
            ],
            [
                'name' => json_encode(['en' => 'Category 4', 'ar' => 'الفئة 4']),
                'slug' => json_encode(['en' => 'category-4', 'ar' => 'الفئة-4']),
                'parent_id' => null,
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 1,
                'show_in_home' => 1,
                'show_in_header' => 1,
            ],
            [
                'name' => json_encode(['en' => 'Category 5', 'ar' => 'الفئة 5']),
                'slug' => json_encode(['en' => 'category-5', 'ar' => 'الفئة-5']),
                'parent_id' => null,
                'order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 1,
                'show_in_home' => 1,
                'show_in_header' => 1,
            ],
            [
                'name' => json_encode(['en' => 'Category 6', 'ar' => 'الفئة 6']),
                'slug' => json_encode(['en' => 'category-6', 'ar' => 'الفئة-6']),
                'parent_id' => null,
                'order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 1,
                'show_in_home' => 1,
                'show_in_header' => 1,
            ],

        ];
        foreach ($data as $item) {
            Category::create($item);
        }
    }
}
