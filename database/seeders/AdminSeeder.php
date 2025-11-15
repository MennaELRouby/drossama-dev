<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $developer = Admin::updateOrCreate(
            ['email' => 'developer@developer.com'],
            [
                'name' => 'Developer',
                'email_verified_at' => now(),
                'password' => Hash::make(env('DEVELOPER_PASSWORD', Str::random(16))),
                'remember_token' => Str::random(10),
            ]
        );

        $admin = Admin::updateOrCreate(
            ['email' => 'admin@domain.com'],
            [
                'name' => 'Admin',
                'email_verified_at' => now(),
                'password' => Hash::make(env('ADMIN_PASSWORD', Str::random(16))),
                'remember_token' => Str::random(10),
            ]
        );


        $developer->givePermissionTo(Permission::where('guard_name', 'admin')->get());

        $admin->givePermissionTo(Permission::where('guard_name', 'admin')->get());


    }
}
