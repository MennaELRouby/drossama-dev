<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name_ar = $this->faker->unique()->word;
        $name_en = $this->faker->unique()->word;
        return [
            'parent_id' => Project::inRandomOrder()->first()?->id, // Random parent ID or null
            'name_ar' => $this->faker->unique()->word,
            'name_en' => $this->faker->unique()->word,
            'short_desc_en' => $this->faker->sentence(),
            'short_desc_ar' => $this->faker->sentence(),
            'long_desc_en' => $this->faker->paragraph(),
            'long_desc_ar' => $this->faker->paragraph(),
            'alt_image' => $this->faker->word(),
            'alt_icon' => $this->faker->word(),
            'status' => $this->faker->boolean(),
            'show_in_home' => $this->faker->boolean(),
            'show_in_header' => $this->faker->boolean(),
            'show_in_footer' => $this->faker->boolean(),
            'slug_ar' => preg_replace('/[\/\\\ ]/', '-',$name_ar),
            'slug_en' => preg_replace('/[\/\\\ ]/', '-', $name_en),
            'created_at' => now(),
        ];
    }
}
