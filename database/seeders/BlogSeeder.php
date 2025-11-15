<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => json_encode(['en' => 'Blog 1', 'ar' => 'المدونة 1']),
                'short_desc' => json_encode(['en' => 'A paragraph is a series of related sentences developing a central idea, called the topic. Try to think about paragraphs in terms of thematic unity, and the paragraphs will be more successful.', 'ar' => 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.']),
                'long_desc' => json_encode(['en' => 'A paragraph is a series of related sentences developing a central idea, called the topic. Try to think about paragraphs in terms of thematic unity, and the paragraphs will be more successful.', 'ar' => 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.']),
                'slug' => json_encode(['en' => 'blog-1', 'ar' => 'المدونة-1']),
                'meta_title' => json_encode(['en' => 'Blog 1', 'ar' => 'المدونة 1']),
                'meta_desc' => json_encode(['en' => 'A paragraph is a series of related sentences developing a central idea, called the topic. Try to think about paragraphs in terms of thematic unity, and the paragraphs will be more successful.', 'ar' => 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.']),
                'status' => 1,
                'show_in_home' => 1,
                'show_in_header' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => json_encode(['en' => 'Blog 2', 'ar' => 'المدونة 2']),
                'short_desc' => json_encode(['en' => 'A paragraph is a series of related sentences developing a central idea, called the topic. Try to think about paragraphs in terms of thematic unity, and the paragraphs will be more successful.', 'ar' => 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.']),
                'long_desc' => json_encode(['en' => 'A paragraph is a series of related sentences developing a central idea, called the topic. Try to think about paragraphs in terms of thematic unity, and the paragraphs will be more successful.', 'ar' => 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.']),
                'slug' => json_encode(['en' => 'blog-2', 'ar' => 'المدونة-2']),
                'meta_title' => json_encode(['en' => 'Blog 2', 'ar' => 'المدونة 2']),
                'meta_desc' => json_encode(['en' => 'A paragraph is a series of related sentences developing a central idea, called the topic. Try to think about paragraphs in terms of thematic unity, and the paragraphs will be more successful.', 'ar' => 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.']),
                'status' => 1,
                'show_in_home' => 1,
                'show_in_header' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => json_encode(['en' => 'Blog 3', 'ar' => 'المدونة 3']),
                'short_desc' => json_encode(['en' => 'A paragraph is a series of related sentences developing a central idea, called the topic. Try to think about paragraphs in terms of thematic unity, and the paragraphs will be more successful.', 'ar' => 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.']),
                'long_desc' => json_encode(['en' => 'A paragraph is a series of related sentences developing a central idea, called the topic. Try to think about paragraphs in terms of thematic unity, and the paragraphs will be more successful.', 'ar' => 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.']),
                'slug' => json_encode(['en' => 'blog-3', 'ar' => 'المدونة-3']),
                'meta_title' => json_encode(['en' => 'Blog 3', 'ar' => 'المدونة 3']),
                'meta_desc' => json_encode(['en' => 'A paragraph is a series of related sentences developing a central idea, called the topic. Try to think about paragraphs in terms of thematic unity, and the paragraphs will be more successful.', 'ar' => 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.']),
                'status' => 1,
                'show_in_home' => 1,
                'show_in_header' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        foreach ($data as $item) {
            Blog::create($item);
        }
    }
}
