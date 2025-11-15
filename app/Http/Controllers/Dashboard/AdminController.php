<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admins\DeleteAdminRequest;
use App\Http\Requests\Dashboard\Admins\StoreAdminRequest;
use App\Http\Requests\Dashboard\Admins\UpdateAdminRequest;
use App\Models\Admin;
use App\Services\Dashboard\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{

    protected $service;

    public function __construct(AdminService $adminService)
    {
        $this->service = $adminService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $this->authorize('admins.view');

        $admins = Admin::all();

        return view('Dashboard.Admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('admins.create');

        $permissionGroups = Permission::where('guard_name', 'admin')->get()->groupBy('group');

        return view('Dashboard.Admins.create', compact('permissionGroups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        $this->authorize('admins.store');
        try {
            $data = $request->validated();

            $response = (new AdminService())->store($request);

            if ($response) {
                return redirect()->route('dashboard.admins.index')->with(['success' => __('dashboard.your_item_added_successfully')]);
            } else {
                return redirect()->back()->with('error', 'Error occurred while adding.');
            }
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('dashboard.failed_to_add_item')]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        $this->authorize('admins.edit');
        $data['admin'] = $admin;
        $data['adminPermissions'] = $admin->permissions->pluck('name')->toArray();
        // $data['adminPermissions'] = $admin->getPermissionNames();

        $data['permissionGroups'] = Permission::where('guard_name', 'admin')->get()->groupBy('group');

        return view('Dashboard.Admins.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $this->authorize('admins.update');

        try {
            // Get validated data from the request
            $data = $request->validated();

            // Log the data for debugging
            Log::info('Admin update data:', $data);

            // Call the update method in your service
            $response = (new AdminService())->update($data, $admin);

            if ($response) {
                return redirect()->back()->with(['success' => __('dashboard.your_item_updated_successfully')]);
            } else {
                return redirect()->back()->with('error', 'Error occurred while updating.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Admin update error: ' . $e->getMessage());
            return redirect()->back()->with(['error' => __('dashboard.failed_to_add_item') . ': ' . $e->getMessage()]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteAdminRequest $request, Admin $admin)
    {

        $this->authorize('admins.delete');

        $selectedIds = $request->input('selectedIds');

        $deleted = $this->service->delete($selectedIds);

        if (request()->ajax()) {
            if (!$deleted) {
                return response()->json(['message' => $deleted ?? __('dashboard.an messages.error entering data')], 422);
            }
            return response()->json(['success' => true, 'message' => __('dashboard.your_items_deleted_successfully')]);
        }
        if (!$deleted) {
            return redirect()->back()->withErrors($delete ?? __('dashboard.an error has occurred. Please contact the developer to resolve the issue'));
        }
    }
}
