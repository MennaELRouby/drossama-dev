<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create analytics permissions
        Permission::create(['name' => 'analytics.view']);
        Permission::create(['name' => 'analytics.manage']);
        
        // Give analytics permissions to admin role
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo(['analytics.view', 'analytics.manage']);
        }
        
        // Give view permission to other roles if they exist
        $roles = ['manager', 'editor', 'viewer'];
        foreach ($roles as $roleName) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $role->givePermissionTo('analytics.view');
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove analytics permissions
        Permission::whereIn('name', ['analytics.view', 'analytics.manage'])->delete();
    }
};
