<?php

namespace App\Http\Controllers;

use App\Services\Seo\BuildSitemapService;

class SitemapController extends Controller
{
    public function generate(BuildSitemapService $sitemapService)
    {
        $sitemapService->generateSitemap();
        return redirect('/sitemap.xml');
    }
}
