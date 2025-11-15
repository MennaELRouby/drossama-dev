<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DisableDebugbarForAMP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Disable debugbar for AMP routes
        if ($request->is('amp/*')) {
            if (class_exists('\Barryvdh\Debugbar\Facades\Debugbar')) {
                \Barryvdh\Debugbar\Facades\Debugbar::disable();
            }

            // Also disable debugbar globally for this request
            if (class_exists('\Barryvdh\Debugbar\LaravelDebugbar')) {
                app()->instance('debugbar', null);
            }
        }

        return $next($request);
    }
}
