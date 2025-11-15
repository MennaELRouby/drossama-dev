<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(function () {
        // Global routes (non-localized)
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        // Route for website.home (for dashboard sidebar)
        Route::middleware('web')->get('/website-home-redirect', function () {
            return redirect('/ar');
        })->name('website.home');

        // Localized home routes - Define as absolute paths
        Route::middleware(['web', 'localizationRedirect', 'localeViewPath', 'lang.redirect', 'secure.headers'])
            ->group(function () {
                Route::get('ar', \App\Http\Controllers\Website\HomeController::class)->name('website.home.ar');
                Route::get('en', \App\Http\Controllers\Website\HomeController::class)->name('website.home.en');
            });

        // Website routes with localization
        Route::middleware(['web', 'localizationRedirect', 'localeViewPath', 'lang.redirect', 'secure.headers'])
            ->prefix(LaravelLocalization::setLocale())
            ->name('website.')
            ->group(base_path('routes/web/website/website.php'));        // Dashboard routes with localization
        Route::middleware(['web', 'localizationRedirect', 'localeViewPath'])
            ->prefix(LaravelLocalization::setLocale())
            ->group(function () {
                Route::middleware(['web'])
                    ->prefix('dashboard')
                    ->name('dashboard.')
                    ->group(base_path('routes/web/dashboard/auth.php'));

                Route::middleware(['web', 'auth:admin'])
                    ->prefix('dashboard')
                    ->name('dashboard.')
                    ->group(base_path('routes/web/dashboard/dashboard.php'));
            });
    })
    ->withMiddleware(function ($middleware) {

        // Redirect root URL to default language - MUST BE FIRST
        $middleware->prepend(\App\Http\Middleware\RootRedirectMiddleware::class);

        // Ensure all URLs have language prefix - SECOND
        $middleware->prepend(\App\Http\Middleware\EnsureLanguagePrefix::class);

        // Apply Redirects middleware globally (after root redirect)
        $middleware->append(\App\Http\Middleware\RedirectsMiddleware::class);

        // Redirect unauthenticated admin users to dashboard login
        $middleware->redirectGuestsTo(fn() => route('dashboard.login'));

        // Add no-cache middleware globally to prevent all caching issues
        $middleware->append(\App\Http\Middleware\NoCacheMiddleware::class);

        // Add security headers globally
        $middleware->append(\App\Http\Middleware\SecurityHeadersMiddleware::class);

        $middleware->alias([

            'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
            'redirects'               => \App\Http\Middleware\RedirectsMiddleware::class,
            'lang.redirect'           => \App\Http\Middleware\LangRedirection::class,
            'secure.headers'          => \App\Http\Middleware\SecurityHeadersMiddleware::class,
            'no.cache'                => \App\Http\Middleware\NoCacheMiddleware::class,

        ]);
    })
    ->withExceptions(function ($exceptions) {
        // Handle exceptions here if needed
    })
    ->withCommands([
        \App\Console\Commands\SitemapGenerate::class,
    ])

    ->create();
