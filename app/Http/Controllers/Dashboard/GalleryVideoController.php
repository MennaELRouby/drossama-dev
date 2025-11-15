<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\GalleryVideos\DeleteRequest;
use App\Http\Requests\Dashboard\GalleryVideos\StoreRequest;
use App\Http\Requests\Dashboard\GalleryVideos\UpdateRequest;
use App\Models\GalleryVideo;
use App\Services\Dashboard\GalleryVideoService;
use Illuminate\Http\Request;

class GalleryVideoController extends Controller
{

    protected $service;

    public function __construct(GalleryVideoService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('gallery_videos.view');
        $gallery_videos = GalleryVideo::orderBy('created_at', 'desc')->get();
        return view('Dashboard.GalleryVideos.index', compact('gallery_videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('gallery_videos.create');
        return view('Dashboard.GalleryVideos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->authorize('gallery_videos.store');
        try {
            $response = $this->service->store($request);

            if (!$response) {
                return redirect()->back()->with(['error' => __('dashboard.failed_to_create_item')]);
            }
            return redirect()->route('dashboard.gallery_videos.index')->with(['success' => __('dashboard.your_item_created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GalleryVideo $gallery_video)
    {
        $this->authorize('gallery_videos.edit');

        return view('Dashboard.GalleryVideos.edit', compact('gallery_video'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, GalleryVideo $gallery_video)
    {
        $this->authorize('gallery_videos.update');
        try {
            $response = $this->service->update($request, $gallery_video);
            if (!$response) {
                return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
            }
            return redirect()->route('dashboard.gallery_videos.index')->with(['success' => __('dashboard.your_item_updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteRequest $request, string $id)
    {
        $this->authorize('gallery_videos.delete');

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
