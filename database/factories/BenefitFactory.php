<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Benefit>
 */
class BenefitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_en' => $this->faker->word,
            'title_ar' => $this->faker->word,
            'short_description_en' => $this->faker->sentence(),
            'short_description_ar' => $this->faker->sentence(),
            'long_description_en' => $this->faker->paragraph(),
            'long_description_ar' => $this->faker->paragraph(),
            'alt_image' => $this->faker->word,
            'alt_icon' => $this->faker->word,
            'status' => $this->faker->boolean(),
            'order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
