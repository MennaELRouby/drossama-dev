<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $types = [null,'technical_issue', 'domains', 'hostings', 'help_support'];
        // $faqableType = $this->faker->randomElement($types);
        return [
            'question_ar' => $this->faker->sentence,
            'question_en' => $this->faker->sentence,
            'answer_ar' => $this->faker->paragraph,
            'answer_en' => $this->faker->paragraph,
            'status' => $this->faker->boolean,
            // 'faqable_type' => $faqableType,
            'order' => $this->faker->numberBetween(1, 100),
        ];
    }
}
