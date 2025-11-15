<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Services\Seo\SeoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class SeoComposer
{
    protected SeoService $seoService;
    protected Request $request;

    public function __construct(SeoService $seoService, Request $request)
    {
        $this->seoService = $seoService;
        $this->request = $request;
    }

    public function compose(View $view): void
    {
        $page = $this->detectCurrentPage();

        // Check if this is a details page
        if ($this->isDetailsPage()) {
            $seo = $this->getDetailsPageSEO();
        } else {
            $seo = $this->seoService->get($page);
        }

        $view->with('metatags', $seo[1]); // metatags is the second element
        $view->with('schema', $seo[0]); // schema is the first element
    }

    protected function isDetailsPage(): bool
    {
        $path = $this->request->path();
        $locale = app()->getLocale();

        if (str_starts_with($path, $locale)) {
            $path = substr($path, strlen($locale) + 1);
        }

        $path = rtrim($path, '/');

        return str_contains($path, 'blog/') || str_contains($path, 'services/') || str_contains($path, 'products/');
    }

    protected function getDetailsPageSEO(): array
    {
        $path = $this->request->path();
        $locale = app()->getLocale();

        if (str_starts_with($path, $locale)) {
            $path = substr($path, strlen($locale) + 1);
        }

        $path = rtrim($path, '/');

        // Check for blog details
        if (str_contains($path, 'blog/')) {
            $slug = urldecode(str_replace('blog/', '', $path));
            $locale = app()->getLocale();

            // Try multiple methods to find the blog
            $blog = \App\Models\Blog::whereRaw("JSON_EXTRACT(slug, '$.{$locale}') = ?", [$slug])->first();

            // If not found with JSON_EXTRACT, try manual search
            if (!$blog) {
                $blogs = \App\Models\Blog::all();
                foreach ($blogs as $b) {
                    foreach (['ar', 'en'] as $lang) {
                        $blogSlug = $b->getTranslation('slug', $lang);
                        if ($blogSlug === $slug) {
                            $blog = $b;
                            break 2;
                        }
                    }
                }
            }

            if ($blog) {
                return $this->seoService->blogDetailsPage($blog);
            }
        }

        // Check for service details
        if (str_contains($path, 'services/')) {
            $slug = str_replace('services/', '', $path);
            $slug = urldecode($slug); // Decode URL encoding
            $locale = app()->getLocale();

            $service = \App\Models\Service::whereRaw("JSON_EXTRACT(slug, '$.{$locale}') = ?", [$slug])->first();
            if ($service) {
                return $this->seoService->serviceDetailsPage($service);
            }
        }

        // Check for product details
        if (str_contains($path, 'products/')) {
            $slug = str_replace('products/', '', $path);
            $locale = app()->getLocale();
            $product = \App\Models\Product::whereRaw("JSON_EXTRACT(slug, '$.{$locale}') = ?", [$slug])->first();
            if ($product) {
                return $this->seoService->productDetailsPage($product);
            }
        }

        // Fallback to home page
        return $this->seoService->get('home');
    }

    protected function detectCurrentPage(): string
    {
        $path = $this->request->path();

        // Remove locale prefix if exists
        $locale = app()->getLocale();
        if (str_starts_with($path, $locale)) {
            $path = substr($path, strlen($locale) + 1);
        }

        // Remove trailing slash
        $path = rtrim($path, '/');

        // Debug: Log the path for troubleshooting (commented out to prevent spam)
        // Log::info('SEO Path detected: ' . $path);

        // Map routes to page types
        return match ($path) {
            '', 'home' => 'home',
            'about', 'about-us' => 'about',
            'contact', 'contact-us' => 'contact',
            'blogs', 'blog' => 'blogs',
            'services' => 'services',
            'products' => 'products',
            default => 'home' // fallback
        };
    }
}
