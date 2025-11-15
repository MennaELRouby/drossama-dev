<?php

namespace App\Services\Seo;

use App\Models\Blog;
use App\Models\Service;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Log;

class BuildSitemapService
{
    protected array $locales = [];

    public function generateSitemap()
    {
        // جلب اللغات المفعلة تلقائياً من الإعدادات
        $this->locales = array_keys(config('laravellocalization.supportedLocales', []));

        foreach ($this->locales as $locale) {
            app()->setLocale($locale);

            // المقالات
            $this->build_index(Blog::active()->get(), "sitemap_blogs_{$locale}.xml", $locale);

            // الخدمات
            $this->build_index(Service::active()->get(), "sitemap_services_{$locale}.xml", $locale);

            // الصفحات الثابتة
            $staticSitemap = Sitemap::create()
                ->add(
                    Url::create($this->localizedUrl($locale, '/'))
                        ->setPriority(1)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_ALWAYS)
                )
                ->add(
                    Url::create($this->localizedUrl($locale, '/about-us'))
                        ->setPriority(0.5)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                )
                ->add(
                    Url::create($this->localizedUrl($locale, '/contact-us'))
                        ->setPriority(0.5)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                );

            $tempPath = storage_path("app/public/sitemap/sitemap_static_{$locale}.xml");
            $staticSitemap->writeToFile($tempPath);

            // نسخ الملف إلى المجلد العام
            if (file_exists($tempPath)) {
                copy($tempPath, public_path("sitemap_static_{$locale}.xml"));
            }
        }

        $this->generateSitemapIndex();
        $this->generateRobotsTxt();
    }

    protected function build_index($collection, $filePath, $locale)
    {
        $sitemap = Sitemap::create();

        // تحديد نوع المحتوى من اسم الملف
        $contentType = $this->getContentTypeFromFileName($filePath);

        foreach ($collection as $item) {
            // استخدام النظام الجديد للترجمات
            $slug = $item->getTranslation('slug', $locale);

            if (empty($slug)) {
                continue;
            }

            // إضافة المسار الصحيح (blogs/, services/, etc.)
            $fullPath = $contentType . '/' . $slug;
            $url = $this->localizedUrl($locale, $fullPath);

            $sitemap->add(
                Url::create($url)
                    ->setLastModificationDate($item->updated_at)
                    ->setPriority(0.8)
            );
        }

        try {
            $tempPath = storage_path("app/public/sitemap/{$filePath}");

            // التأكد من وجود المجلد
            $tempDir = dirname($tempPath);
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            // كتابة الملف المؤقت
            $sitemap->writeToFile($tempPath);

            // نسخ الملف إلى المجلد العام
            if (file_exists($tempPath)) {
                copy($tempPath, public_path($filePath));
            }
        } catch (\Exception $e) {
            Log::error('Failed to write sitemap file', [
                'error' => $e->getMessage(),
                'temp_path' => $tempPath,
                'final_path' => public_path($filePath)
            ]);
        }
        return $filePath;
    }

    /**
     * استخراج نوع المحتوى من اسم ملف Sitemap
     */
    protected function getContentTypeFromFileName(string $filePath): string
    {
        if (str_contains($filePath, 'blogs')) {
            return 'blog';
        } elseif (str_contains($filePath, 'services')) {
            return 'services';
        } elseif (str_contains($filePath, 'projects')) {
            return 'projects';
        } elseif (str_contains($filePath, 'products')) {
            return 'products';
        }

        return '';
    }

    protected function localizedUrl(string $locale, string $path): string
    {
        $path = ltrim($path, '/');

        // Always add locale prefix for all languages
        return url("/{$locale}/{$path}");
    }

    protected function generateSitemapIndex()
    {
        $sitemapIndex = SitemapIndex::create();

        $types = ['static', 'blogs', 'services'];
        foreach ($this->locales as $locale) {
            foreach ($types as $type) {
                $file = "sitemap_{$type}_{$locale}.xml";
                $sitemapIndex->add(
                    \Spatie\Sitemap\Tags\Sitemap::create(url($file))
                        ->setLastModificationDate(now())
                );
            }
        }

        $tempPath = storage_path('app/public/sitemap/sitemap.xml');
        $sitemapIndex->writeToFile($tempPath);

        // نسخ الملف إلى المجلد العام
        if (file_exists($tempPath)) {
            copy($tempPath, public_path('sitemap.xml'));
        }
    }

    protected function generateRobotsTxt(): void
    {
        try {
            $baseUrl = rtrim(url('/'), '/');
            $content = "User-agent: *\n";
            $content .= "Allow: /\n";
            $content .= "Disallow: /shop/*\n";
            $content .= "Disallow: /public/*\n";
            $content .= "Disallow: /information/*\n";
            $content .= "Disallow: /toy/*\n";
            $content .= "\n";
            $content .= "Sitemap: {$baseUrl}/sitemap.xml\n";

            // Use Storage instead of file_put_contents for better permission handling
            \Illuminate\Support\Facades\Storage::disk('public')->put('robots.txt', $content);

            // Copy to public directory if needed
            $publicPath = public_path('robots.txt');
            $storagePath = storage_path('app/public/robots.txt');

            if (file_exists($storagePath) && is_writable(dirname($publicPath))) {
                copy($storagePath, $publicPath);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to generate robots.txt', [
                'error' => $e->getMessage()
            ]);
        }
    }
}
