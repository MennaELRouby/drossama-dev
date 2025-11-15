<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Services\DeleteServiceRequest;
use App\Http\Requests\Dashboard\Services\StoreServiceRequest;
use App\Http\Requests\Dashboard\Services\UpdateServiceRequest;
use App\Models\Service;
use App\Models\ServiceImage;
use App\Services\Dashboard\Service as DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $this->authorize('services.view');
            $services = Service::with('parent')->get();
            Log::info('Services index accessed successfully', ['count' => $services->count()]);
            return view('Dashboard.Services.index', compact('services'));
        } catch (\Exception $e) {
            Log::error('Error accessing services index: ' . $e->getMessage());
            return redirect()->back()->withErrors(__('dashboard.an error has occurred'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $this->authorize('services.create');
            $services = Service::with('parent')->get();
            Log::info('Service create form accessed successfully');
            return view('Dashboard.Services.create', compact('services'));
        } catch (\Exception $e) {
            Log::error('Error accessing service create form: ' . $e->getMessage());
            return redirect()->back()->withErrors(__('dashboard.an error has occurred'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $this->authorize('services.store');

        try {
            $data = $request->validated();
            Log::info('Creating new service', ['data' => Arr::except($data, ['image', 'icon', 'service_images'])]);

            $response = (new DashboardService())->store($request, $data);

            if (!$response) {
                Log::warning('Failed to create service');
                return redirect()->back()->with(['error' => __('dashboard.failed_to_add_item')]);
            }

            Log::info('Service created successfully');
            return redirect()->back()->with(['success' => __('dashboard.your_item_added_successfully')]);
        } catch (\Exception $e) {
            Log::error('Error creating service: ' . $e->getMessage());
            return redirect()->back()->with(['error' => __('dashboard.failed_to_add_item')]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        try {
            $this->authorize('services.view');
            $data['service'] = $service->load('serviceImages');
            $data['services'] = Service::with('parent')->get();
            Log::info('Service show accessed successfully', ['service_id' => $service->id]);
            return view('Dashboard.Services.create', $data);
        } catch (\Exception $e) {
            Log::error('Error accessing service show: ' . $e->getMessage());
            return redirect()->back()->withErrors(__('dashboard.an error has occurred'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        try {
            $this->authorize('services.edit');
            $data['service'] = $service->fresh()->load('serviceImages');
            $data['services'] = Service::with('parent')->get();
            Log::info('Service edit form accessed successfully', ['service_id' => $service->id]);
            return view('Dashboard.Services.edit', $data);
        } catch (\Exception $e) {
            Log::error('Error accessing service edit form: ' . $e->getMessage());
            return redirect()->back()->withErrors(__('dashboard.an error has occurred'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $this->authorize('services.update');

        try {
            $data = $request->validated();
            Log::info('Updating service', [
                'service_id' => $service->id,
                'data' => Arr::except($data, ['image', 'icon', 'service_images'])
            ]);

            $response = (new DashboardService())->update($request, $data, $service);

            if (!$response) {
                Log::warning('Failed to update service', ['service_id' => $service->id]);
                return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
            }

            Log::info('Service updated successfully', ['service_id' => $service->id]);
            return redirect()->route('dashboard.services.index')->with(['success' => __('dashboard.your_item_updated_successfully')]);
        } catch (\Exception $e) {
            Log::error('Error updating service: ' . $e->getMessage(), ['service_id' => $service->id]);
            return redirect()->back()->with(['error' => __('dashboard.failed_to_update_item')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteServiceRequest $request, $service)
    {
        $this->authorize('services.delete');

        $serviceId = is_object($service) ? $service->id : $service;
        $selectedIds = $request->input('selectedIds', [$serviceId]);
        Log::info('Delete request received', [
            'service' => $service,
            'serviceId' => $serviceId,
            'selectedIds' => $selectedIds,
            'request' => request()->all()
        ]);

        try {
            Log::info('Starting delete operation', [
                'selectedIds' => $selectedIds,
                'request_method' => $request->method(),
                'request_url' => $request->url(),
                'request_headers' => $request->headers->all()
            ]);

            $service = new DashboardService();
            $deleted = $service->delete($selectedIds);

            Log::info('Delete operation completed', [
                'success' => $deleted,
                'selectedIds' => $selectedIds
            ]);

            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => __('dashboard.your_items_deleted_successfully')]);
            }
            return redirect()->back()->with(['success' => __('dashboard.your_items_deleted_successfully')]);
        } catch (\Exception $e) {
            Log::error('Delete operation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => __('dashboard.an error has occurred')], 422);
            }
            return redirect()->back()->withErrors(__('dashboard.an error has occurred'));
        }
    }

    /**
     * Remove multiple services from storage.
     */
    public function bulkDestroy(DeleteServiceRequest $request)
    {
        $this->authorize('services.delete');

        $selectedIds = $request->input('selectedIds', []);
        Log::info('Bulk delete request received', [
            'selectedIds' => $selectedIds,
            'request' => request()->all()
        ]);

        try {
            Log::info('Starting bulk delete operation', [
                'selectedIds' => $selectedIds,
                'request_method' => $request->method(),
                'request_url' => $request->url(),
                'request_headers' => $request->headers->all()
            ]);

            $service = new DashboardService();
            $deleted = $service->delete($selectedIds);

            Log::info('Bulk delete operation completed', [
                'success' => $deleted,
                'selectedIds' => $selectedIds
            ]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => $deleted,
                    'message' => $deleted ? __('messages.deleted_successfully') : __('messages.an_error_occurred')
                ]);
            }

            return redirect()->route('dashboard.services.index')->with('success', __('messages.deleted_successfully'));
        } catch (\Exception $e) {
            Log::error('Bulk delete operation failed', [
                'error' => $e->getMessage(),
                'selectedIds' => $selectedIds,
                'trace' => $e->getTraceAsString()
            ]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => __('messages.an_error_occurred')
                ], 500);
            }

            return redirect()->back()->with('error', __('messages.an_error_occurred'));
        }
    }

    /**
     * Remove a specific service image.
     */
    public function destroyImage($id)
    {
        try {
            $image = ServiceImage::findOrFail($id);
            $filename = $image->getImageFilenameAttribute();

            if ($filename) {
                \App\Helper\Media::removeFile('services', $filename);
                Log::info('Service image file deleted', [
                    'image_id' => $id,
                    'filename' => $filename
                ]);
            }

            $image->delete();
            Log::info('Service image deleted successfully', ['image_id' => $id]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error deleting service image: ' . $e->getMessage(), ['image_id' => $id]);
            return response()->json(['success' => false, 'message' => __('dashboard.an error has occurred')], 500);
        }
    }

    // رفع صور متعددة للخدمة عبر Dropzone
    public function uploadImages(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:jpg,jpeg,png,webp,gif|max:5120',
                'serviceId' => 'required|exists:services,id',
            ]);

            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $filename = \App\Helper\Media::uploadAndAttachImageStorage($image, 'services');

                // الحصول على أعلى ترتيب موجود وإضافة 1
                $maxOrder = ServiceImage::where('service_id', $request->input('serviceId'))->max('order') ?? 0;

                ServiceImage::create([
                    'service_id' => $request->input('serviceId'),
                    'image' => $filename,
                    'order' => $maxOrder + 1,
                ]);

                Log::info('Service image uploaded successfully', [
                    'service_id' => $request->input('serviceId'),
                    'filename' => $filename,
                    'order' => $maxOrder + 1
                ]);

                return response()->json(['success' => true, 'filename' => $filename]);
            }

            return response()->json(['success' => false], 400);
        } catch (\Exception $e) {
            Log::error('Error uploading service image: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => __('dashboard.an error has occurred')], 500);
        }
    }

    // حذف صورة مرفوعة مؤقتاً
    public function removeUploadImages(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
            ]);

            $filename = $request->input('name');
            \App\Helper\Media::removeFile('services', $filename);
            ServiceImage::where('image', $filename)->delete();

            Log::info('Temporary service image removed', ['filename' => $filename]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error removing temporary service image: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => __('dashboard.an error has occurred')], 500);
        }
    }

    // حذف صورة من الخدمة (زر الحذف)
    public function deleteImage(Request $request)
    {
        try {
            $imageId = $request->input('image');
            $image = ServiceImage::find($imageId);

            if ($image) {
                $filename = $image->getImageFilenameAttribute();
                if ($filename) {
                    \App\Helper\Media::removeFile('services', $filename);
                    Log::info('Service image file deleted', [
                        'image_id' => $imageId,
                        'filename' => $filename
                    ]);
                }

                $image->delete();
                Log::info('Service image deleted successfully', ['image_id' => $imageId]);
                return response()->json(['success' => true]);
            }

            return response()->json(['success' => false], 404);
        } catch (\Exception $e) {
            Log::error('Error deleting service image: ' . $e->getMessage(), ['image_id' => $request->input('image')]);
            return response()->json(['success' => false, 'message' => __('dashboard.an error has occurred')], 500);
        }
    }

    public function deleteAllImages(Request $request)
    {
        try {
            $serviceId = $request->input('service_id');
            $service = Service::findOrFail($serviceId);
            $images = $service->images;

            if ($images->isEmpty()) {
                Log::warning('No images found for service', ['service_id' => $serviceId]);
                return response()->json(['success' => false, 'message' => __('dashboard.no_images_found')], 404);
            }

            foreach ($images as $image) {
                $filename = $image->getImageFilenameAttribute();
                if ($filename) {
                    \App\Helper\Media::removeFile('services', $filename);
                    Log::info('Service image file deleted', [
                        'service_id' => $serviceId,
                        'image_id' => $image->id,
                        'filename' => $filename
                    ]);
                }
                $image->delete();
            }

            Log::info('All service images deleted successfully', [
                'service_id' => $serviceId,
                'count' => $images->count()
            ]);

            return response()->json(['success' => true, 'message' => __('dashboard.all_images_deleted_successfully')]);
        } catch (\Exception $e) {
            Log::error('Error deleting all service images: ' . $e->getMessage(), ['service_id' => $request->input('service_id')]);
            return response()->json(['success' => false, 'message' => __('dashboard.an error has occurred')], 500);
        }
    }

    public function deleteSelectedImages(Request $request)
    {
        try {
            $imageIds = $request->input('image_ids');

            if (is_array($imageIds)) {
                foreach ($imageIds as $imageId) {
                    $image = ServiceImage::find($imageId);
                    if ($image) {
                        $filename = $image->getImageFilenameAttribute();
                        if ($filename) {
                            \App\Helper\Media::removeFile('services', $filename);
                            Log::info('Service image file deleted', [
                                'image_id' => $imageId,
                                'filename' => $filename
                            ]);
                        }
                        $image->delete();
                    }
                }

                Log::info('Selected service images deleted successfully', ['count' => count($imageIds)]);
                return response()->json(['success' => true, 'message' => __('dashboard.selected_images_deleted_successfully')]);
            }

            return response()->json(['success' => false, 'message' => __('dashboard.no_images_selected')], 400);
        } catch (\Exception $e) {
            Log::error('Error deleting selected service images: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => __('dashboard.an error has occurred')], 500);
        }
    }

    /**
     * Reorder service images using drag and drop
     */
    public function reorderImages(Request $request)
    {
        try {
            $imageIds = $request->input('image_ids');

            if (!is_array($imageIds)) {
                Log::warning('Invalid image IDs for reordering', ['image_ids' => $imageIds]);
                return response()->json(['success' => false, 'message' => __('dashboard.invalid_data')], 400);
            }

            foreach ($imageIds as $order => $imageId) {
                ServiceImage::where('id', $imageId)->update(['order' => $order]);
            }

            Log::info('Service images reordered successfully', [
                'count' => count($imageIds),
                'image_ids' => $imageIds
            ]);

            return response()->json(['success' => true, 'message' => __('dashboard.images_reordered_successfully')]);
        } catch (\Exception $e) {
            Log::error('Error reordering service images: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => __('dashboard.error_reordering_images')], 500);
        }
    }

    /**
     * Toggle service status (publish/unpublish)
     */
    public function toggleStatus(Service $service)
    {
        $this->authorize('services.update');

        try {
            $service->update([
                'status' => $service->status === 1 ? 0 : 1
            ]);

            $message = $service->status === 1
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
            Log::error('Error toggling service status: ' . $e->getMessage());

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
