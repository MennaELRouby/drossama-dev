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
        // Ensure analytics permissions exist
        $permissions = ['analytics.view', 'analytics.manage'];
        
        foreach($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission, 
                'guard_name' => 'admin'
            ]);
        }
        
        // Ensure admin role exists and has permissions
        $adminRole = Role::firstOrCreate([
            'name' => 'admin', 
            'guard_name' => 'admin'
        ]);
        
        $adminRole->givePermissionTo($permissions);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove analytics permissions
        Permission::whereIn('name', ['analytics.view', 'analytics.manage'])
            ->where('guard_name', 'admin')
            ->delete();
    }
};
