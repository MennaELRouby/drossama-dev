<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Sliders\DeleteSliderRequest;
use App\Http\Requests\Dashboard\Sliders\StoreSliderRequest;
use App\Http\Requests\Dashboard\Sliders\UpdateSliderRequest;
use App\Models\Slider;
use App\Services\Dashboard\SliderService;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    protected $service;

    public function __construct(SliderService $sliderService)
    {
        $this->service = $sliderService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('sliders.view');

        $sliders = Slider::all();
        return view('Dashboard.Sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('sliders.create');

        return view('Dashboard.Sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSliderRequest $request)
    {
        $this->authorize('sliders.store');

        try {
            $response = (new SliderService())->store($request);
            if (!$response) {
                return redirect()->back()->with(['error' => __('dashboard.failed_to_add_item')]);
            }

            return redirect()->back()->with(['success' => __('dashboard.your_item_added_successfully')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('dashboard.failed_to_add_item')]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        $this->authorize('sliders.edit');

        return view('Dashboard.Sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSliderRequest $request, Slider $slider)
    {

        $this->authorize('sliders.update');

        try {
            $response = (new SliderService())->update($request, $slider);
            if (!$response) {
                return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
            }

            return redirect('dashboard/sliders')->with(['success' => __('dashboard.your_item_updated_successfully')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteSliderRequest $request, string $id)
    {
        $this->authorize('sliders.delete');

        // For individual delete, use the ID from the route
        $selectedIds = $request->input('selectedIds', [$id]);

        // If it's a single ID and not an array, make it an array
        if (!is_array($selectedIds)) {
            $selectedIds = [$selectedIds];
        }

        $data = $request->validated();

        try {
            $deleted = $this->service->delete($selectedIds, $data);

            if (request()->ajax()) {
                if (!$deleted) {
                    return response()->json(['message' => __('dashboard.an_error_occurred')], 422);
                }
                return response()->json(['success' => true, 'message' => __('dashboard.your_items_deleted_successfully')]);
            }

            if (!$deleted) {
                return redirect()->back()->withErrors(__('dashboard.an_error_occurred'));
            }

            return redirect()->back()->with(['success' => __('dashboard.your_items_deleted_successfully')]);
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
    public function bulkDestroy(Request $request)
    {
        $this->authorize('sliders.delete');

        $selectedIds = $request->input('selectedIds');

        if (empty($selectedIds)) {
            return response()->json(['message' => __('dashboard.no_items_selected')], 422);
        }

        try {
            $deleted = $this->service->delete($selectedIds, $request->all());

            if (request()->ajax()) {
                if (!$deleted) {
                    return response()->json(['message' => __('dashboard.an_error_occurred')], 422);
                }
                return response()->json(['success' => true, 'message' => __('dashboard.your_items_deleted_successfully')]);
            }

            if (!$deleted) {
                return redirect()->back()->withErrors(__('dashboard.an_error_occurred'));
            }

            return redirect()->back()->with(['success' => __('dashboard.your_items_deleted_successfully')]);
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['message' => __('dashboard.an_error_occurred')], 500);
            }
            return redirect()->back()->withErrors(__('dashboard.an_error_occurred'));
        }
    }

    /**
     * Toggle slider status (publish/unpublish)
     */
    public function toggleStatus(Slider $slider)
    {
        $this->authorize('sliders.update');

        try {
            $slider->update([
                'status' => $slider->status === 1 ? 0 : 1
            ]);

            $message = $slider->status === 1
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
