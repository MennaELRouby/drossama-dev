<?php

namespace App\Helper;

use App\Services\Seo\SeoService;
use Illuminate\Support\Facades\View;

class SeoHelper
{
    protected static SeoService $seoService;

    public static function init(): void
    {
        if (!isset(self::$seoService)) {
            self::$seoService = app(SeoService::class);
        }
    }

    /**
     * Set SEO for a specific page
     */
    public static function setPageSEO(string $page): void
    {
        self::init();
        $seo = self::$seoService->get($page);

        View::share('metatags', $seo[1]);
        View::share('schema', $seo[0]);
    }

    /**
     * Set dynamic SEO for products, blogs, services
     */
    public static function setDynamicSEO(string $type, array $data): void
    {
        self::init();
        $seo = self::$seoService->generateDynamicSEO($type, $data);

        View::share('metatags', $seo[1]);
        View::share('schema', $seo[0]);
    }

    /**
     * Get SEO data for a page
     */
    public static function getPageSEO(string $page): array
    {
        self::init();
        return self::$seoService->get($page);
    }

    /**
     * Get dynamic SEO data
     */
    public static function getDynamicSEO(string $type, array $data): array
    {
        self::init();
        return self::$seoService->generateDynamicSEO($type, $data);
    }

    /**
     * Set FAQ Schema for pages with FAQs
     */
    public static function setFAQSchema(array $faqs): void
    {
        self::init();
        $schema = self::$seoService->generateFAQSchema($faqs);
        View::share('faq_schema', $schema);
    }

    /**
     * Set Breadcrumb Schema
     */
    public static function setBreadcrumbSchema(array $breadcrumbs): void
    {
        self::init();
        $schema = self::$seoService->generateBreadcrumbSchema($breadcrumbs);
        View::share('breadcrumb_schema', $schema);
    }

    /**
     * Generate breadcrumbs for current page
     */
    public static function generatePageBreadcrumbs(string $currentPage, array $additionalCrumbs = []): array
    {
        $breadcrumbs = [
            ['name' => __('home'), 'url' => url('/')]
        ];

        // Add additional breadcrumbs
        foreach ($additionalCrumbs as $crumb) {
            $breadcrumbs[] = $crumb;
        }

        // Add current page (without URL as it's the current page)
        $breadcrumbs[] = ['name' => $currentPage, 'url' => null];

        return $breadcrumbs;
    }
}
