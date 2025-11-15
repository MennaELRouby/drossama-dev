<?php

namespace Database\Seeders;

use App\Models\Dashboard\Hosting;
use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HostingFaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Loop through all hosting records
        $hostings = Hosting::all();

        // Loop through each hosting record
        foreach ($hostings as $hosting) {
            // Insert 3 FAQs for each hosting
            $faq1 = new Faq([
                'question_en' => 'What is included in my hosting plan?',
                'answer_en' => 'Your hosting plan includes unlimited storage, free SSL, and a free domain for the first year.',
                'question_ar' => 'ما الذي يتضمنه خطة الاستضافة الخاصة بي؟',
                'answer_ar' => 'تشمل خطة الاستضافة الخاصة بك مساحة تخزين غير محدودة، SSL مجاني، واسم نطاق مجاني للسنة الأولى.',
                'status' => true,
                'order' => 1
            ]);
            $hosting->faqs()->save($faq1);

            $faq2 = new Faq([
                'question_en' => 'How do I upgrade my hosting plan?',
                'answer_en' => 'You can upgrade your hosting plan by visiting your account dashboard.',
                'question_ar' => 'كيف يمكنني ترقية خطة الاستضافة الخاصة بي؟',
                'answer_ar' => 'يمكنك ترقية خطة الاستضافة الخاصة بك عن طريق زيارة لوحة التحكم في حسابك.',
                'status' => true,
                'order' => 2
            ]);
            $hosting->faqs()->save($faq2);

            $faq3 = new Faq([
                'question_en' => 'How can I cancel my hosting plan?',
                'answer_en' => 'You can cancel your hosting plan anytime from your account settings.',
                'question_ar' => 'كيف يمكنني إلغاء خطة الاستضافة الخاصة بي؟',
                'answer_ar' => 'يمكنك إلغاء خطة الاستضافة الخاصة بك في أي وقت من إعدادات حسابك.',
                'status' => true,
                'order' => 3
            ]);
            $hosting->faqs()->save($faq3);
        }
    
    }
}
