<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Statistic>
 */
class StatisticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_ar' => $this->faker->sentence,
            'title_en' => $this->faker->sentence,
            'value' => $this->faker->numberBetween(1, 100),
            'text_ar' => $this->faker->paragraph,
            'text_en' => $this->faker->paragraph,
            'status' => $this->faker->boolean,
        ];
    }
}
