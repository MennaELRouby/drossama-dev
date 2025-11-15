<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => json_encode(['en' => 'Product 1', 'ar' => 'منتج 1']),
                'short_desc' => json_encode(['en' => 'Fast and secure product 1', 'ar' => 'منتج 1 سريع وآمن']),
                'long_desc' => json_encode(['en' => 'Reliable and fast product 1 with 24/7 support', 'ar' => 'منتج 1 موثوق وسريع مع دعم فني على مدار الساعة']),
                'slug' => json_encode(['en' => 'product-1', 'ar' => 'منتج-1']),
                'meta_title' => json_encode(['en' => 'Product 1', 'ar' => 'منتج 1']),
                'meta_desc' => json_encode(['en' => 'Reliable and fast product 1 with 24/7 support', 'ar' => 'منتج 1 موثوق وسريع مع دعم فني على مدار الساعة']),
                'clients' => json_encode(['en' => 'Product 1', 'ar' => 'منتج 1']),
                'location' => json_encode(['en' => 'Location 1', 'ar' => 'منتج 1']),
                'status' => 1,
                'show_in_home' => 1,
                'show_in_header' => 1,
                'index' => 1,
                'category_id' => 1,
                'alt_image' => 'منتج 1',
                'alt_icon' => 'منتج 1',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => json_encode(['en' => 'Product 2', 'ar' => 'منتج 2']),
                'short_desc' => json_encode(['en' => 'Fast and secure product 2', 'ar' => 'منتج 2 سريع وآمن']),
                'long_desc' => json_encode(['en' => 'Reliable and fast product 2 with 24/7 support', 'ar' => 'منتج 2 موثوق وسريع مع دعم فني على مدار الساعة']),
                'slug' => json_encode(['en' => 'product-2', 'ar' => 'منتج-2']),
                'meta_title' => json_encode(['en' => 'Product 2', 'ar' => 'منتج 2']),
                'meta_desc' => json_encode(['en' => 'Reliable and fast product 2 with 24/7 support', 'ar' => 'منتج 2 موثوق وسريع مع دعم فني على مدار الساعة']),
                'clients' => json_encode(['en' => 'Product 2', 'ar' => 'منتج 2']),
                'location' => json_encode(['en' => 'Location 2', 'ar' => 'منتج 2']),
                'status' => 1,
                'show_in_home' => 1,
                'show_in_header' => 1,
                'index' => 1,
                'category_id' => 2,
                'alt_image' => 'منتج 2',
                'alt_icon' => 'منتج 2',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => json_encode(['en' => 'Product 3', 'ar' => 'منتج 3']),
                'short_desc' => json_encode(['en' => 'Fast and secure product 3', 'ar' => 'منتج 3 سريع وآمن']),
                'long_desc' => json_encode(['en' => 'Reliable and fast product 3 with 24/7 support', 'ar' => 'منتج 3 موثوق وسريع مع دعم فني على مدار الساعة']),
                'slug' => json_encode(['en' => 'product-3', 'ar' => 'منتج-3']),
                'meta_title' => json_encode(['en' => 'Product 3', 'ar' => 'منتج 3']),
                'meta_desc' => json_encode(['en' => 'Reliable and fast product 3 with 24/7 support', 'ar' => 'منتج 3 موثوق وسريع مع دعم فني على مدار الساعة']),
                'clients' => json_encode(['en' => 'Product 3', 'ar' => 'منتج 3']),
                'location' => json_encode(['en' => 'Location 3', 'ar' => 'منتج 3']),
                'status' => 1,
                'show_in_home' => 1,
                'show_in_header' => 1,
                'index' => 1,
                'category_id' => 3,
                'alt_image' => 'منتج 3',
                'alt_icon' => 'منتج 3',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        foreach ($data as $item) {
            Product::create($item);
        }
    }
}
