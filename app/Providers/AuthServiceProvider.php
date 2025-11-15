<?php

namespace App\Providers;

use App\Models\Admin;
use App\Policies\AnalyticsPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Admin::class => AnalyticsPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define analytics permissions
        Gate::define('analytics.view', function (Admin $admin) {
            return $admin->hasPermissionTo('analytics.view');
        });

        Gate::define('analytics.manage', function (Admin $admin) {
            return $admin->hasPermissionTo('analytics.manage');
        });
    }
}
