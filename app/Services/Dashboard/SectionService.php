<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Services\JsonTranslationService;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class SectionService
{
    public function store($request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // Prepare main data (non-translatable fields)
            $mainData = [
                'key' => $data['key'] ?? null,
                'image' => null,
                'alt_image' => $data['alt_image'] ?? null,
                'icon' => null,
                'alt_icon' => $data['alt_icon'] ?? null,
                'status' => $data['status'] ?? 1,
            ];

            // Handle file uploads
            if ($request->hasFile('image')) {
                $mainData['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'sections');
            }
            if ($request->hasFile('icon')) {
                $mainData['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'sections');
            }

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('section');

            // Create model with JSON translations
            $model = JsonTranslationService::createWithTranslations(Section::class, $mainData, $request, $translationFields);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $section)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // Prepare main data (non-translatable fields)
            $mainData = [
                'key' => $data['key'] ?? $section->key,
                'alt_image' => $data['alt_image'] ?? $section->alt_image,
                'alt_icon' => $data['alt_icon'] ?? $section->alt_icon,
                'status' => $data['status'] ?? $section->status,
            ];

            // Handle file uploads
            if ($request->hasFile('image')) {
                if ($section->image) {
                    Media::removeFile('sections', $section->image);
                }
                $mainData['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'sections');
            }
            if ($request->hasFile('icon')) {
                if ($section->icon) {
                    Media::removeFile('sections', $section->icon);
                }
                $mainData['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'sections');
            }

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('section');

            // Update model with JSON translations
            JsonTranslationService::updateWithTranslations($section, $mainData, $request, $translationFields);

            DB::commit();
            return $section;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($selectedIds, $data)
    {
        DB::beginTransaction();
        try {
            if (is_array($selectedIds) && count($selectedIds) > 0) {
                // Bulk delete
                $sections = Section::whereIn('id', $selectedIds)->get();

                foreach ($sections as $section) {
                    // Remove associated files
                    if ($section->image) {
                        Media::removeFile('sections', $section->image);
                    }
                    if ($section->icon) {
                        Media::removeFile('sections', $section->icon);
                    }
                }

                $deleted = Section::whereIn('id', $selectedIds)->delete();
            } else {
                // Single delete
                $section = Section::find($selectedIds);
                if ($section) {
                    // Remove associated files
                    if ($section->image) {
                        Media::removeFile('sections', $section->image);
                    }
                    if ($section->icon) {
                        Media::removeFile('sections', $section->icon);
                    }

                    $deleted = $section->delete();
                } else {
                    $deleted = false;
                }
            }

            DB::commit();
            return $deleted;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
