<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\Seo\BuildSitemapService;


class ProductObserver
{
    public function saved(Product $product)
    {
        app(BuildSitemapService::class)->generateSitemap();
    }

    public function deleting(Product $product)
    {
        // Optional: تنفيذ شيء قبل الحذف
    }

    public function deleted(Product $product)
    {
        app(BuildSitemapService::class)->generateSitemap();
    }

    public function forceDeleted(Product $product)
    {
        app(BuildSitemapService::class)->generateSitemap();
    }
}
