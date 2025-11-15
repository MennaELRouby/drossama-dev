<?php

namespace App\Http\Middleware;

use App\Helper\StringHelper;
use App\Models\BlogCategory;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Project;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LangRedirection
{

    public function handle($request, Closure $next)
    {
        $slugLang = $request->segment(1);
        App::setLocale($slugLang);
        $currentLang = App::getLocale();
        $test_lang = Setting::first()->default_lang;

        // Debug logging
        Log::info('LangRedirection Middleware', [
            'url' => $request->url(),
            'fullUrl' => $request->fullUrl(),
            'path' => $request->path(),
            'slugLang' => $slugLang,
            'currentLang' => $currentLang,
            'segment2' => $request->segment(2),
            'segment3' => $request->segment(3),
            'segment3_raw' => rawurldecode($request->segment(3)),
            'segment3_decoded' => urldecode($request->segment(3))
        ]);

        // Check if URL contains problematic encoding patterns that might cause loops
        $currentUrl = $request->url();
        if (strpos($currentUrl, '%C3%98') !== false || strpos($currentUrl, 'Ø§Ù') !== false) {
            Log::info('Detected problematic encoding in URL - skipping redirect to avoid loops', [
                'url' => $currentUrl
            ]);
            return $next($request);
        }

        if ($slugLang == $currentLang) {
            $url = $request->url();

            // Handle blogs
            if ($request->segment(2) == 'blogs' && $request->segment(3) != '') {
                $redirect = $this->handleBlogRedirect($request, $slugLang, 'blogs');
                if ($redirect) return $redirect;
            }

            if ($request->segment(2) == 'blog' && $request->segment(3) != '') {
                // blog/ is for blog details, no redirect needed
                $redirect = $this->handleBlogRedirect($request, $slugLang, 'blog');
                if ($redirect) return $redirect;
            }

            // Handle products
            if ($request->segment(2) == 'products' && $request->segment(3) != '') {
                $redirect = $this->handleProjectRedirect($request, $slugLang, 'products');
                if ($redirect) return $redirect;
            }

            if ($request->segment(2) == 'project' && $request->segment(3) != '') {
                $redirect = $this->handleProjectRedirect($request, $slugLang, 'project');
                if ($redirect) return $redirect;
            }

            // Handle services
            if ($request->segment(2) == 'services' && $request->segment(3) != '') {
                $redirect = $this->handleServiceRedirect($request, $slugLang, 'services');
                if ($redirect) return $redirect;
            }

            if ($request->segment(2) == 'service' && $request->segment(3) != '') {
                $redirect = $this->handleServiceRedirect($request, $slugLang, 'service');
                if ($redirect) return $redirect;
            }

            return $next($request);
        }

        if ($slugLang != $test_lang) {
            $url = $request->url();

            // Handle blogs
            if ($request->segment(2) == 'blogs' && $request->segment(3) != '') {
                $redirect = $this->handleBlogRedirect($request, $slugLang, 'blogs');
                if ($redirect) return $redirect;
            }

            if ($request->segment(2) == 'blog' && $request->segment(3) != '') {
                // blog/ is for blog details, no redirect needed
                $redirect = $this->handleBlogRedirect($request, $slugLang, 'blog');
                if ($redirect) return $redirect;
            }

            // Handle products
            if ($request->segment(2) == 'products' && $request->segment(3) != '') {
                $redirect = $this->handleProjectRedirect($request, $slugLang, 'products');
                if ($redirect) return $redirect;
            }

            if ($request->segment(2) == 'project' && $request->segment(3) != '') {
                $redirect = $this->handleProjectRedirect($request, $slugLang, 'project');
                if ($redirect) return $redirect;
            }

            // Handle services
            if ($request->segment(2) == 'services' && $request->segment(3) != '') {
                $redirect = $this->handleServiceRedirect($request, $slugLang, 'services');
                if ($redirect) return $redirect;
            }

            if ($request->segment(2) == 'service' && $request->segment(3) != '') {
                $redirect = $this->handleServiceRedirect($request, $slugLang, 'service');
                if ($redirect) return $redirect;
            }

            return $next($request);
        }

        return $next($request);
    }

    /**
     * Handle blog redirects
     */
    private function handleBlogRedirect($request, $slugLang, $routeType)
    {
        $currentSlug = $request->segment(3);
        Log::info('Processing blog redirect', [
            'originalSlug' => $currentSlug,
            'routeType' => $routeType,
            'targetLang' => $slugLang,
            'url' => $request->url()
        ]);

        // Multiple attempts to find the blog with different slug variations
        $slugVariations = $this->generateSlugVariations($currentSlug);

        $blog = null;
        $matchedSlug = null;

        // First try: Direct database search with all variations
        foreach ($slugVariations as $variation) {
            $blog = Blog::where(function ($query) use ($variation) {
                $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.ar')) = ?", [$variation])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.en')) = ?", [$variation])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.fr')) = ?", [$variation])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.de')) = ?", [$variation])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.es')) = ?", [$variation]);
            })->first();

            if ($blog) {
                $matchedSlug = $variation;
                Log::info('Found blog with variation', [
                    'blogId' => $blog->id,
                    'matchedSlug' => $variation,
                    'targetLang' => $slugLang
                ]);
                break;
            }
        }

        // If still not found, try manual iteration (fallback)
        if (!$blog) {
            Log::info('Trying fallback method for blog search');
            $blogs = Blog::all();
            foreach ($blogs as $b) {
                foreach (['ar', 'en', 'fr', 'de', 'es'] as $lang) {
                    $blogSlug = $b->getTranslation('slug', $lang);
                    foreach ($slugVariations as $variation) {
                        if ($blogSlug === $variation) {
                            $blog = $b;
                            $matchedSlug = $variation;
                            Log::info('Found blog by manual iteration', [
                                'blogId' => $blog->id,
                                'matchedSlug' => $blogSlug,
                                'language' => $lang
                            ]);
                            break 3;
                        }
                    }
                }
            }
        }

        Log::info('Blog search result', [
            'blog' => $blog ? $blog->id : 'null',
            'matchedSlug' => $matchedSlug
        ]);

        if ($blog) {
            $correctSlug = $blog->getTranslation('slug', $slugLang);
            Log::info('Correct slug for target language', [
                'targetLang' => $slugLang,
                'correctSlug' => $correctSlug,
                'currentSlug' => $currentSlug
            ]);

            // Check if we already have the correct URL
            $currentFullUrl = $request->url();
            $expectedUrl = url("/$slugLang/$routeType/{$correctSlug}");

            if ($correctSlug && $currentFullUrl !== $expectedUrl && $correctSlug !== $currentSlug) {
                // Use rawurlencode for Arabic slugs to prevent double encoding
                $encodedSlug = rawurlencode($correctSlug);
                $saferUrl = url("/$slugLang/$routeType/{$encodedSlug}");

                Log::info('Redirecting blog to correct URL', [
                    'from' => $currentFullUrl,
                    'to' => $saferUrl,
                    'correctSlug' => $correctSlug,
                    'encodedSlug' => $encodedSlug,
                    'reason' => 'slug_mismatch'
                ]);
                return redirect($saferUrl, 301);
            } elseif ($correctSlug && ($correctSlug === $currentSlug || $currentFullUrl === $expectedUrl)) {
                Log::info('Slug is already correct, no redirect needed');
            } else {
                Log::warning('No correct slug found for target language', [
                    'targetLang' => $slugLang,
                    'blogId' => $blog->id
                ]);
            }
        } else {
            Log::warning('Blog not found with any slug variation', [
                'originalSlug' => $currentSlug,
                'variations' => $slugVariations
            ]);
        }

        return null;
    }

    /**
     * Handle project redirects
     */
    private function handleProjectRedirect($request, $slugLang, $routeType)
    {
        $currentSlug = $request->segment(3);
        Log::info('Processing project redirect', [
            'originalSlug' => $currentSlug,
            'routeType' => $routeType,
            'targetLang' => $slugLang,
            'url' => $request->url()
        ]);

        // Multiple attempts to find the project with different slug variations
        $slugVariations = $this->generateSlugVariations($currentSlug);

        $project = null;
        $matchedSlug = null;

        // First try: Direct database search with all variations
        foreach ($slugVariations as $variation) {
            $project = Project::where(function ($query) use ($variation) {
                $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.ar')) = ?", [$variation])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.en')) = ?", [$variation])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.fr')) = ?", [$variation])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.de')) = ?", [$variation])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.es')) = ?", [$variation]);
            })->first();

            if ($project) {
                $matchedSlug = $variation;
                Log::info('Found project with variation', [
                    'projectId' => $project->id,
                    'matchedSlug' => $variation,
                    'targetLang' => $slugLang
                ]);
                break;
            }
        }

        // If still not found, try manual iteration (fallback)
        if (!$project) {
            Log::info('Trying fallback method for project search');
            $projects = Project::all();
            foreach ($projects as $p) {
                foreach (['ar', 'en', 'fr', 'de', 'es'] as $lang) {
                    $projectSlug = $p->getTranslation('slug', $lang);
                    foreach ($slugVariations as $variation) {
                        if ($projectSlug === $variation) {
                            $project = $p;
                            $matchedSlug = $variation;
                            Log::info('Found project by manual iteration', [
                                'projectId' => $project->id,
                                'matchedSlug' => $projectSlug,
                                'language' => $lang
                            ]);
                            break 3;
                        }
                    }
                }
            }
        }

        Log::info('Project search result', [
            'project' => $project ? $project->id : 'null',
            'matchedSlug' => $matchedSlug
        ]);

        if ($project) {
            $correctSlug = $project->getTranslation('slug', $slugLang);
            Log::info('Correct slug for target language', [
                'targetLang' => $slugLang,
                'correctSlug' => $correctSlug,
                'currentSlug' => $currentSlug
            ]);

            // Check if we already have the correct URL
            $currentFullUrl = $request->url();
            $expectedUrl = url("/$slugLang/$routeType/{$correctSlug}");

            if ($correctSlug && $currentFullUrl !== $expectedUrl && $correctSlug !== $currentSlug) {
                // Use rawurlencode for Arabic slugs to prevent double encoding
                $encodedSlug = rawurlencode($correctSlug);
                $saferUrl = url("/$slugLang/$routeType/{$encodedSlug}");

                Log::info('Redirecting project to correct URL', [
                    'from' => $currentFullUrl,
                    'to' => $saferUrl,
                    'correctSlug' => $correctSlug,
                    'encodedSlug' => $encodedSlug,
                    'reason' => 'slug_mismatch'
                ]);
                return redirect($saferUrl, 301);
            } elseif ($correctSlug && ($correctSlug === $currentSlug || $currentFullUrl === $expectedUrl)) {
                Log::info('Slug is already correct, no redirect needed');
            } else {
                Log::warning('No correct slug found for target language', [
                    'targetLang' => $slugLang,
                    'projectId' => $project->id
                ]);
            }
        } else {
            Log::warning('Project not found with any slug variation', [
                'originalSlug' => $currentSlug,
                'variations' => $slugVariations
            ]);
        }

        return null;
    }

    /**
     * Handle service redirects
     */
    private function handleServiceRedirect($request, $slugLang, $routeType)
    {
        $currentSlug = $request->segment(3);
        Log::info('Processing service redirect', [
            'originalSlug' => $currentSlug,
            'routeType' => $routeType,
            'targetLang' => $slugLang,
            'url' => $request->url()
        ]);

        // Multiple attempts to find the service with different slug variations
        $slugVariations = $this->generateSlugVariations($currentSlug);

        $service = null;
        $matchedSlug = null;

        // First try: Direct database search with all variations
        foreach ($slugVariations as $variation) {
            $service = Service::where(function ($query) use ($variation) {
                $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.ar')) = ?", [$variation])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.en')) = ?", [$variation])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.fr')) = ?", [$variation])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.de')) = ?", [$variation])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.es')) = ?", [$variation]);
            })->first();

            if ($service) {
                $matchedSlug = $variation;
                Log::info('Found service with variation', [
                    'serviceId' => $service->id,
                    'matchedSlug' => $variation,
                    'targetLang' => $slugLang
                ]);
                break;
            }
        }

        // If still not found, try manual iteration (fallback)
        if (!$service) {
            Log::info('Trying fallback method for service search');
            $services = Service::all();
            foreach ($services as $s) {
                foreach (['ar', 'en', 'fr', 'de', 'es'] as $lang) {
                    $serviceSlug = $s->getTranslation('slug', $lang);
                    foreach ($slugVariations as $variation) {
                        if ($serviceSlug === $variation) {
                            $service = $s;
                            $matchedSlug = $variation;
                            Log::info('Found service by manual iteration', [
                                'serviceId' => $service->id,
                                'matchedSlug' => $serviceSlug,
                                'language' => $lang
                            ]);
                            break 3;
                        }
                    }
                }
            }
        }

        Log::info('Service search result', [
            'service' => $service ? $service->id : 'null',
            'matchedSlug' => $matchedSlug
        ]);

        if ($service) {
            $correctSlug = $service->getTranslation('slug', $slugLang);
            Log::info('Correct slug for target language', [
                'targetLang' => $slugLang,
                'correctSlug' => $correctSlug,
                'currentSlug' => $currentSlug
            ]);

            // Check if we already have the correct URL
            $currentFullUrl = $request->url();
            $expectedUrl = url("/$slugLang/$routeType/{$correctSlug}");

            if ($correctSlug && $currentFullUrl !== $expectedUrl && $correctSlug !== $currentSlug) {
                // Use rawurlencode for Arabic slugs to prevent double encoding
                $encodedSlug = rawurlencode($correctSlug);
                $saferUrl = url("/$slugLang/$routeType/{$encodedSlug}");

                Log::info('Redirecting service to correct URL', [
                    'from' => $currentFullUrl,
                    'to' => $saferUrl,
                    'correctSlug' => $correctSlug,
                    'encodedSlug' => $encodedSlug,
                    'reason' => 'slug_mismatch'
                ]);
                return redirect($saferUrl, 301);
            } elseif ($correctSlug && ($correctSlug === $currentSlug || $currentFullUrl === $expectedUrl)) {
                Log::info('Slug is already correct, no redirect needed');
            } else {
                Log::warning('No correct slug found for target language', [
                    'targetLang' => $slugLang,
                    'serviceId' => $service->id
                ]);
            }
        } else {
            Log::warning('Service not found with any slug variation', [
                'originalSlug' => $currentSlug,
                'variations' => $slugVariations
            ]);
        }

        return null;
    }

    /**
     * Generate multiple slug variations for better matching
     */
    private function generateSlugVariations($slug)
    {
        $variations = [];

        // Original slug
        $variations[] = $slug;

        // URL decoded version (standard decoding)
        $decodedSlug = urldecode($slug);
        if ($decodedSlug !== $slug) {
            $variations[] = $decodedSlug;
        }

        // Raw URL decoded (alternative decoding)
        $rawDecodedSlug = rawurldecode($slug);
        if ($rawDecodedSlug !== $slug && $rawDecodedSlug !== $decodedSlug) {
            $variations[] = $rawDecodedSlug;
        }

        // Handle cases where UTF-8 is double-encoded
        if (preg_match('/%[0-9A-F]{2}/', $slug)) {
            // Try to decode step by step
            $step1 = urldecode($slug);
            $step2 = urldecode($step1);
            if ($step2 !== $step1 && !in_array($step2, $variations)) {
                $variations[] = $step2;
            }

            // Try to fix mojibake
            $fixed = $this->fixMojibake($step1);
            if ($fixed !== $step1 && !in_array($fixed, $variations)) {
                $variations[] = $fixed;
            }
        }

        // Remove duplicates and empty values
        $variations = array_unique(array_filter($variations));

        Log::info('Generated slug variations', [
            'original' => $slug,
            'variations' => $variations
        ]);

        return $variations;
    }

    /**
     * Fix mojibake encoding issues specifically
     */
    private function fixMojibake($text)
    {
        // Handle specific cases where Arabic gets mangled
        if (strpos($text, 'Ø') !== false || strpos($text, 'Ù') !== false) {
            // This looks like ISO-8859-1 interpretation of UTF-8
            $fixed = mb_convert_encoding($text, 'UTF-8', 'ISO-8859-1');
            if (mb_check_encoding($fixed, 'UTF-8')) {
                return $fixed;
            }
        }

        return $text;
    }

    /**
     * Clean slug from common encoding issues
     */
    private function cleanSlug($slug)
    {
        // Basic cleanup for Arabic text
        $cleanSlug = trim($slug);

        // Fix common URL encoding issues
        $cleanSlug = str_replace(['%20', '+'], ['-', '-'], $cleanSlug);

        // Try to handle double encoding issues
        if (strpos($cleanSlug, '%C3%98') !== false || strpos($cleanSlug, '%C3%99') !== false) {
            // This looks like double-encoded UTF-8
            $cleanSlug = urldecode($cleanSlug);
            if (strpos($cleanSlug, 'Ø') !== false) {
                // Still has encoding issues, try to fix
                $cleanSlug = mb_convert_encoding($cleanSlug, 'UTF-8', 'ISO-8859-1');
            }
        }

        // Remove any non-printable characters
        $cleanSlug = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $cleanSlug);

        return $cleanSlug;
    }
}
