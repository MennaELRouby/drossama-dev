<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Services\JsonTranslationService;
use App\Models\Dashboard\AboutStruct;
use Illuminate\Support\Facades\DB;

class AboutStructService
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
                'icon' => null,
                'alt_icon' => $data['alt_icon'] ?? null,
                'order' => $data['order'] ?? 0,
                'status' => $data['status'] ?? 1,
            ];

            // Handle icon upload if present
            if ($request->hasFile('icon')) {
                $mainData['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'about_structs');
            }

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('about_struct');

            // Create model with JSON translations
            $about_struct = JsonTranslationService::createWithTranslations(AboutStruct::class, $mainData, $request, $translationFields);

            DB::commit();

            return $about_struct;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $about_struct, $data)
    {
        DB::beginTransaction();

        try {
            // Prepare main data (non-translatable fields)
            $mainData = [
                'alt_icon' => $data['alt_icon'] ?? $about_struct->alt_icon,
                'order' => $data['order'] ?? $about_struct->order,
                'status' => $data['status'] ?? $about_struct->status,
            ];

            // Handle icon upload replacement
            if ($request->hasFile('icon')) {
                if ($about_struct->icon) {
                    Media::removeFile('about_structs', $about_struct->icon);
                }
                $mainData['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'about_structs');
            }

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('about_struct');

            // Update model with JSON translations
            JsonTranslationService::updateWithTranslations($about_struct, $mainData, $request, $translationFields);

            DB::commit();

            return $about_struct;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($selectedIds)
    {
        $about_struct = AboutStruct::whereIn('id', $selectedIds)->get();

        DB::beginTransaction();

        try {
            foreach ($about_struct as $about_struct) {
                // Delete associated image if it exists
                if ($about_struct->icon) {
                    Media::removeFile('about_structs', $about_struct->icon);
                }
            }
            $deleted = AboutStruct::whereIn('id', $selectedIds)->delete();

            DB::commit();

            return $deleted > 0;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
