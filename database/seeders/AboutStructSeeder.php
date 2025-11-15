<?php

namespace Database\Seeders;

use App\Models\Dashboard\AboutStruct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutStructSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => json_encode(['en' => 'Our Goals', 'ar' => 'اهدافنا']),
                'long_desc' => json_encode(['en' => 'Our goals are what make us the best company in the Kingdom of Saudi Arabia', 'ar' => 'اهدافنا هي التي تجعلنا نصبح أفضل شركة في المملكة العربية السعودية']),
                'status' => 1,
                'alt_icon' => 'اهدافنا',
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => json_encode(['en' => 'Our Mission', 'ar' => 'رسالتنا']),
                'long_desc' => json_encode(['en' => 'Our mission is what makes us the best company in the Kingdom of Saudi Arabia', 'ar' => 'رسالتنا هي التي تجعلنا نصبح أفضل شركة في المملكة العربية السعودية']),
                'status' => 1,
                'alt_icon' => 'رسالتنا',
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => json_encode(['en' => 'Our Vision', 'ar' => 'رؤيتنا']),
                'long_desc' => json_encode(['en' => 'Our vision is what makes us the best company in the Kingdom of Saudi Arabia', 'ar' => 'رؤيتنا هي التي تجعلنا نصبح أفضل شركة في المملكة العربية السعودية']),
                'status' => 1,
                'alt_icon' => 'رؤيتنا',
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        foreach ($data as $item) {
            AboutStruct::create($item);
        }
    }
}
