<?php

namespace App\Services\Dashboard;

use App\Models\Dashboard\Menu;
use App\Services\JsonTranslationService;
use App\Helper\Media;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MenuService
{
    public function store($request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            // Handle file uploads
            if ($request->hasFile('image')) {
                $data['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'menus');
            }
            if ($request->hasFile('icon')) {
                $data['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'menus');
            }

            // Prepare main model data
            $mainData = [
                'parent_id' => $data['parent_id'] ?? null,
                'segment' => $data['segment'] ?? null,
                'type' => $data['type'] ?? null,
                'image' => $data['image'] ?? null,
                'alt_image' => $data['alt_image'] ?? null,
                'icon' => $data['icon'] ?? null,
                'alt_icon' => $data['alt_icon'] ?? null,
                'status' => $data['status'] ?? 0,
                'order' => $data['order'] ?? 0,
            ];

            // Create model with translations using JsonTranslationService
            $translationFields = JsonTranslationService::getTranslationFields('menu');
            $menu = JsonTranslationService::createWithTranslations(Menu::class, $mainData, $request, $translationFields);

            DB::commit();
            return $menu;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $menu)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            // Handle file uploads
            if ($request->hasFile('image')) {
                if ($menu->image) {
                    Media::removeFile('menus', $menu->image);
                }
                $data['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'menus');
            }

            if ($request->hasFile('icon')) {
                if ($menu->icon) {
                    Media::removeFile('menus', $menu->icon);
                }
                $data['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'menus');
            }

            // Prepare main model data
            $mainData = [
                'parent_id' => $data['parent_id'] ?? $menu->parent_id,
                'segment' => $data['segment'] ?? $menu->segment,
                'type' => $data['type'] ?? $menu->type,
                'image' => $data['image'] ?? $menu->image,
                'alt_image' => $data['alt_image'] ?? $menu->alt_image,
                'icon' => $data['icon'] ?? $menu->icon,
                'alt_icon' => $data['alt_icon'] ?? $menu->alt_icon,
                'status' => $data['status'] ?? $menu->status,
                'order' => $data['order'] ?? $menu->order,
            ];

            // Update model with translations using JsonTranslationService
            $translationFields = JsonTranslationService::getTranslationFields('menu');
            $menu = JsonTranslationService::updateWithTranslations($menu, $mainData, $request, $translationFields);

            DB::commit();
            return $menu;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($selectedIds)
    {
        DB::beginTransaction();
        try {
            // Ensure selectedIds is an array
            if (!is_array($selectedIds)) {
                $selectedIds = [$selectedIds];
            }

            // Check if any of the selected IDs exist
            $existingIds = Menu::whereIn('id', $selectedIds)->pluck('id')->toArray();

            if (empty($existingIds)) {
                DB::rollBack();
                return ['success' => false, 'message' => __('dashboard.no_items_found_to_delete')];
            }

            // Get non-existing IDs for information
            $nonExistingIds = array_diff($selectedIds, $existingIds);

            // Delete only existing records
            $result = Menu::whereIn('id', $existingIds)->delete();

            $this->clearMenuCache();
            DB::commit();

            $message = __('dashboard.your_items_deleted_successfully');
            if (!empty($nonExistingIds)) {
                $message .= ' ' . __('dashboard.some_items_were_not_found');
            }

            return ['success' => true, 'message' => $message, 'deleted_count' => $result];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Clear all menu-related cache
     */
    private function clearMenuCache()
    {
        Cache::forget('website_menus');
        Cache::forget('hierarchical_menus');
        Cache::forget('footer_menus');
    }
}
