<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Menus\DeleteMenuRequest;
use App\Http\Requests\Dashboard\Menus\StoreMenuRequest;
use App\Http\Requests\Dashboard\Menus\UpdateMenuRequest;
use App\Models\Dashboard\Menu;
use App\Services\Dashboard\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $service;
    public function __construct(MenuService $menuService)
    {
        $this->service = $menuService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $this->authorize('menus.view'); // Temporarily disabled

        $menus = Menu::with('parent')->get();
        return view('Dashboard.Menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('menus.create'); // Temporarily disabled

        $menus = Menu::with('parent')->get();

        return view('Dashboard.Menus.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request)
    {
        // $this->authorize('menus.store'); // Temporarily disabled

        try {
            $data = $request->validated();

            $this->service->store($request);

            return redirect()->back()->with(['success' => __('dashboard.your_item_added_successfully')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('dashboard.failed_to_add_item')]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        // $this->authorize('menus.edit'); // Temporarily disabled

        $menus = Menu::all();
        return view('Dashboard.Menus.edit', compact('menu', 'menus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        // $this->authorize('menus.update'); // Temporarily disabled

        try {
            $data = $request->validated();

            $this->service->update($request, $menu);

            return redirect()->route('dashboard.menus.index')->with(['success' => __('dashboard.your_item_updated_successfully')]);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => __('status update failed')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteMenuRequest $request, Menu $menu)
    {
        // $this->authorize('menus.delete'); // Temporarily disabled

        try {
            $result = $this->service->delete([$menu->id]);

            if (request()->ajax()) {
                if (!$result['success']) {
                    return response()->json(['message' => $result['message']], 422);
                }
                return response()->json(['success' => true, 'message' => $result['message']]);
            }

            if (!$result['success']) {
                return redirect()->back()->withErrors($result['message']);
            }

            return redirect()->back()->with(['success' => $result['message']]);
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['message' => __('dashboard.an_error_occurred')], 500);
            }
            return redirect()->back()->withErrors(__('dashboard.an_error_occurred'));
        }
    }

    /**
     * Remove multiple resources from storage.
     */
    public function bulkDestroy(DeleteMenuRequest $request)
    {
        // $this->authorize('menus.delete'); // Temporarily disabled

        $selectedIds = $request->input('selectedIds');

        if (empty($selectedIds)) {
            return response()->json(['message' => __('dashboard.no_items_selected')], 422);
        }

        try {
            $result = $this->service->delete($selectedIds);

            if (request()->ajax()) {
                if (!$result['success']) {
                    return response()->json(['message' => $result['message']], 422);
                }
                return response()->json(['success' => true, 'message' => $result['message']]);
            }

            if (!$result['success']) {
                return redirect()->back()->withErrors($result['message']);
            }

            return redirect()->back()->with(['success' => $result['message']]);
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['message' => __('dashboard.an_error_occurred')], 500);
            }
            return redirect()->back()->withErrors(__('dashboard.an_error_occurred'));
        }
    }

    /**
     * Toggle menu status (publish/unpublish)
     */
    public function toggleStatus(Menu $menu)
    {
        // $this->authorize('menus.update'); // Temporarily disabled

        try {
            $menu->update([
                'status' => $menu->status === 1 ? 0 : 1
            ]);

            $message = $menu->status === 1
                ? __('dashboard.published_successfully')
                : __('dashboard.unpublished_successfully');

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->back()->with(['success' => $message]);
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => __('dashboard.an_error_occurred')
                ], 500);
            }
            return redirect()->back()->withErrors(__('dashboard.an_error_occurred'));
        }
    }
}
