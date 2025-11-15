<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
                'name_ar' => $this->faker->unique()->word,
                'name_en' => $this->faker->unique()->word,
                'parent_id' => Category::inRandomOrder()->first()?->id, // Random parent ID or null
                'short_desc_ar' => $this->faker->optional()->sentence,
                'short_desc_en' => $this->faker->optional()->sentence,
                'long_desc_ar' => $this->faker->optional()->paragraph, // Optional Arabic text
                'long_desc_en' => $this->faker->optional()->paragraph, // Optional English text
                'status' => $this->faker->boolean,
                'slug_ar' => preg_replace('/[\/\\\ ]/', '-',$name_ar),
                'slug_en' => preg_replace('/[\/\\\ ]/', '-', $name_en),
                'meta_title_ar' => $this->faker->optional()->sentence, // Optional Arabic meta title
                'meta_title_en' => $this->faker->optional()->sentence, // Optional English meta title
                'meta_desc_ar' => $this->faker->optional()->paragraph, // Optional Arabic meta description
                'meta_desc_en' => $this->faker->optional()->paragraph, // Optional English meta description
                'index' => $this->faker->boolean, // Boolean for indexing,
                'show_in_header' => $this->faker->boolean, // Boolean for showing in header
                'show_in_footer' => $this->faker->boolean, // Boolean for showing in footer
                'show_in_home' => $this->faker->boolean, // Boolean for showing in home
        ];
    }
}
