<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seo_assistants', function (Blueprint $table) {
            $table->id();
            $table->text('home_meta_title_en')->nullable();
            $table->text('home_meta_desc_en')->nullable();
            $table->text('home_meta_robots_en')->nullable();
            $table->text('home_meta_title_ar')->nullable();
            $table->text('home_meta_desc_ar')->nullable();
            $table->text('home_meta_robots_ar')->nullable();
            $table->text('about_meta_title_en')->nullable();
            $table->text('about_meta_desc_en')->nullable();
            $table->text('about_meta_robots_en')->nullable();
            $table->text('about_meta_title_ar')->nullable();
            $table->text('about_meta_desc_ar')->nullable();
            $table->text('about_meta_robots_ar')->nullable();
            $table->text('contact_meta_title_en')->nullable();
            $table->text('contact_meta_desc_en')->nullable();
            $table->text('contact_meta_robots_en')->nullable();
            $table->text('contact_meta_title_ar')->nullable();
            $table->text('contact_meta_desc_ar')->nullable();
            $table->text('contact_meta_robots_ar')->nullable();
            $table->text('blog_meta_title_en')->nullable();
            $table->text('blog_meta_desc_en')->nullable();
            $table->text('blog_meta_robots_en')->nullable();
            $table->text('blog_meta_title_ar')->nullable();
            $table->text('blog_meta_desc_ar')->nullable();
            $table->text('blog_meta_robots_ar')->nullable();
            $table->text('service_meta_title_en')->nullable();
            $table->text('service_meta_desc_en')->nullable();
            $table->text('service_meta_robots_en')->nullable();
            $table->text('service_meta_title_ar')->nullable();
            $table->text('service_meta_desc_ar')->nullable();
            $table->text('service_meta_robots_ar')->nullable();
            $table->string('products_meta_title_en')->nullable();
            $table->text('products_meta_desc_en')->nullable();
            $table->boolean('products_meta_robots_en')->default(true);
            $table->string('products_meta_title_ar')->nullable();
            $table->text('products_meta_desc_ar')->nullable();
            $table->boolean('products_meta_robots_ar')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_assistants');
        Schema::table('seo_assistants', function (Blueprint $table) {
            $table->dropColumn([
            'home_meta_title_en',
            'home_meta_desc_en',
            'home_meta_robots_en',
            'home_meta_title_ar',
            'home_meta_desc_ar',
            'home_meta_robots_ar',
            'about_meta_title_en',
            'about_meta_desc_en',
            'about_meta_robots_en',
            'about_meta_title_ar',
            'about_meta_desc_ar',
            'about_meta_robots_ar',
            'contact_meta_title_en',
            'contact_meta_desc_en',
            'contact_meta_robots_en',
            'contact_meta_title_ar',
            'contact_meta_desc_ar',
            'contact_meta_robots_ar',
            'blog_meta_title_en',
            'blog_meta_desc_en',
            'blog_meta_robots_en',
            'blog_meta_title_ar',
            'blog_meta_desc_ar',
            'blog_meta_robots_ar',
            'service_meta_title_en',
            'service_meta_desc_en',
            'service_meta_robots_en',
            'service_meta_title_ar',
            'service_meta_desc_ar',
            'service_meta_robots_ar',
            'products_meta_title_en',
            'products_meta_desc_en',
            'products_meta_robots_en',
            'products_meta_title_ar',
            'products_meta_desc_ar',
            'products_meta_robots_ar',
            ]);
        });
    }
};
