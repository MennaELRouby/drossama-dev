<?php

namespace Database\Factories;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Factories\Factory;

class SliderFactory extends Factory
{
    protected $model = Slider::class;

    public function definition()
    {
        return [
            'title' => json_encode([
                'en' => $this->faker->sentence(3),
                'ar' => 'عنوان السلايدر ' . $this->faker->numberBetween(1, 10),
                'fr' => 'Titre du slider ' . $this->faker->numberBetween(1, 10),
            ]),
            'title2' => json_encode([
                'en' => $this->faker->sentence(2),
                'ar' => 'العنوان الفرعي ' . $this->faker->numberBetween(1, 10),
                'fr' => 'Sous-titre ' . $this->faker->numberBetween(1, 10),
            ]),
            'text' => json_encode([
                'en' => $this->faker->paragraph(1),
                'ar' => 'نص السلايدر ' . $this->faker->numberBetween(1, 10),
                'fr' => 'Texte du slider ' . $this->faker->numberBetween(1, 10),
            ]),
            'order' => $this->faker->numberBetween(1, 10),
            'alt_image' => $this->faker->words(2, true),
            'alt_icon' => $this->faker->words(2, true),
            'status' => 1,
            'type' => 'top_header',
        ];
    }

    public function topHeader()
    {
        return $this->state([
            'type' => 'top_header',
        ]);
    }

    public function home()
    {
        return $this->state([
            'type' => 'middle',
        ]);
    }
}
