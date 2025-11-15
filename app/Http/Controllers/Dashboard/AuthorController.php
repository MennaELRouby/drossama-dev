<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Authors\DeleteAuthorRequest;
use App\Http\Requests\Dashboard\Authors\StoreAuthorRequest;
use App\Http\Requests\Dashboard\Authors\UpdateAuthorRequest;
use App\Models\Author;
use App\Services\Dashboard\AuthorService;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    protected $service;
    public function __construct(AuthorService $service)
    {
        $this->service = $service;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('authors.view');
        $authors = Author::orderBy('id', 'desc')->get();
        return view('Dashboard.Authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('authors.create');
        return view('Dashboard.Authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        try{
            $this->authorize('authors.create');
            $this->service->store($request);
            return redirect()->route('dashboard.authors.index')->with('success', __('dashboard.your_items_added_successfully'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        $this->authorize('authors.edit');
        return view('Dashboard.Authors.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(UpdateAuthorRequest $request, Author $author)
    {
        $this->authorize('authors.update');
        try {
            $response = $this->service->update($request, $author);
            if (!$response) {
                return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
            }
            return redirect()->route('dashboard.authors.index')->with(['success' => __('dashboard.your_item_updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteAuthorRequest $request, string $id)
    {
        $this->authorize('authors.delete');

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
