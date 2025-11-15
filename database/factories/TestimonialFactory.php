<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_en' => $this->faker->name(),
            'name_ar' => $this->faker->name(),
            'job_title_en' => $this->faker->jobTitle(),
            'job_title_ar' => $this->faker->jobTitle(),
            'description_en' => $this->faker->paragraph(),
            'description_ar' => $this->faker->paragraph(),
            'status' => $this->faker->boolean(),
        ];
    }
}
