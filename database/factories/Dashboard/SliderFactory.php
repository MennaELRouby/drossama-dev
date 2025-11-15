<?php

namespace Database\Factories\Dashboard;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dashboard\Slider>
 */
class SliderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_en' => $this->faker->sentence(3),
            'title_ar' => $this->faker->sentence(3),
            'title2_en' => $this->faker->sentence(4),
            'title2_ar' => $this->faker->sentence(4),
            'type' => 'home', // default type
            'text_ar' => $this->faker->optional()->paragraph,
            'text_en' => $this->faker->optional()->paragraph,
            'order' => $this->faker->numberBetween(1, 10),
            'status' => true,
        ];
    }

    /**
     * State for top_header type
     */
    public function topHeader(): static
    {
        return $this->state(fn () => ['type' => 'top_header']);
    }
}
