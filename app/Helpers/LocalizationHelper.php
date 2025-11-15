<?php

namespace App\Helpers;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Log;

class LocalizationHelper
{
    /**
     * Get localized URL for a model with specific locale
     */
    public static function getLocalizedUrl($model, $locale = null)
    {
        if (method_exists($model, 'getLocalizedUrl')) {
            return $model->getLocalizedUrl($locale);
        }

        return '';
    }

    /**
     * Get language switcher URLs for current page
     */
    public static function getLanguageSwitcherUrls()
    {
        $currentUrl = request()->url();
        $currentPath = str_replace(request()->root(), '', $currentUrl);

        // Remove locale prefix from current path
        $pathWithoutLocale = preg_replace('/^\/[a-z]{2}\//', '/', $currentPath);

        $urls = [];
        $supportedLocales = LaravelLocalization::getSupportedLocales();

        foreach ($supportedLocales as $localeCode => $locale) {
            $urls[$localeCode] = LaravelLocalization::getLocalizedURL($localeCode, $pathWithoutLocale);
        }

        return $urls;
    }

    /**
     * Get localized URL for current page with specific locale
     */
    public static function getCurrentPageLocalizedUrl($locale)
    {
        $currentUrl = request()->url();
        $currentPath = str_replace(request()->root(), '', $currentUrl);

        // Remove locale prefix from current path
        $pathWithoutLocale = preg_replace('/^\/[a-z]{2}\//', '/', $currentPath);

        // Add debug logging
        Log::info('LocalizationHelper getCurrentPageLocalizedUrl', [
            'target_locale' => $locale,
            'current_url' => $currentUrl,
            'current_path' => $currentPath,
            'path_without_locale' => $pathWithoutLocale
        ]);

        // Check if this is a blog, service, or category page
        if (preg_match('/^\/blog\/(.+)$/', $pathWithoutLocale, $matches)) {
            $slug = urldecode($matches[1]);

            // Support more languages
            $supportedLocales = ['en', 'ar', 'fr', 'de', 'es'];
            $query = \App\Models\Blog::query();
            foreach ($supportedLocales as $locale_check) {
                $query->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.{$locale_check}')) = ?", [$slug]);
            }
            $blog = $query->first();

            // If not found with JSON_EXTRACT, try fallback method
            if (!$blog) {
                $blogs = \App\Models\Blog::all();
                foreach ($blogs as $b) {
                    foreach ($supportedLocales as $lang) {
                        $blogSlug = $b->getTranslation('slug', $lang);
                        if ($blogSlug === $slug) {
                            $blog = $b;
                            break 2;
                        }
                    }
                }
            }

            if ($blog) {
                return $blog->getLocalizedUrl($locale);
            }
        } elseif (preg_match('/^\/services\/(.+)$/', $pathWithoutLocale, $matches)) {
            $slug = urldecode($matches[1]);

            // Support more languages
            $supportedLocales = ['en', 'ar', 'fr', 'de', 'es'];
            $query = \App\Models\Service::query();
            foreach ($supportedLocales as $locale_check) {
                $query->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.{$locale_check}')) = ?", [$slug]);
            }
            $service = $query->first();

            // If not found with JSON_EXTRACT, try fallback method
            if (!$service) {
                $services = \App\Models\Service::all();
                foreach ($services as $s) {
                    foreach ($supportedLocales as $lang) {
                        $serviceSlug = $s->getTranslation('slug', $lang);
                        if ($serviceSlug === $slug) {
                            $service = $s;
                            break 2;
                        }
                    }
                }
            }

            if ($service) {
                return $service->getLocalizedUrl($locale);
            }
        } elseif (preg_match('/^\/categories\/(.+)$/', $pathWithoutLocale, $matches)) {
            $slug = urldecode($matches[1]);

            // Support more languages
            $supportedLocales = ['en', 'ar', 'fr', 'de', 'es'];
            $query = \App\Models\Category::query();
            foreach ($supportedLocales as $locale_check) {
                $query->orWhereRaw("JSON_EXTRACT(slug, '$.{$locale_check}') = ?", [$slug]);
            }
            $category = $query->first();

            // If not found with JSON_EXTRACT, try fallback method
            if (!$category) {
                $categories = \App\Models\Category::all();
                foreach ($categories as $c) {
                    foreach ($supportedLocales as $lang) {
                        $categorySlug = $c->getTranslation('slug', $lang);
                        if ($categorySlug === $slug) {
                            $category = $c;
                            break 2;
                        }
                    }
                }
            }

            if ($category) {
                return $category->getLocalizedUrl($locale);
            }
        } elseif (preg_match('/^\/projects\/(.+)$/', $pathWithoutLocale, $matches)) {
            $slug = urldecode($matches[1]);

            // Support more languages
            $supportedLocales = ['en', 'ar', 'fr', 'de', 'es'];
            $query = \App\Models\Project::query();
            foreach ($supportedLocales as $locale_check) {
                $query->orWhereRaw("JSON_EXTRACT(slug, '$.{$locale_check}') = ?", [$slug]);
            }
            $project = $query->first();

            // If not found with JSON_EXTRACT, try fallback method
            if (!$project) {
                $projects = \App\Models\Project::all();
                foreach ($projects as $p) {
                    foreach ($supportedLocales as $lang) {
                        $projectSlug = $p->getTranslation('slug', $lang);
                        if ($projectSlug === $slug) {
                            $project = $p;
                            break 2;
                        }
                    }
                }
            }

            if ($project) {
                return $project->getLocalizedUrl($locale);
            }
        } elseif (preg_match('/^\/products\/(.+)$/', $pathWithoutLocale, $matches)) {
            $slug = urldecode($matches[1]);

            // Support more languages
            $supportedLocales = ['en', 'ar', 'fr', 'de', 'es'];
            $query = \App\Models\Product::query();
            foreach ($supportedLocales as $locale_check) {
                $query->orWhereRaw("JSON_EXTRACT(slug, '$.{$locale_check}') = ?", [$slug]);
            }
            $product = $query->first();

            // If not found with JSON_EXTRACT, try fallback method
            if (!$product) {
                $products = \App\Models\Product::all();
                foreach ($products as $p) {
                    foreach ($supportedLocales as $lang) {
                        $productSlug = $p->getTranslation('slug', $lang);
                        if ($productSlug === $slug) {
                            $product = $p;
                            break 2;
                        }
                    }
                }
            }

            if ($product) {
                return $product->getLocalizedUrl($locale);
            }
        }

        return LaravelLocalization::getLocalizedURL($locale, $pathWithoutLocale);
    }
}