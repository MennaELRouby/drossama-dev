<?php

namespace App\Providers;

use App\Helper\SocialMediaHelper;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composers\SeoComposer;
use App\View\Composers\MenuComposer;
use App\View\Composers\FooterMenuComposer;
use App\Models\Phone;
use App\Models\Dashboard\Menu;
use App\Models\SiteAddress;
use App\Models\Section;
use App\Models\Service;
use App\Models\Project;
use App\Models\Product;
use App\Models\Blog;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Route;

class ViewComposerServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        // SEO Composer for main layout pages and website components
        View::composer(['layouts.app', 'Website.*', 'components.website.*'], SeoComposer::class);

        // Menu Composer for navigation components
        View::composer(['components.website.partials.mainmenu', 'components.website.partials.mobilemenu'], MenuComposer::class);

        // Mobile Menu Composer for contact info
        View::composer('components.website.partials.mobilemenu', function ($view) {
            $phones = Phone::active()->orderBy('order', 'asc')->orderBy('updated_at', 'desc')->get();
            $site_addresses = SiteAddress::active()->orderBy('order', 'asc')->orderBy('updated_at', 'desc')->get();

            $view->with([
                'phones' => $phones,
                'site_addresses' => $site_addresses,
                'socialMediaLinks' => SocialMediaHelper::getSocialMediaLinks()
            ]);
        });

        // Footer Menu Composer for footer navigation (parent menus only)
        View::composer(['components.website.partials._footer'], FooterMenuComposer::class);

        View::composer('components.website.partials._header', function ($view) {
            // Force fresh data from database (no cache)
            // Get all phones ordered by priority
            $phones = Phone::active()->orderBy('order', 'asc')->orderBy('updated_at', 'desc')->get();
            $site_addresses = SiteAddress::active()->orderBy('order', 'asc')->orderBy('updated_at', 'desc')->get();

            // Language switcher logic - Build languages array
            $currentLocale = app()->getLocale();
            $supportedLocales = LaravelLocalization::getSupportedLocales();
            $languages = collect();

            $route = Route::current();
            $routeParameters = $route ? $route->parameters() : [];
            $currentPath = $route ? $route->uri() : '';

            foreach ($supportedLocales as $localeCode => $properties) {
                $altLangLink = null;

                if ($route) {
                    $slug = null;
                    $model = null;
                    $targetPath = null;

                    if (str_contains($currentPath, 'services')) {
                        $slug = $routeParameters['slug'] ?? null;
                        $model = Service::class;
                        $targetPath = 'services';
                    } elseif (str_contains($currentPath, 'projects')) {
                        $item = $routeParameters['project'] ?? null;
                        if ($item instanceof Project) {
                            $slug = $item->getTranslation('slug', $currentLocale);
                        } else {
                            $slug = $item;
                        }
                        $model = Project::class;
                        $targetPath = 'projects';
                    } elseif (str_contains($currentPath, 'products')) {
                        $item = $routeParameters['product'] ?? null;
                        if ($item instanceof Product) {
                            $slug = $item->getTranslation('slug', $currentLocale);
                        } else {
                            $slug = $item;
                        }
                        $model = Product::class;
                        $targetPath = 'products';
                    } elseif (str_contains($currentPath, 'blogs')) {
                        $slug = $routeParameters['slug'] ?? null;
                        $model = Blog::class;
                        $targetPath = 'blogs';
                    }

                    if ($slug && $model && $targetPath) {
                        // Decode URL-encoded Arabic characters before database search
                        $decodedSlug = urldecode($slug);
                        $item = $model::whereRaw("JSON_EXTRACT(slug, '$.{$currentLocale}') = ?", [$decodedSlug])->first();

                        // If not found, try to find by checking all languages
                        if (!$item) {
                            $items = $model::all();
                            foreach ($items as $i) {
                                foreach (['en', 'ar', 'fr', 'de'] as $lang) {
                                    $itemSlug = $i->getTranslation('slug', $lang);
                                    if ($itemSlug === $decodedSlug) {
                                        $item = $i;
                                        break 2;
                                    }
                                }
                            }
                        }

                        if ($item && method_exists($item, 'getLocalizedUrl')) {
                            $altLangLink = $item->getLocalizedUrl($localeCode);
                        }
                    }
                }

                if (!$altLangLink) {
                    $altLangLink = \App\Helpers\LocalizationHelper::getCurrentPageLocalizedUrl($localeCode);
                }

                $languages->push((object)[
                    'code' => $localeCode,
                    'name' => $properties['native'],
                    'url' => $altLangLink,
                    'active' => $localeCode === $currentLocale
                ]);
            }

            $view->with('phones', $phones);
            $view->with('site_addresses', $site_addresses);
            $view->with('socialMediaLinks', SocialMediaHelper::getSocialMediaLinks());
            $view->with('languages', $languages);
        });

        //Footer composer Socal Media Links & Phones & Site Addresses
        View::composer('components.website.partials._footer', function ($view) {
            // Force fresh data from database (no cache)
            // Get all active phones ordered by priority for footer display
            $phones = Phone::active()->orderBy('order', 'asc')->orderBy('updated_at', 'desc')->get();
            $site_addresses = SiteAddress::active()->orderBy('order', 'asc')->orderBy('updated_at', 'desc')->get();

            $view->with('socialMediaLinks', SocialMediaHelper::getSocialMediaLinks());
            $view->with('phones', $phones);
            $view->with('site_addresses', $site_addresses);
        });

        //Banner composer for Social Media Links
        View::composer('Website.partials._banner', function ($view) {
            $view->with('socialMediaLinks', SocialMediaHelper::getSocialMediaLinks());
        });

        // Social Media Component composer
        View::composer('components.website.partials.social-media', function ($view) {
            $view->with('socialMediaLinks', SocialMediaHelper::getSocialMediaLinks());
        });
    }


    public function register(): void
    {
        //
    }
}
