<?php

namespace App\Providers;

use App\Helpers\LocalizationHelper;
use Illuminate\Support\ServiceProvider;

class LocalizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register the helper globally
        if (!function_exists('getLocalizedUrl')) {
            function getLocalizedUrl($model, $locale = null)
            {
                return LocalizationHelper::getLocalizedUrl($model, $locale);
            }
        }

        if (!function_exists('getLanguageSwitcherUrls')) {
            function getLanguageSwitcherUrls()
            {
                return LocalizationHelper::getLanguageSwitcherUrls();
            }
        }

        if (!function_exists('getCurrentPageLocalizedUrl')) {
            function getCurrentPageLocalizedUrl($locale)
            {
                return LocalizationHelper::getCurrentPageLocalizedUrl($locale);
            }
        }
    }
}