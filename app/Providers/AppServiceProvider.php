<?php

namespace App\Providers;

use App\Models\Dashboard\Hosting;
use App\Models\Dashboard\Menu;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Phone;
use App\Models\Service;
use App\Models\Setting;
use App\Models\SiteAddress;
use App\Models\Project;
use App\Models\Client;
use App\Models\Partener;
use App\Models\Section;
use App\Observers\BlogObserver;
use App\Observers\ProductObserver;
use App\Observers\ProjectObserver;
use App\Observers\ServiceObserver;
use App\Observers\PhoneObserver;
use App\Observers\SettingObserver;
use App\Models\Blog;
use Illuminate\Database\Eloquent\Model;
// Cache completely disabled - all queries are direct
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Prevent lazy loading in non-production environments
        Model::preventLazyLoading(! $this->app->environment('production'));

        $lang = app()->getLocale();

        // Load settings without cache - direct queries for real-time data
        if (Schema::hasTable('settings')) {
            // Register Setting Observer for PWA icon auto-generation
            Setting::observe(SettingObserver::class);

            $configrations = Setting::where('lang', $lang)
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->key => $item->value];
                })->toArray();

            $settings = Setting::where('lang', 'all')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->key => $item->value];
                })->toArray();

            Config::set('configrations', $configrations);
            Config::set('settings', $settings);
        }

        // Load menus without cache
        if (Schema::hasTable('menus')) {
            $menus = Menu::active()
                ->whereNull('parent_id')
                ->with(['children' => function ($query) {
                    $query->active()->orderBy('order', 'asc');
                }])
                ->orderBy('order', 'asc')
                ->get();
            View::share('menus', $menus);
        }

        // Load site addresses without cache
        if (Schema::hasTable('site_addresses')) {
            $site_addresses = SiteAddress::active()->orderBy('order')->get();
            View::share('site_addresses', $site_addresses);
        }

        // Load services without cache
        if (Schema::hasTable('services')) {
            Service::observe(ServiceObserver::class);

            $headerServices = Service::header()->active()->take(4)->get();
            View::share('headerServices', $headerServices);

            $footerServices = Service::footer()->active()->take(4)->get();
            View::share('footerServices', $footerServices);

            $relatedServices = Service::active()->get();
            View::share('relatedServices', $relatedServices);
        }

        // Load clients without cache
        if (Schema::hasTable('clients')) {
            $clients = Client::active()->get();
            View::share('clients', $clients);
        }

        // Load partners without cache
        if (Schema::hasTable('parteners')) {
            $parteners = Partener::active()->get();
            View::share('parteners', $parteners);
        }

        // Load products without cache
        if (Schema::hasTable('products')) {
            Product::observe(ProductObserver::class);

            $headerProducts = Product::header()->active()->take(4)->get();
            View::share('headerProducts', $headerProducts);

            $footerProducts = Product::footer()->active()->take(4)->get();
            View::share('footerProducts', $footerProducts);
        }

        // Load projects without cache
        if (Schema::hasTable('projects')) {
            Project::observe(ProjectObserver::class);

            $headerProjects = Project::header()->active()->take(4)->get();
            View::share('headerProjects', $headerProjects);

            $footerProjects = Project::footer()->active()->take(4)->get();
            View::share('footerProjects', $footerProjects);
        }

        // Load sliders without cache
        if (Schema::hasTable('sliders')) {
            $top_header = Slider::TopHeader()->active()->first();
            View::share('top_header', $top_header ?? null);
        }

        // Load phones without cache - always fresh data
        if (Schema::hasTable('phones')) {
            Phone::observe(PhoneObserver::class);
            $phones = Phone::active()->orderBy('order', 'asc')->get();
            View::share('phones', $phones);
        }

        // Load sections without cache
        if (Schema::hasTable('sections')) {
            $sections = Section::all();
            View::share('sections', $sections);
        }

        // Load blogs without cache
        if (Schema::hasTable('blogs')) {
            Blog::observe(BlogObserver::class);
            $blogs = Blog::active()->get();
            View::share('blogs', $blogs);
        }

        // Load hostings without cache
        if (Schema::hasTable('hostings')) {
            $hostings = Hosting::active()->get();
            View::share('hostings', $hostings);
        }

        // Register custom Blade directives for safe property access
        $this->registerBladeDirectives();

        // Create default roles and permissions if they don't exist
        $this->createDefaultRolesAndPermissions();
    }

    /**
     * Register custom Blade directives
     * دوال مخصصة لاستخدامها في Blade Templates
     */
    private function registerBladeDirectives()
    {
        // @safe directive - لعرض الخاصية بشكل آمن مع قيمة افتراضية
        // Usage: @safe($about->title, 'Default Title')
        Blade::directive('safe', function ($expression) {
            return "<?php echo e(optional($expression)->first ?? ($expression)->last ?? ''); ?>";
        });

        // @ifModel directive - للتحقق من وجود الموديل وعدم كونه فارغ
        // Usage: @ifModel($about) ... @endifModel
        Blade::if('ifModel', function ($model) {
            return $model && (is_object($model) && method_exists($model, 'exists') ? $model->exists : true);
        });
    }

    /**
     * Create default roles and permissions
     */
    private function createDefaultRolesAndPermissions()
    {
        if (!Schema::hasTable('roles') || !Schema::hasTable('permissions')) {
            return;
        }

        try {
            // Create Super Admin role if it doesn't exist
            $superAdminRole = Role::firstOrCreate([
                'name' => 'Super Admin',
                'guard_name' => 'web'
            ]);

            // Create basic permissions
            $permissions = [
                'view dashboard',
                'manage users',
                'manage content',
                'manage settings'
            ];

            foreach ($permissions as $permission) {
                Permission::firstOrCreate([
                    'name' => $permission,
                    'guard_name' => 'web'
                ]);
            }

            // Assign all permissions to Super Admin
            $allPermissions = Permission::where('guard_name', 'web')->get();
            $superAdminRole->syncPermissions($allPermissions);
        } catch (\Exception $e) {
            // Ignore permission errors during bootstrap
        }
    }
}
