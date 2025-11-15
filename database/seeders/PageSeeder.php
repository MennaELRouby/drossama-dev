<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title_en' => 'Privacy Policy',
                'title_ar' => 'سياسة الخصوصية',
                'slug_en' => 'privacy-policy',
                'slug_ar' => 'سياسة الخصوصية',
                'content_en' => '<p>This is the privacy policy content.</p>',
                'content_ar' => '<p>هذا هو محتوى سياسة الخصوصية.</p>',
                'status' => true,
            ],
            [
                'title_en' => 'Terms and Conditions',
                'title_ar' => 'الشروط والأحكام',
                'slug_en' => 'terms-and-conditions',
                'slug_ar' => 'الشروط والأحكام',
                'content_en' => '<p>These are the terms and conditions content.</p>',
                'content_ar' => '<p>هذه هي محتويات الشروط والأحكام.</p>',
                'status' => false,
            ],
            [
                'title_en' => 'Refund Policy',
                'title_ar' => 'سياسة الاسترداد',
                'slug_en' => 'refund-policy',
                'slug_ar' => 'سياسة الاسترداد',
                'content_en' => '<p>This is the refund policy content.</p>',
                'content_ar' => '<p>هذه هي محتويات سياسة الاسترداد.</p>',
                'status' => false,
            ],
            [
                'title_en' => 'Shipping Policy',
                'title_ar' => 'سياسة الشحن',
                'slug_en' => 'shipping-policy',
                'slug_ar' => 'سياسة الشحن',
                'content_en' => '<p>This is the shipping policy content.</p>',
                'content_ar' => '<p>هذه هي محتويات سياسة الشحن.</p>',
                'status' => false,
            ],
        ];

        Page::insert($data);


    }
}
