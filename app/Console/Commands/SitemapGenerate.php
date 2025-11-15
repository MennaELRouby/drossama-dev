<?php

namespace App\Console\Commands;

use App\Services\Seo\BuildSitemapService;
use Illuminate\Console\Command;

class SitemapGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate full multilingual sitemap for the website';

    /**
     * Execute the console command.
     */
    public function handle(BuildSitemapService $buildSitemap)
{
    $this->info('🔄 Generating sitemap and robots.txt...');
    
    try {
        $buildSitemap->generateSitemap();
        $this->info('✅ Sitemap and robots.txt generated successfully!');
    } catch (\Throwable $e) {
        $this->error('❌ Failed to generate sitemap: ' . $e->getMessage());
        return Command::FAILURE;
    }

    return Command::SUCCESS;
}


    // protected $commands = [
    //     \App\Console\Commands\GenerateRobotsTxt::class,
    // ];
}