<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnalyticsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view analytics.
     */
    public function view(Admin $admin): bool
    {
        return $admin->hasPermissionTo('analytics.view');
    }

    /**
     * Determine whether the user can manage analytics.
     */
    public function manage(Admin $admin): bool
    {
        return $admin->hasPermissionTo('analytics.manage');
    }
}
