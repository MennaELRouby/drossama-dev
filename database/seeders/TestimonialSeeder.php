<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => json_encode(['en' => 'Name 1', 'ar' => 'الاسم 1']),
                'position' => json_encode(['en' => 'Job Title 1', 'ar' => 'الوظيفة 1']),
                'content' => json_encode(['en' => 'Long Description 1', 'ar' => 'الوصف الطويل 1']),
                'status' => 1,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        foreach ($data as $item) {
            Testimonial::create($item);
        }
    }
}