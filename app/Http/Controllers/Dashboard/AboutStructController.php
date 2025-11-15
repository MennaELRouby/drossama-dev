<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AboutStructs\DeleteAboutStructRequest;
use App\Http\Requests\Dashboard\AboutStructs\StoreAboutStructRequest;
use App\Http\Requests\Dashboard\AboutStructs\UpdateAboutStructRequest;
use App\Models\Dashboard\AboutStruct;
use App\Services\Dashboard\AboutService;
use App\Services\Dashboard\AboutStructService;
use Illuminate\Http\Request;

class AboutStructController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('about_structs.view');
        $about_structs = AboutStruct::orderBy('order')->get();
        return view('Dashboard.AboutStructs.index', compact('about_structs'));;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('about_structs.create');
        return view('Dashboard.AboutStructs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAboutStructRequest $request)
    {
        $this->authorize('about_structs.store');
        try {
            $data = $request->validated();
            $response =  (new AboutStructService())->store($request, $data);
            return redirect()->route('dashboard.about-structs.index')->with('success', __('dashboard.created_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AboutStruct $about_struct)
    {
        $this->authorize('about_structs.edit');
        return view('Dashboard.AboutStructs.edit', compact('about_struct'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAboutStructRequest $request, AboutStruct $about_struct)
    {
        $this->authorize('about_structs.update');
        try {
            $data = $request->validated();
            $response = (new AboutStructService())->update($request, $about_struct, $data);
            return redirect()->route('dashboard.about-structs.index')->with('success', __('dashboard.updated_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteAboutStructRequest $request, string $id)
    {
        $this->authorize('about_structs.view');
        $selectedIds = $request->input('selectedIds');

        $data = $request->validated();

        $deleted = (new AboutStructService())->delete($selectedIds);

        if (request()->ajax()) {
            if (!$deleted) {
                return response()->json(['message' => $deleted ?? __('dashboard.an messages.error entering data')], 422);
            }
            return response()->json(['success' => true, 'message' => __('dashboard.your_items_deleted_successfully')]);
        }
        if (!$deleted) {
            return redirect()->back()->withErrors($deleted ?? __('dashboard.an error has occurred. Please contact the developer to resolve the issue'));
        }
    }

    /**
     * Toggle publish status of the specified resource.
     */
    public function toggleStatus(AboutStruct $about_struct)
    {
        $this->authorize('about_structs.update');

        try {
            $about_struct->update([
                'status' => $about_struct->status === 1 ? 0 : 1
            ]);

            $message = $about_struct->status === 1
                ? __('dashboard.published_successfully')
                : __('dashboard.unpublished_successfully');

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'new_status' => $about_struct->status
                ]);
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['message' => __('dashboard.failed_to_update_item')], 422);
            }
            return redirect()->back()->with('error', __('dashboard.failed_to_update_item'));
        }
    }
}
