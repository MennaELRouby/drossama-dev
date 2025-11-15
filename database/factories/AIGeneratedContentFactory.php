<?php

namespace Database\Factories;

use App\Models\AIGeneratedContent;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AIGeneratedContent>
 */
class AIGeneratedContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['article', 'page', 'seo', 'title', 'description', 'keywords'];
        $statuses = ['active', 'inactive', 'draft'];
        
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'type' => $this->faker->randomElement($types),
            'prompt' => $this->faker->sentence(10),
            'options' => [
                'max_tokens' => $this->faker->numberBetween(500, 2000),
                'temperature' => $this->faker->randomFloat(1, 0.1, 1.0),
                'word_count' => $this->faker->numberBetween(100, 1000),
            ],
            'usage_data' => [
                'prompt_tokens' => $this->faker->numberBetween(50, 200),
                'completion_tokens' => $this->faker->numberBetween(100, 500),
                'total_tokens' => $this->faker->numberBetween(150, 700),
            ],
            'model_used' => 'gpt-3.5-turbo',
            'status' => $this->faker->randomElement($statuses),
            'generated_by' => Admin::factory(),
            'target_model' => null,
            'target_id' => null,
            'meta_description' => $this->faker->sentence(15),
            'keywords' => $this->faker->words(5, true),
            'word_count' => $this->faker->numberBetween(50, 500),
            'generation_time' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'cost' => $this->faker->randomFloat(4, 0.001, 0.05),
        ];
    }

    /**
     * حالة للمحتوى النشط
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * حالة للمحتوى غير النشط
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }

    /**
     * حالة للمحتوى كمسودة
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
        ]);
    }

    /**
     * حالة لمقال
     */
    public function article(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'article',
            'content' => $this->faker->paragraphs(5, true),
            'word_count' => $this->faker->numberBetween(300, 800),
        ]);
    }

    /**
     * حالة لصفحة
     */
    public function page(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'page',
            'options' => [
                'page_type' => $this->faker->randomElement(['about', 'services', 'contact', 'privacy', 'terms']),
                'max_tokens' => $this->faker->numberBetween(1000, 2000),
                'temperature' => 0.6,
            ],
        ]);
    }

    /**
     * حالة لمحتوى SEO
     */
    public function seo(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'seo',
            'meta_description' => $this->faker->sentence(25),
            'keywords' => $this->faker->words(8, true),
        ]);
    }

    /**
     * حالة لعنوان
     */
    public function title(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'title',
            'content' => $this->faker->sentence(),
            'word_count' => $this->faker->numberBetween(5, 15),
        ]);
    }

    /**
     * حالة لوصف
     */
    public function description(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'description',
            'content' => $this->faker->sentence(20),
            'word_count' => $this->faker->numberBetween(20, 50),
        ]);
    }

    /**
     * حالة لكلمات مفتاحية
     */
    public function keywords(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'keywords',
            'content' => $this->faker->words(5, true),
            'word_count' => $this->faker->numberBetween(5, 10),
        ]);
    }
} 