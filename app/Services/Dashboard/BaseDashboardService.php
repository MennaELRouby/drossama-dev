<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class BaseDashboardService
{
    protected abstract function getModel(): string;
    protected abstract function getImagePath(): string;

    public function delete($selectedIds)
    {
        if (!is_array($selectedIds)) {
            $selectedIds = [$selectedIds];
        }

        Log::info('Starting delete in ' . class_basename($this), [
            'selectedIds' => $selectedIds
        ]);

        $modelClass = $this->getModel();
        $items = $modelClass::whereIn('id', $selectedIds)->get();

        if ($items->isEmpty()) {
            Log::warning('No items found to delete', [
                'selectedIds' => $selectedIds,
                'model' => $modelClass
            ]);
            throw new \Exception('No items found to delete');
        }

        Log::info('Found items to delete', [
            'count' => $items->count(),
            'items' => $items->pluck('id')->toArray()
        ]);

        DB::beginTransaction();
        try {
            foreach ($items as $item) {
                Log::info('Processing item', [
                    'item_id' => $item->id,
                    'has_image' => !empty($item->image),
                    'has_icon' => !empty($item->icon)
                ]);

                // Delete associated images
                if (method_exists($item, 'images') && $item->images) {
                    foreach ($item->images as $image) {
                        try {
                            Media::removeFile($this->getImagePath(), $image->image);
                            $image->delete();
                            Log::info('Deleted item image', [
                                'item_id' => $item->id,
                                'image_id' => $image->id,
                                'image' => $image->image
                            ]);
                        } catch (\Exception $e) {
                            Log::warning('Failed to delete item image', [
                                'item_id' => $item->id,
                                'image_id' => $image->id,
                                'image' => $image->image,
                                'error' => $e->getMessage()
                            ]);
                        }
                    }
                }

                // Delete main image if it exists
                if ($item->image) {
                    try {
                        Media::removeFile($this->getImagePath(), $item->image);
                        Log::info('Deleted item main image', [
                            'item_id' => $item->id,
                            'image' => $item->image
                        ]);
                    } catch (\Exception $e) {
                        Log::warning('Failed to delete item main image', [
                            'item_id' => $item->id,
                            'image' => $item->image,
                            'error' => $e->getMessage()
                        ]);
                    }
                }

                // Delete icon if it exists
                if ($item->icon) {
                    try {
                        Media::removeFile($this->getImagePath(), $item->icon);
                        Log::info('Deleted item icon', [
                            'item_id' => $item->id,
                            'icon' => $item->icon
                        ]);
                    } catch (\Exception $e) {
                        Log::warning('Failed to delete item icon', [
                            'item_id' => $item->id,
                            'icon' => $item->icon,
                            'error' => $e->getMessage()
                        ]);
                    }
                }

                // Delete the item
                try {
                    $item->delete();
                    Log::info('Deleted item', [
                        'item_id' => $item->id
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to delete item', [
                        'item_id' => $item->id,
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
}