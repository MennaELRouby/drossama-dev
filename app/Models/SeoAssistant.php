<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoAssistant extends Model
{
    protected $fillable = [
        // Home
        'home_meta_title_en', 'home_meta_title_ar',
        'home_meta_desc_en', 'home_meta_desc_ar',
        'home_meta_keywords_en', 'home_meta_keywords_ar',
        'home_meta_robots_en', 'home_meta_robots_ar',
        // About
        'about_meta_title_en', 'about_meta_title_ar',
        'about_meta_desc_en', 'about_meta_desc_ar',
        'about_meta_keywords_en', 'about_meta_keywords_ar',
        'about_meta_robots_en', 'about_meta_robots_ar',
        // Contact
        'contact_meta_title_en', 'contact_meta_title_ar',
        'contact_meta_desc_en', 'contact_meta_desc_ar',
        'contact_meta_keywords_en', 'contact_meta_keywords_ar',
        'contact_meta_robots_en', 'contact_meta_robots_ar',
        // Blog
        'blog_meta_title_en', 'blog_meta_title_ar',
        'blog_meta_desc_en', 'blog_meta_desc_ar',
        'blog_meta_keywords_en', 'blog_meta_keywords_ar',
        'blog_meta_robots_en', 'blog_meta_robots_ar',
        // Service
        'service_meta_title_en', 'service_meta_title_ar',
        'service_meta_desc_en', 'service_meta_desc_ar',
        'service_meta_keywords_en', 'service_meta_keywords_ar',
        'service_meta_robots_en', 'service_meta_robots_ar',
        // Products
        'products_meta_title_en', 'products_meta_title_ar',
        'products_meta_desc_en', 'products_meta_desc_ar',
        'products_meta_keywords_en', 'products_meta_keywords_ar',
        'products_meta_robots_en', 'products_meta_robots_ar',
    ];

    protected $casts = [
        'about_meta_robots' => 'boolean',
        'home_meta_robots' => 'boolean',
        'contact_meta_robots' => 'boolean',
        'blog_meta_robots' => 'boolean',
        'service_meta_robots' => 'boolean',
        'products_meta_robots' => 'boolean',
    ];
} 