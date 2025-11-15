<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // One top_header
        Slider::factory()->topHeader()->create();

        // Two or more home sliders
        Slider::factory()->count(2)->create();
    }
}
