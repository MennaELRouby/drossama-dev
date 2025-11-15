<?php

namespace App\Observers;

use App\Models\Service;
use App\Services\Seo\BuildSitemapService;
// Cache import removed - cache is disabled

class ServiceObserver
{
    public function saved(Service $service)
    {
        // No cache clearing needed - cache is disabled
        app(BuildSitemapService::class)->generateSitemap();
    }

    public function deleting(Service $service)
    {
        // Optional: تنفيذ شيء قبل الحذف
    }

    public function deleted(Service $service)
    {
        // No cache clearing needed - cache is disabled
        app(BuildSitemapService::class)->generateSitemap();
    }

    public function forceDeleted(Service $service)
    {
        // No cache clearing needed - cache is disabled
        app(BuildSitemapService::class)->generateSitemap();
    }
}
