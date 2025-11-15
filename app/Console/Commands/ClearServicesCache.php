<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearServicesCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clear-website {--type=all : Type of cache to clear (all, services, menus, products, etc.)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear website cache (services, menus, products, projects, clients, etc.)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->option('type');
        
        switch ($type) {
            case 'services':
                $this->clearServicesCache();
                break;
            case 'products':
                $this->clearProductsCache();
                break;
            case 'projects':
                $this->clearProjectsCache();
                break;
            case 'menus':
                $this->clearMenusCache();
                break;
            case 'all':
            default:
                $this->clearAllWebsiteCache();
                break;
        }
        
        return 0;
    }
    
    private function clearServicesCache()
    {
        Cache::forget('header_services');
        Cache::forget('footer_services');
        Cache::forget('related_services');
        
        $this->info('✅ Services cache cleared successfully!');
    }
    
    private function clearProductsCache()
    {
        Cache::forget('header_products');
        Cache::forget('footer_products');
        
        $this->info('✅ Products cache cleared successfully!');
    }
    
    private function clearProjectsCache()
    {
        Cache::forget('header_projects');
        Cache::forget('footer_projects');
        
        $this->info('✅ Projects cache cleared successfully!');
    }
    
    private function clearMenusCache()
    {
        Cache::forget('website_menus');
        
        $this->info('✅ Menus cache cleared successfully!');
    }
    
    private function clearAllWebsiteCache()
    {
        $cacheKeys = [
            'website_menus',
            'site_addresses',
            'header_services',
            'footer_services', 
            'related_services',
            'website_clients',
            'website_parteners',
            'header_products',
            'footer_products',
            'header_projects',
            'footer_projects',
            'top_header_slider',
            'website_phones',
            'website_sections',
            'website_blogs'
        ];
        
        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
        
        $this->info('✅ All website cache cleared successfully!');
        $this->line('🔄 Cleared ' . count($cacheKeys) . ' cache keys');
        $this->table(['Cache Keys Cleared'], array_map(fn($key) => [$key], $cacheKeys));
    }
}
