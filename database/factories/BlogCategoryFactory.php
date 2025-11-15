<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogCategory>
 */
class BlogCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        return [
            'name_en' => $this->faker->word(),
            'name_ar' => $this->faker->word(),
            'short_desc_en' => $this->faker->sentence(),
            'short_desc_ar' => $this->faker->sentence(),
            'long_desc_en' => $this->faker->paragraph(),
            'long_desc_ar' => $this->faker->paragraph(),
            'alt_image' => $this->faker->word(),
            'alt_icon' => $this->faker->word(),
            'meta_title_en' => $this->faker->sentence(),
            'meta_title_ar' => $this->faker->sentence(),
            'meta_desc_en' => $this->faker->paragraph(),
            'meta_desc_ar' => $this->faker->paragraph(),
            'slug_en' => $this->faker->slug(),
            'slug_ar' => $this->faker->slug(),
            'status' => 1,
            'show_in_home' => 1,
            'show_in_header' => 1,
            'show_in_footer' => 1,
            'index' => 1,   
        ];
    }
}
