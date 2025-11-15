<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeadersMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // X-Content-Type-Options: Prevents MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // X-Frame-Options: Prevents clickjacking attacks
        // Use SAMEORIGIN to allow framing from same origin, or DENY to block all framing
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Referrer-Policy: Controls how much referrer information is sent
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // HSTS (HTTP Strict Transport Security): Forces HTTPS connections
        // Apply on both HTTP and HTTPS to ensure the header is always present
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        // X-XSS-Protection: Legacy XSS protection (for older browsers)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Permissions-Policy: Control browser features
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        // Content-Security-Policy: A permissive-but-safer CSP baseline
        $csp = "default-src 'self' https: data: 'unsafe-inline' 'unsafe-eval'";
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
