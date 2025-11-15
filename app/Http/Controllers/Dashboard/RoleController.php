<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    protected $service;

    public function __construct(RoleService $role_service)
    {
        $this->service = $role_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('roles.view');

        $roles =  Role::all();

        return view('Dashboard.Roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('roles.create');

        $permissions = Permission::all();

        return view('Dashboard.Roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('roles.store');

        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'unique:roles,name'],
                'permissions' => ['required', 'array'],
            ]);

            $this->service->storeNewRole($validated);

            return redirect()->back()->with(['success' => __('dashboard.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('dashboard.failed_to_add_item')]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $this->authorize('roles.edit');

        $permissions = Permission::all();
        $role_permissions = $role->permissions()->get();
        // dd($role_permissions);
        return view('Dashboard.Roles.edit', compact('role', 'permissions', 'role_permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $this->authorize('roles.update');

        try {
            $validated = $request->validate([
                'name' => ['required', 'string'],
                'permissions' => ['required', 'array'],
            ]);

            $this->service->updateRole($validated, $role);

            return redirect()->back()->with(['success' => __('dashboard.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => __('dashboard.failed_to_add_item')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('roles.delete');

        // Implementation needed
    }
}
