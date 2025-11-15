<?php

namespace App\Services\Dashboard;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{

    public function storeNewRole($data)
    {

        DB::transaction(function () use ($data) {
            try {
                $data['guard_name'] = 'admin';
                $role =  Role::create($data);
                $role->permissions()->sync($data['permissions']);

                DB::commit();

                return $role;
            } catch (\Exception $e) {
                DB::rollBack();

                throw $e;
            }
        });
    }
    public function updateRole($data, Role $role)
    {
        return DB::transaction(function () use ($data, $role) {

            $role->update([
                'name' => $data['name']
            ]);

            $role->permissions()->sync($data['permissions']);

            return $role;
        });
    }
}
