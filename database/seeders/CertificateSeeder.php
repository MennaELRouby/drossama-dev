<?php

namespace Database\Seeders;

use App\Models\Certificate;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $certificates = [
            [
                'name' => [
                    'en' => 'ISO 9001 Certification',
                    'ar' => 'شهادة الأيزو 9001',
                    'fr' => 'Certification ISO 9001',
                ],
                'image' => 'certificate1.jpg',
                'alt_image' => 'ISO 9001 Certificate',
                'order' => 1,
                'status' => 1,
            ],
            [
                'name' => [
                    'en' => 'Quality Management Certificate',
                    'ar' => 'شهادة إدارة الجودة',
                    'fr' => 'Certificat de gestion de la qualité',
                ],
                'image' => 'certificate2.jpg',
                'alt_image' => 'Quality Management Certificate',
                'order' => 2,
                'status' => 1,
            ],
            [
                'name' => [
                    'en' => 'Excellence Award 2024',
                    'ar' => 'جائزة التميز 2024',
                    'fr' => 'Prix d\'excellence 2024',
                ],
                'image' => 'certificate3.jpg',
                'alt_image' => 'Excellence Award 2024',
                'order' => 3,
                'status' => 1,
            ],
        ];

        foreach ($certificates as $certificate) {
            Certificate::create($certificate);
        }
    }
}
