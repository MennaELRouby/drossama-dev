<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Parteners\DeletePartenerRequest;
use App\Http\Requests\Dashboard\Parteners\StorePartenerRequest;
use App\Http\Requests\Dashboard\Parteners\UpdatePartenerRequest;
use App\Models\Partener;
use App\Services\Dashboard\PartenerService;
use Illuminate\Http\Request;

class PartenerController extends Controller
{

    protected $service;

    public function __construct(PartenerService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('parteners.view');
        $parteners = Partener::with('products')->get();
        return view('Dashboard.Parteners.index', compact('parteners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('parteners.create');
        return view('Dashboard.Parteners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePartenerRequest $request)
    {
        try {
            $this->authorize('parteners.store');
            $partener = $this->service->store($request);
            return redirect()->route('dashboard.parteners.index')->with('success', __('messages.created_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.error'));
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partener $partener)
    {
        $this->authorize('parteners.edit');
        return view('Dashboard.Parteners.edit', compact('partener'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartenerRequest $request, Partener $partener)
    {
        try {
            $this->authorize('parteners.edit');
            $this->service->update($request, $partener);
            return redirect()->route('dashboard.parteners.index')->with('success', __('dashboard.your_items_updated_successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeletePartenerRequest $request, string $id)
    {
        $this->authorize('parteners.delete');

        $selectedIds = $request->input('selectedIds');

        $request->validated();

        $deleted = $this->service->delete($selectedIds);


        if (request()->ajax()) {
            if (!$deleted) {
                return response()->json(['message' => __('dashboard.an messages.error entering data')], 422);
            }
            return response()->json(['success' => true, 'message' => __('dashboard.your_items_deleted_successfully')]);
        }
        if (!$deleted) {
            return redirect()->back()->withErrors(__('dashboard.an error has occurred. Please contact the developer to resolve the issue'));
        }
    }
}
