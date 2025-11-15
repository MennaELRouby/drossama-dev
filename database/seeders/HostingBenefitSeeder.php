<?php

namespace Database\Seeders;

use App\Models\Benefit;
use App\Models\Dashboard\Hosting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HostingBenefitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Fetch all hosting records
        $hostings = Hosting::all();

        // Loop through each hosting
        foreach ($hostings as $hosting) {
            // Insert 3 benefits for each hosting
            $benefit1 = new Benefit([
                'title_en' => 'Unlimited Storage',
                'title_ar' => 'تخزين غير محدود',
                'short_description_en' => 'Enjoy unlimited storage space for all your files.',
                'short_description_ar' => 'استمتع بمساحة تخزين غير محدودة لجميع ملفاتك.',
                'long_description_en' => 'With our hosting plan, you get unlimited storage space to store your website, media files, and backups.',
                'long_description_ar' => 'مع خطة الاستضافة الخاصة بنا، تحصل على مساحة تخزين غير محدودة لتخزين موقعك الإلكتروني، وملفات الوسائط، والنسخ الاحتياطية.',
                'status' => true,
                'order' => 1
            ]);
            $hosting->benefits()->save($benefit1);

            $benefit2 = new Benefit([
                'title_en' => 'Free SSL Certificate',
                'title_ar' => 'شهادة SSL مجانية',
                'short_description_en' => 'Get a free SSL certificate with your hosting plan for better security.',
                'short_description_ar' => 'احصل على شهادة SSL مجانية مع خطة الاستضافة الخاصة بك للحصول على أمان أفضل.',
                'long_description_en' => 'SSL certificates are essential for securing your website and building trust with your visitors.',
                'long_description_ar' => 'شهادات SSL أساسية لتأمين موقعك الإلكتروني وبناء الثقة مع زوارك.',
                'status' => true,
                'order' => 2
            ]);
            $hosting->benefits()->save($benefit2);

            $benefit3 = new Benefit([
                'title_en' => '24/7 Customer Support',
                'title_ar' => 'دعم العملاء على مدار الساعة',
                'short_description_en' => 'Our team is available 24/7 to assist you with any hosting-related issues.',
                'short_description_ar' => 'فريقنا متاح على مدار الساعة لمساعدتك في أي مشكلات تتعلق بالاستضافة.',
                'long_description_en' => 'No matter the time, our support team is ready to help with any hosting problems or questions.',
                'long_description_ar' => 'بغض النظر عن الوقت، فريق الدعم لدينا جاهز للمساعدة في أي مشكلات أو استفسارات تتعلق بالاستضافة.',
                'status' => true,
                'order' => 3
            ]);
            $hosting->benefits()->save($benefit3);
        }
    }
}
