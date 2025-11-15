<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Album\DeleteAlbumRequest;
use App\Http\Requests\Dashboard\Album\StoreAlbumRequest;
use App\Http\Requests\Dashboard\Album\UpdateAlbumRequest;
use App\Models\Album;
use App\Services\Dashboard\AlbumService;
use Illuminate\Http\Request;

class AlbumController extends Controller
{

    protected $albumService;

    public function __construct(AlbumService $albumService)
    {
        $this->albumService = $albumService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('albums.view');

        $albums = Album::orderBy('id', 'desc')->get();


        return view('Dashboard.Albums.index', compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $this->authorize('albums.create');
        $data['album'] = new Album();
        $data['albums'] = Album::get();
        return view('Dashboard.Albums.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlbumRequest $request)
    {
        $this->authorize('albums.store');
        try {
            $data = $request->validated();
            $response = $this->albumService->store($request, $data);
            // إضافة الصور بعد إنشاء المشروع
            if ($response && $request->hasFile('album_images')) {
                $album = $response; // دالة store ترجع كائن المشروع الجديد
                $maxOrder = 0;
                foreach ($request->file('album_images') as $image) {
                    $filename = \App\Helper\Media::uploadAndAttachImage($image, 'albums');
                    \App\Models\AlbumImage::create([
                        'album_id' => $album->id,
                        'image' => $filename,
                        'order' => ++$maxOrder,
                    ]);
                }
            }
            if (!$response) {
                return redirect()->back()->with(['error' => __('dashboard.failed_to_create_item')]);
            }
            return redirect()->route('dashboard.albums.index')->with(['success' => __('dashboard.your_item_created_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album)
    {
        $this->authorize('albums.edit');
        $data['album'] = $album;
        $data['albums'] = Album::get();

        return view('Dashboard.Albums.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlbumRequest $request, Album $album)
    {
        $this->authorize('albums.update');
        try {
            $data = $request->validated();
            $response = $this->albumService->update($request, $data, $album);
            // إضافة الصور الجديدة عند التحديث
            if ($request->hasFile('album_images')) {
                $maxOrder = \App\Models\AlbumImage::where('album_id', $album->id)->max('order') ?? 0;
                foreach ($request->file('album_images') as $image) {
                    $filename = \App\Helper\Media::uploadAndAttachImage($image, 'albums');
                    \App\Models\AlbumImage::create([
                        'album_id' => $album->id,
                        'image' => $filename,
                        'order' => ++$maxOrder,
                    ]);
                }
            }
            if (!$response) {
                return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
            }
            return redirect()->route('dashboard.albums.index')->with(['success' => __('dashboard.your_item_updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteAlbumRequest $request, string $id)
    {
        $this->authorize('albums.delete');

        // Get selectedIds from request, or use the single $id if not provided
        $selectedIds = $request->input('selectedIds');

        // If no selectedIds provided, use the single $id from route parameter
        if (empty($selectedIds)) {
            $selectedIds = [$id];
        }

        $data = $request->validated();

        $deleted = $this->albumService->delete($selectedIds, $data);


        if (request()->ajax()) {
            if (!$deleted) {
                return response()->json(['message' => $deleted ?? __('dashboard.an_error_occurred')], 422);
            }
            return response()->json(['success' => true, 'message' => __('dashboard.your_items_deleted_successfully')]);
        }

        if (!$deleted) {
            return redirect()->back()->withErrors(__('dashboard.an_error_occurred'));
        }

        return redirect()->route('dashboard.albums.index')->with('success', __('dashboard.your_item_deleted_successfully'));
    }

    /**
     * Change the category of a album.
     */
    public function changeCategory(Request $request, $id)
    {
        $this->authorize('albums.update');
        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);
        $album = Album::findOrFail($id);
        $album->category_id = $request->input('category_id');
        $album->save();
        return redirect()->back()->with('success', __('dashboard.your_item_updated_successfully'));
    }

    /**
     * Reorder album images using drag and drop
     */
    public function reorderImages(Request $request)
    {
        $imageIds = $request->input('image_ids');
        if (!is_array($imageIds)) {
            return response()->json(['success' => false, 'message' => __('dashboard.invalid_data')], 400);
        }
        try {
            foreach ($imageIds as $order => $imageId) {
                \App\Models\AlbumImage::where('id', $imageId)->update(['order' => $order]);
            }
            return response()->json(['success' => true, 'message' => __('dashboard.images_reordered_successfully')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => __('dashboard.error_reordering_images')], 500);
        }
    }

    /**
     * Delete selected images from an album
     */
    public function deleteSelectedImages(Request $request)
    {
        $this->authorize('albums.update');

        $request->validate([
            'image_ids' => 'required|array',
            'image_ids.*' => 'integer|exists:album_images,id'
        ]);

        try {
            $imageIds = $request->input('image_ids');

            // Delete the images from storage
            $images = \App\Models\AlbumImage::whereIn('id', $imageIds)->get();
            foreach ($images as $image) {
                if ($image->image && file_exists(public_path('storage/albums/' . $image->image))) {
                    unlink(public_path('storage/albums/' . $image->image));
                }
            }

            // Delete from database
            \App\Models\AlbumImage::whereIn('id', $imageIds)->delete();

            return response()->json([
                'success' => true,
                'message' => __('dashboard.selected_images_deleted_successfully')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('dashboard.error_deleting_images')
            ], 500);
        }
    }

    /**
     * Delete a single image from an album
     */
    public function deleteImage(Request $request)
    {
        $this->authorize('albums.update');

        $request->validate([
            'image' => 'required|integer|exists:album_images,id',
        ]);

        try {
            $imageId = $request->input('image');
            $image = \App\Models\AlbumImage::findOrFail($imageId);

            // Delete the file from storage
            if ($image->image && file_exists(public_path('storage/albums/' . $image->image))) {
                unlink(public_path('storage/albums/' . $image->image));
            }

            // Delete from database
            $image->delete();

            return response()->json([
                'success' => true,
                'message' => __('dashboard.image_deleted_successfully')
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error deleting album image: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => __('dashboard.an_error_occurred')
            ], 500);
        }
    }

    /**
     * Delete all images from an album
     */
    public function deleteAllImages(Request $request)
    {
        $this->authorize('albums.update');

        $request->validate([
            'album_id' => 'required|integer|exists:albums,id',
        ]);

        try {
            $albumId = $request->input('album_id');
            $images = \App\Models\AlbumImage::where('album_id', $albumId)->get();

            // Delete files from storage
            foreach ($images as $image) {
                if ($image->image && file_exists(public_path('storage/albums/' . $image->image))) {
                    unlink(public_path('storage/albums/' . $image->image));
                }
            }

            // Delete from database
            \App\Models\AlbumImage::where('album_id', $albumId)->delete();

            return response()->json([
                'success' => true,
                'message' => __('dashboard.all_images_deleted_successfully')
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error deleting all album images: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => __('dashboard.an_error_occurred')
            ], 500);
        }
    }
}
