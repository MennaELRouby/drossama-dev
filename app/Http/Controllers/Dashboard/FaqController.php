<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Faqs\DeleteFaqRequest;
use App\Http\Requests\Dashboard\Faqs\StoreFaqRequest;
use App\Http\Requests\Dashboard\Faqs\UpdateFaqRequest;
use App\Models\Faq;
use App\Services\Dashboard\FaqService;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('faqs.view');

        $faqs = Faq::general()->get();

        return view('Dashboard.Faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('faqs.create');

        return view('Dashboard.Faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaqRequest $request)
    {
        $this->authorize('faqs.store');

        try {

            $data =  $request->validated();

            $response = (new FaqService())->store($request);

            return redirect()->route('dashboard.faqs.index')->with(['success' => __('dashboard.your_item_added_successfully')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' => __('dashboard.failed_to_add_item')]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        $this->authorize('faqs.edit');

        return view('Dashboard.Faqs.edit', compact('faq'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaqRequest $request, Faq $faq)
    {
        $this->authorize('faqs.update');
        try {

            $data = $request->validated();

            if (!isset($data['status'])) {
                $data['status'] = 0;
            }

            $response = (new FaqService())->update($request, $faq);
            return redirect()->route('dashboard.faqs.index')->with(['success' => __('dashboard.your_item_updated_successfully')]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteFaqRequest $request)
    {
        $this->authorize('faqs.delete');

        $selectedIds = $request->input('selectedIds');

        $request->validated();

        $deleted = (new FaqService())->delete($selectedIds);

        if (request()->ajax()) {
            if (!$deleted) {
                return response()->json(['message' => __('messages.an_error_occurred')], 422);
            }
            return response()->json(['success' => true, 'message' => __('dashboard.your_items_deleted_successfully')]);
        }
        if (!$deleted) {
            return redirect()->back()->withErrors(__('messages.an_error_occurred'));
        }
    }

    /**
     * Bulk remove FAQs.
     */
    public function bulkDestroy(DeleteFaqRequest $request)
    {
        $this->authorize('faqs.delete');

        $selectedIds = $request->input('selectedIds', []);

        try {
            $deleted = (new FaqService())->delete($selectedIds);

            if (request()->ajax()) {
                return response()->json([
                    'success' => (bool) $deleted,
                    'message' => $deleted ? __('dashboard.your_items_deleted_successfully') : __('messages.an_error_occurred')
                ], $deleted ? 200 : 500);
            }

            return redirect()->route('dashboard.faqs.index')->with(
                $deleted ? ['success' => __('dashboard.your_items_deleted_successfully')] : ['error' => __('messages.an_error_occurred')]
            );
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => __('messages.an_error_occurred')], 500);
            }
            return redirect()->back()->with('error', __('messages.an_error_occurred'));
        }
    }
}
