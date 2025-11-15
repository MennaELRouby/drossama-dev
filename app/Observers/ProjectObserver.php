<?php

namespace App\Observers;

use App\Models\Project as ModelsProject;
use App\Services\Seo\BuildSitemapService;
use Illuminate\Support\Facades\Log;


class ProjectObserver
{
    public function saved(ModelsProject $project)
    {
        app(BuildSitemapService::class)->generateSitemap();
    }

    public function deleting(ModelsProject $project)
    {
        // Optional: تنفيذ شيء قبل الحذف
    }

    public function deleted(ModelsProject $project)
    {
        try {
            app(BuildSitemapService::class)->generateSitemap();
        } catch (\Exception $e) {
            Log::error('Failed to generate sitemap after project deletion', [
                'error' => $e->getMessage(),
                'project_id' => $project->id
            ]);
        }
    }

    public function forceDeleted(ModelsProject $project)
    {
        try {
            app(BuildSitemapService::class)->generateSitemap();
        } catch (\Exception $e) {
            Log::error('Failed to generate sitemap after project force deletion', [
                'error' => $e->getMessage(),
                'project_id' => $project->id
            ]);
        }
    }
}
