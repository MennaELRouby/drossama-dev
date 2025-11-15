<?php

namespace Database\Seeders;

use App\Models\Dashboard\Domain;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $data = [
        [
            'title_en' => 'example.com',
            'title_ar' => 'example.com',
            'yearly_price' => 10,
            'transfer_price' => 5,
            'renewal_price' => 10,
            'short_desc_en' => 'example.com',
            'short_desc_ar' => 'example.com',
            'slug_en' => 'example.com',
            'slug_ar' => 'example.com',
            'status' => 1,
            'meta_title_ar' => 'example.com',
            'meta_title_en' => 'example.com',
            'meta_desc_ar' => 'example.com',
            'meta_desc_en' => 'example.com',
            'index' => 1,
        ],
        [
            'title_en' => 'example.net',
            'title_ar' => 'example.net',
            'yearly_price' => 15,
            'transfer_price' => 7,
            'renewal_price' => 15,
            'short_desc_en' => 'example.net',
            'short_desc_ar' => 'example.net',
            'slug_en' => 'example.net',
            'slug_ar' => 'example.net',
            'status' => 1,
            'meta_title_ar' => 'example.net',
            'meta_title_en' => 'example.net',
            'meta_desc_ar' => 'example.net',
            'meta_desc_en' => 'example.net',
            'index' => 1,
        ],
        [
            'title_en' => 'example.org',
            'title_ar' => 'example.org',
            'yearly_price' => 20,
            'transfer_price' => 10,
            'renewal_price' => 20,
            'short_desc_en' => 'example.org',
            'short_desc_ar' => 'example.org',
            'slug_en' => 'example.org',
            'slug_ar' => 'example.org',
            'status' => 1,
            'meta_title_ar' => 'example.org',
            'meta_title_en' => 'example.org',
            'meta_desc_ar' => 'example.org',
            'meta_desc_en' => 'example.org',
            'index' => 1,
        ],
        [
            'title_en' => 'example.info',
            'title_ar' => 'example.info',
            'yearly_price' => 25,
            'transfer_price' => 12,
            'renewal_price' => 25,
            'short_desc_en' => 'example.info',
            'short_desc_ar' => 'example.info',
            'slug_en' => 'example.info',
            'slug_ar' => 'example.info',
            'status' => 1,
            'meta_title_ar' => 'example.info',
            'meta_title_en' => 'example.info',
            'meta_desc_ar' => 'example.info',
            'meta_desc_en' => 'example.info',
            'index' => 1,
        ]
       ];

       Domain::insert($data);
    }
}
