<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BlogCategories\DeleteBlogCategoryRequest;
use App\Http\Requests\Dashboard\BlogCategories\StoreBlogCategoryRequest;
use App\Http\Requests\Dashboard\BlogCategories\UpdateBlogCategoryRequest;
use App\Models\BlogCategory;
use App\Services\Dashboard\BlogCategoryService;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{

    protected $service;

    public function __construct(BlogCategoryService $service)
    {
        $this->service = $service;
    }
   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('blog_categories.view');

        $categories = BlogCategory::orderBy('id','desc')->get();

        return view('Dashboard.BlogCategories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('blog_categories.create');

        return view('Dashboard.BlogCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogCategoryRequest $request)
    {
        try{
            $this->authorize('blog_categories.create');
            $this->service->store($request);
            return redirect()->route('dashboard.blog_categories.index')->with('success', __('dashboard.your_items_added_successfully'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $blogCategory)
    {
        $this->authorize('blog_categories.edit');

        return view('Dashboard.BlogCategories.edit', compact('blogCategory'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogCategoryRequest $request, BlogCategory $blogCategory)
    {
        try{
            $this->authorize('blog_categories.edit');
            $this->service->update($request, $blogCategory);
            return redirect()->route('dashboard.blog_categories.index')->with('success', __('dashboard.your_items_updated_successfully'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteBlogCategoryRequest $request, string $id)
    {
        $this->authorize('blog_categories.delete');

        $selectedIds = $request->input('selectedIds');

        $data = $request->validated();

        $deleted = $this->service->delete($selectedIds,$data);


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
