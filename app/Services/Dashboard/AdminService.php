<?php

namespace App\Services\Dashboard;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AdminService
{
    public function store($data)
    {
        DB::beginTransaction();
        try {
            $admin =  Admin::create($data);

            $permissions = $data['permissions'];

            $admin->givePermissionTo($permissions);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    public function update($data, $admin)
    {

        DB::beginTransaction();

        try {

            if (empty($data['password'])) {
                unset($data['password']);
            }

            $permissions = $data['permissions'] ?? [];

            // Remove permissions from data before updating admin
            unset($data['permissions']);

            $admin->syncPermissions($permissions);

            $admin->update($data);

            DB::commit();
            return true;
        } catch (\Exception $e) {

            DB::rollBack();
            throw $e; // Re-throw the exception to see the actual error
        }
    }

    public function delete($selectedIds)
    {

        try {
            return  Admin::whereIn('id', $selectedIds)->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
