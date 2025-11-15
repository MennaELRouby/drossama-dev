<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Sections\DeleteSectionRequest;
use App\Http\Requests\Dashboard\Sections\StoreSectionRequest;
use App\Http\Requests\Dashboard\Sections\UpdateSectionRequest;
use App\Models\Section;
use App\Services\Dashboard\SectionService;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    protected $section_service;

    public function __construct(SectionService $section_service)
    {
        $this->section_service = $section_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $this->authorize('sections.view');

        $sections = Section::all();

        return view('Dashboard.Sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('sections.create');

        return view('Dashboard.Sections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSectionRequest $request)
    {
        try {

            $this->authorize('sections.store');

            $response = $this->section_service->store($request);

            if (!$response) {
                return redirect()->back()->with(['error' => __('dashboard.failed_to_create_item')]);
            }
            return redirect()->route('dashboard.sections.index')->with(['success' => __('dashboard.your_item_created_successfully')]);
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Error occurred while creating section: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        $this->authorize('sections.edit');

        return view('Dashboard.Sections.edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSectionRequest $request, Section $section)
    {
        try {
            $this->authorize('sections.edit');

            $response = $this->section_service->update($request, $section);

            if ($response) {
                return redirect()->route('dashboard.sections.index')->with(['success' => __('dashboard.your_item_updated_successfully')]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error occurred while updating section: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteSectionRequest $request, string $id)
    {
        $this->authorize('sections.delete');

        $selectedIds = $request->input('selectedIds');

        $data = $request->validated();

        $deleted = $this->section_service->delete($selectedIds, $data);


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

    /**
     * Bulk destroy sections
     */
    public function bulkDestroy(DeleteSectionRequest $request)
    {
        $this->authorize('sections.delete');

        $selectedIds = $request->input('selectedIds');
        $data = $request->validated();

        $deleted = $this->section_service->delete($selectedIds, $data);

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

    /**
     * Toggle section status (publish/unpublish)
     */
    public function toggleStatus(Section $section)
    {
        $this->authorize('sections.update');

        try {
            $section->update([
                'status' => $section->status === 1 ? 0 : 1
            ]);

            $message = $section->status === 1
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
