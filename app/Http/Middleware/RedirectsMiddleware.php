<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RedirectsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $path = '/' . ltrim($request->getPathInfo(), '/');
        $fullUrl = $request->fullUrl();

        // Normalize paths by removing trailing slashes for comparison
        $normalizedPath = rtrim($path, '/');
        $normalizedFullUrl = rtrim($fullUrl, '/');

        // Also get URL without query string for matching
        $urlWithoutQuery = $request->url();
        $normalizedUrlWithoutQuery = rtrim($urlWithoutQuery, '/');

        // Handle custom redirects
        $redirects = Cache::remember('redirects.map', 300, function () {
            return Redirect::where('is_active', true)->get();
        });

        $match = $redirects->first(function ($r) use ($normalizedPath, $normalizedFullUrl, $normalizedUrlWithoutQuery) {
            $normalizedSource = rtrim($r->source, '/');

            // Also normalize source by removing query string for comparison
            $sourceWithoutQuery = parse_url($normalizedSource, PHP_URL_PATH);
            if ($sourceWithoutQuery === null) {
                // If parse_url fails, source is just a path
                $sourceWithoutQuery = $normalizedSource;
            } else {
                // Reconstruct URL without query string
                $scheme = parse_url($normalizedSource, PHP_URL_SCHEME);
                $host = parse_url($normalizedSource, PHP_URL_HOST);
                if ($scheme && $host) {
                    $sourceWithoutQuery = $scheme . '://' . $host . $sourceWithoutQuery;
                }
            }
            $sourceWithoutQuery = rtrim($sourceWithoutQuery, '/');

            // Match against path, full URL, or URL without query string
            return $normalizedSource === $normalizedPath
                || $normalizedSource === $normalizedFullUrl
                || $normalizedSource === $normalizedUrlWithoutQuery
                || $sourceWithoutQuery === $normalizedPath
                || $sourceWithoutQuery === $normalizedUrlWithoutQuery;
        });

        if ($match) {
            $status = (int) $match->status_code;
            if ($status === 410) {
                return response()->view('errors.410', [], 410);
            }
            if (!empty($match->target)) {
                return redirect()->away($match->target, in_array($status, [301, 302], true) ? $status : 301);
            }
        }

        return $next($request);
    }
}
