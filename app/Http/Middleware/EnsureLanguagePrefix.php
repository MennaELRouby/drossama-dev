<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureLanguagePrefix
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();

        // Skip certain paths
        if (
            $path === '/' ||
            str_starts_with($path, 'dashboard') ||
            str_starts_with($path, 'api') ||
            str_starts_with($path, 'storage') ||
            str_starts_with($path, 'assets') ||
            $path === 'offline' ||
            $path === 'manifest.json' ||
            $path === 'robots.txt' ||
            $path === 'sitemap.xml' ||
            str_starts_with($path, 'sitemap_')
        ) {
            return $next($request);
        }

        // Check if path starts with a supported locale
        $supportedLocales = array_keys(config('laravellocalization.supportedLocales', []));
        $firstSegment = explode('/', $path)[0];

        if (in_array($firstSegment, $supportedLocales)) {
            // Already has locale prefix, continue
            return $next($request);
        }

        // No locale prefix found, redirect to URL with default locale
        $defaultLocale = config('app.fallback_locale', 'ar');
        $newUrl = "/{$defaultLocale}/{$path}";

        \Illuminate\Support\Facades\Log::info('Language prefix redirect', [
            'from' => $path,
            'to' => $newUrl
        ]);

        return redirect($newUrl, 301);
    }
}
