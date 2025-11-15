<?php

namespace Database\Seeders;

use App\Models\AIGeneratedContent;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AIGeneratedContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء admin إذا لم يكن موجود
        $admin = Admin::first() ?? Admin::factory()->create();

        // إنشاء محتوى تجريبي
        AIGeneratedContent::factory()
            ->count(20)
            ->for($admin)
            ->create();

        // إنشاء مقالات
        AIGeneratedContent::factory()
            ->count(5)
            ->article()
            ->active()
            ->for($admin)
            ->create();

        // إنشاء صفحات
        AIGeneratedContent::factory()
            ->count(3)
            ->page()
            ->active()
            ->for($admin)
            ->create();

        // إنشاء محتوى SEO
        AIGeneratedContent::factory()
            ->count(4)
            ->seo()
            ->active()
            ->for($admin)
            ->create();

        // إنشاء عناوين
        AIGeneratedContent::factory()
            ->count(6)
            ->title()
            ->active()
            ->for($admin)
            ->create();

        // إنشاء أوصاف
        AIGeneratedContent::factory()
            ->count(8)
            ->description()
            ->active()
            ->for($admin)
            ->create();

        // إنشاء كلمات مفتاحية
        AIGeneratedContent::factory()
            ->count(10)
            ->keywords()
            ->active()
            ->for($admin)
            ->create();

        // إنشاء محتوى كمسودات
        AIGeneratedContent::factory()
            ->count(5)
            ->draft()
            ->for($admin)
            ->create();

        // إنشاء محتوى غير نشط
        AIGeneratedContent::factory()
            ->count(3)
            ->inactive()
            ->for($admin)
            ->create();
    }
} 