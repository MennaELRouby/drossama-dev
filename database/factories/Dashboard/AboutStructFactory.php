<?php

namespace Database\Factories\Dashboard;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AboutStructFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_en' => $this->faker->sentence,
            'title_ar' => $this->faker->sentence,
            'text_en' => $this->faker->paragraph,
            'text_ar' => $this->faker->paragraph,
            'alt_icon' => $this->faker->word,
            'order' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->boolean,
        ];
    }
}
