<?php

namespace Database\Seeders;

use App\Models\Dashboard\Attribute;
use App\Models\Dashboard\AttributeValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Get attributes by name (in English)
         $attributes = Attribute::whereIn('name_en', [
            'Storage',
            'Free Domain',
            'Bandwidth',
            'Email Accounts',
            'SSL Certificate',
            'Website'
        ])->get()->keyBy('name_en');

        $values = [
            'Storage' => [
                ['en' => '10 GB', 'ar' => '10 جيجابايت'],
                ['en' => '50 GB', 'ar' => '50 جيجابايت'],
                ['en' => '100 GB', 'ar' => '100 جيجابايت'],
            ],
            'Free Domain' => [
                ['en' => 'Yes', 'ar' => 'نعم'],
                ['en' => 'No', 'ar' => 'لا'],
            ],
            'Bandwidth' => [
                ['en' => '100 GB', 'ar' => '100 جيجابايت'],
                ['en' => '500 GB', 'ar' => '500 جيجابايت'],
                ['en' => 'Unlimited', 'ar' => 'غير محدود'],
            ],
            'Email Accounts' => [
                ['en' => '10', 'ar' => '10'],
                ['en' => '50', 'ar' => '50'],
                ['en' => 'Unlimited', 'ar' => 'غير محدود'],
            ],
            'SSL Certificate' => [
                ['en' => 'Included', 'ar' => 'مضمن'],
                ['en' => 'Not Included', 'ar' => 'غير مضمن'],
            ],
            'Website'=>[
                ['en' => '1', 'ar' => '1'],
                ['en' => '10', 'ar' => '10'],
                ['en' => '25', 'ar' => '25'],
            ]
        ];

        foreach ($values as $attributeName => $options) {
            $attribute = $attributes[$attributeName] ?? null;
            if (!$attribute) continue;

            foreach ($options as $option) {
                AttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'value_en' => $option['en'],
                    'value_ar' => $option['ar'],
                    'status' => true,
                    'price' => null
                ]);
            }
        }
    }
}
