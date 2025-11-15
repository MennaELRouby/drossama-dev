<?php

namespace Database\Seeders;

use App\Models\Dashboard\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name_ar' => 'موقع إلكتروني',
                'name_en' => 'Website',
                'status' => true
            ],
            [
                'name_ar' => 'سعة التخزين',
                'name_en' => 'Storage',
                'status' => true
            ],
            [
                'name_ar' => 'نطاق مجاني',
                'name_en' => 'Free Domain',
                'status' => true
            ],
            [
                'name_ar' => 'النطاق الترددي',
                'name_en' => 'Bandwidth',
                'status' => true
            ],
            [
                'name_ar' => 'حسابات البريد الإلكتروني',
                'name_en' => 'Email Accounts',
                'status' => true
            ],
            [
                'name_ar' => 'شهادة SSL',
                'name_en' => 'SSL Certificate',
                'status' => true
            ],
        ];

      Attribute::insert($data);

    }
}
