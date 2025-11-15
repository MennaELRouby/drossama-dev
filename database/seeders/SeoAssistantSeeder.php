<?php

namespace Database\Seeders;

use App\Models\SeoAssistant;
use Illuminate\Database\Seeder;

class SeoAssistantSeeder extends Seeder
{
    public function run(): void
    {
        SeoAssistant::updateOrCreate(
            ['id' => 1],
            [
                // Home Page
                'home_meta_title_en' => 'Professional Beauty & Wellness Services',
                'home_meta_desc_en' => 'Expert beauty salon offering professional hair care, nail services, and beauty treatments. Brazilian specialists with premium organic products.',
                'home_meta_title_ar' => 'خدمات التجميل والعناية الاحترافية',
                'home_meta_desc_ar' => 'صالون تجميل احترافي يقدم خدمات العناية بالشعر والأظافر والتجميل. إخصائيات برازيليات بمنتجات عضوية فاخرة.',

                // About Page
                'about_meta_title_en' => 'About Us | Expert Beauty Services',
                'about_meta_desc_en' => 'Discover our journey in providing exceptional beauty and wellness services. Expert team with years of experience in professional beauty care.',
                'about_meta_title_ar' => 'من نحن | خدمات التجميل الاحترافية',
                'about_meta_desc_ar' => 'تعرف على مسيرتنا في تقديم خدمات التجميل والعناية المتميزة. فريق خبراء بسنوات من الخبرة في مجال التجميل الاحترافي.',

                // Blog Page
                'blog_meta_title_en' => 'Beauty Tips & Insights | Latest Trends',
                'blog_meta_desc_en' => 'Stay updated with the latest beauty trends, tips, and expert advice. Learn about hair care, skincare, and wellness from our professionals.',
                'blog_meta_title_ar' => 'نصائح التجميل والعناية | أحدث الاتجاهات',
                'blog_meta_desc_ar' => 'ابق على اطلاع بأحدث صيحات التجميل والنصائح من الخبراء. تعلم عن العناية بالشعر والبشرة من محترفينا.',

                // Services Page
                'service_meta_title_en' => 'Beauty Services | Hair, Nails & More',
                'service_meta_desc_en' => 'Comprehensive beauty services including hair treatments, nail care, and beauty procedures. Professional services with premium quality products.',
                'service_meta_title_ar' => 'خدمات التجميل | الشعر والأظافر والمزيد',
                'service_meta_desc_ar' => 'خدمات تجميل شاملة تشمل علاجات الشعر والعناية بالأظافر وإجراءات التجميل. خدمات احترافية بمنتجات عالية الجودة.',

                // Products Page
                'products_meta_title_en' => 'Beauty Products & Treatments',
                'products_meta_desc_en' => 'Explore our range of professional beauty products and treatments. Premium quality products for hair care, skincare, and beauty enhancement.',
                'products_meta_title_ar' => 'منتجات وعلاجات التجميل',
                'products_meta_desc_ar' => 'اكتشف مجموعة منتجاتنا وعلاجاتنا التجميلية الاحترافية. منتجات فاخرة للعناية بالشعر والبشرة وتحسين الجمال.',
            ]
        );
    }
}