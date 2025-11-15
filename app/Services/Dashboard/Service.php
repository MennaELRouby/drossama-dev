<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Models\Service as ModelsService;
use App\Models\ServiceImage;
use App\Services\JsonTranslationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class Service
{
    /**
     * Create a new class instance.
     */
    public function store($request, $data)
    {
        DB::beginTransaction();

        try {
            // Prepare main data (non-translatable fields)
            $mainData = [
                'parent_id' => $data['parent_id'] ?? null,
                'image' => null,
                'alt_image' => $data['alt_image'] ?? null,
                'icon' => null,
                'alt_icon' => $data['alt_icon'] ?? null,
                'status' => $data['status'] ?? 1,
                'show_in_home' => $data['show_in_home'] ?? 0,
                'show_in_header' => $data['show_in_header'] ?? 0,
                'show_in_footer' => $data['show_in_footer'] ?? 0,
                'index' => $data['index'] ?? 0,
                'order' => $data['order'] ?? 0,
            ];

            if ($request->hasFile('image')) {
                $mainData['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'services');
            }

            if ($request->hasFile('icon')) {
                $mainData['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'services');
            }

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('service');

            // Create the Service with translations
            $service = JsonTranslationService::createWithTranslations(
                ModelsService::class,
                $mainData,
                $request,
                $translationFields
            );

            // Handle service images upload if any
            if ($request->hasFile('service_images')) {
                $this->handleServiceImagesUpload($request->file('service_images'), $service->id);
            }

            DB::commit();
            Log::info('Service created successfully', ['service_id' => $service->id]);

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create service: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update($request, $data, $service)
    {
        DB::beginTransaction();
        try {
            // Prepare main data (non-translatable fields)
            $mainData = [
                'parent_id' => $data['parent_id'] ?? $service->parent_id,
                'alt_image' => $data['alt_image'] ?? $service->alt_image,
                'alt_icon' => $data['alt_icon'] ?? $service->alt_icon,
                'status' => $data['status'] ?? $service->status,
                'show_in_home' => $data['show_in_home'] ?? $service->show_in_home,
                'show_in_header' => $data['show_in_header'] ?? $service->show_in_header,
                'show_in_footer' => $data['show_in_footer'] ?? $service->show_in_footer,
                'index' => $data['index'] ?? $service->index,
                'order' => $data['order'] ?? $service->order,
            ];

            // تحديث صورة الأيقونة فقط إذا تم رفع أيقونة جديدة
            if ($request->hasFile('icon')) {
                if ($service->icon) {
                    Media::removeFile('services', $service->icon);
                }
                $mainData['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'services');
            }

            // تحديث صورة الخدمة فقط إذا تم رفع صورة جديدة
            if ($request->hasFile('image')) {
                if ($service->image) {
                    Media::removeFile('services', $service->image);
                }
                $mainData['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'services');
            }

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('service');

            // Update the Service with translations
            JsonTranslationService::updateWithTranslations(
                $service,
                $mainData,
                $request,
                $translationFields
            );

            // Handle additional service images upload if any
            if ($request->hasFile('service_images')) {
                $this->handleServiceImagesUpload($request->file('service_images'), $service->id);
            }

            DB::commit();
            Log::info('Service updated successfully', ['service_id' => $service->id]);
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update service: ' . $e->getMessage());
            throw $e;
        }
    }

    public function delete($selectedIds)
    {
        Log::info('Starting delete in DashboardService', [
            'selectedIds' => $selectedIds
        ]);

        $services = ModelsService::whereIn('id', $selectedIds)->get();

        Log::info('Found services to delete', [
            'count' => $services->count(),
            'services' => $services->pluck('id')->toArray()
        ]);

        DB::beginTransaction();
        try {
            foreach ($services as $service) {
                Log::info('Processing service', [
                    'service_id' => $service->id,
                    'has_image' => !empty($service->image),
                    'has_icon' => !empty($service->icon)
                ]);

                // Delete associated image if it exists
                if ($service->image) {
                    try {
                        Media::removeFile('services', $service->image);
                        Log::info('Deleted service image', [
                            'service_id' => $service->id,
                            'image' => $service->image
                        ]);
                    } catch (\Exception $e) {
                        Log::warning('Failed to delete service image', [
                            'service_id' => $service->id,
                            'image' => $service->image,
                            'error' => $e->getMessage()
                        ]);
                    }
                }

                // Delete associated Icon if it exists
                if ($service->icon) {
                    try {
                        Media::removeFile('services', $service->icon);
                        Log::info('Deleted service icon', [
                            'service_id' => $service->id,
                            'icon' => $service->icon
                        ]);
                    } catch (\Exception $e) {
                        Log::warning('Failed to delete service icon', [
                            'service_id' => $service->id,
                            'icon' => $service->icon,
                            'error' => $e->getMessage()
                        ]);
                    }
                }

                // Delete associated service images
                $this->deleteServiceImages($service);

                // Delete the service model (this triggers the observer)
                try {
                    $service->delete();
                    Log::info('Deleted service', [
                        'service_id' => $service->id
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to delete service', [
                        'service_id' => $service->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    throw $e;
                }
            }

            DB::commit();
            Log::info('Delete operation completed successfully');
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Delete operation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Handle service images upload
     */
    private function handleServiceImagesUpload($images, int $serviceId): void
    {
        try {
            $maxOrder = ServiceImage::where('service_id', $serviceId)->max('order') ?? 0;
            foreach ($images as $image) {
                $filename = Media::uploadAndAttachImageStorage($image, 'services');
                ServiceImage::create([
                    'service_id' => $serviceId,
                    'image' => $filename,
                    'order' => ++$maxOrder,
                ]);
                Log::info('Service image uploaded successfully', [
                    'service_id' => $serviceId,
                    'filename' => $filename,
                    'order' => $maxOrder
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error uploading service images: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete all service images for a service
     */
    private function deleteServiceImages(ModelsService $service): void
    {
        try {
            $serviceImages = $service->serviceImages;
            foreach ($serviceImages as $image) {
                $filename = $image->getImageFilenameAttribute();
                if ($filename) {
                    Media::removeFile('services', $filename);
                    Log::info('Deleted service image file', [
                        'service_id' => $service->id,
                        'image_id' => $image->id,
                        'filename' => $filename
                    ]);
                }
                $image->delete();
            }
            Log::info('Deleted all service images', [
                'service_id' => $service->id,
                'count' => $serviceImages->count()
            ]);
        } catch (\Exception $e) {
            Log::warning('Failed to delete some service images', [
                'service_id' => $service->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
