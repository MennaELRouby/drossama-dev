<?php

namespace Database\Factories;

use App\Models\Certificate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certificate>
 */
class CertificateFactory extends Factory
{
    protected $model = Certificate::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => [
                'en' => $this->faker->sentence(3),
                'ar' => 'شهادة ' . $this->faker->sentence(2),
                'fr' => 'Certificat ' . $this->faker->sentence(2),
            ],
            'image' => 'certificate.jpg',
            'alt_image' => $this->faker->sentence(3),
            'order' => $this->faker->numberBetween(1, 100),
            'status' => 1,
        ];
    }
}
