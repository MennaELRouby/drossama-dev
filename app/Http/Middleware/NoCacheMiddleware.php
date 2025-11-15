<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoCacheMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Add comprehensive no-cache headers for all responses
        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0, private, no-transform');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT');
        $response->headers->set('Last-Modified', gmdate('D, d M Y H:i:s') . ' GMT');
        $response->headers->set('ETag', '"' . md5(microtime(true) . $request->getUri()) . '"');

        // Additional headers to prevent all forms of caching
        $response->headers->set('Surrogate-Control', 'no-store');
        $response->headers->set('Vary', '*');
        $response->headers->set('X-Accel-Expires', '0');
        $response->headers->set('X-Cache-Control', 'no-cache');

        // Prevent browser from caching
        if ($request->isMethod('GET')) {
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0, private, no-transform, proxy-revalidate');
        }

        return $response;
    }
}
