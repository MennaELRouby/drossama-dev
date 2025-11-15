<?php

namespace Database\Seeders;

use App\Models\GalleryVideo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GalleryVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GalleryVideo::factory()
            ->count(5)
            ->create();
    }
}
