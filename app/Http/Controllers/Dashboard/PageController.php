<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Pages\DeletePageRequest;
use App\Http\Requests\Dashboard\Pages\StorePageRequest;
use App\Http\Requests\Dashboard\Pages\UpdatePageRequest;
use App\Models\Page;
use App\Services\Dashboard\PageService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('pages.view');

        $pages = Page::all();

        return view('Dashboard.Pages.index',compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('pages.create');

        return view('Dashboard.Pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePageRequest $request , PageService $pageService)
    { 
    
        $this->authorize('pages.store');

        try {
            $data = $request->validated();

            $response =  $pageService->store($data);

            if(!$response) {
                return redirect()->back()->with(['error' => __('dashboard.failed_to_add_item')]);
            }

            return redirect()->route('dashboard.pages.index')->with(['success' => __('dashboard.your_item_added_successfully')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' =>  $e->getMessage()]);
        }
    }

   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        $this->authorize('pages.edit');

        return view('Dashboard.Pages.edit',compact('page'));
    }
    /**
     * Update the specified resource in storage.
     */
   public function update(UpdatePageRequest $request, Page $page ,PageService $pageService )
    {

        $this->authorize('pages.update');


        try {
            $data = $request->validated();

            $response = $pageService->update($data, $page);

            if(!$response) {
                return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
            }

            return redirect()->route('dashboard.pages.index')->with(['success' => __('dashboard.your_item_updated_successfully')]);
        } catch (\Exception $e) {

            return redirect()->back()->with(['error' =>  $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeletePageRequest $request, PageService $pageService )
    {
        $this->authorize('pages.delete');

        $selectedIds = $request->input('selectedIds');

        $data = $request->validated();

        $deleted = $pageService->delete($selectedIds,$data);


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
