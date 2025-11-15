<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GalleryVideo>
 */
class GalleryVideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'title_ar' => $this->faker->sentence(),
            'title_en' => $this->faker->sentence(),
            'video_url' => $this->faker->url(),
            'description_ar' => $this->faker->paragraph(),
            'description_en' => $this->faker->paragraph(),
        ];
    }
}
