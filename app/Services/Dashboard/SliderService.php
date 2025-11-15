<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Services\JsonTranslationService;
use App\Models\Slider;
use Illuminate\Support\Facades\DB;

class SliderService
{
    public function store($request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // Prepare main data (non-translatable fields)
            $mainData = [
                'image' => null,
                'mobile_image' => null,
                'alt_image' => $data['alt_image'] ?? null,
                'alt_mobile_image' => $data['alt_mobile_image'] ?? null,
                'icon' => null,
                'alt_icon' => $data['alt_icon'] ?? null,
                'status' => $data['status'] ?? 1,
                'order' => $data['order'] ?? 0,
                'type' => $data['type'] ?? 'top_header',
                'language' => $data['language'] ?? 'all',
            ];

            // Handle file uploads
            if ($request->hasFile('image')) {
                $mainData['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'sliders');
            }
            if ($request->hasFile('mobile_image')) {
                $mainData['mobile_image'] = Media::uploadAndAttachImageStorage($request->file('mobile_image'), 'sliders');
            }
            if ($request->hasFile('icon')) {
                $mainData['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'sliders');
            }

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('slider');

            // Create model with JSON translations
            $model = JsonTranslationService::createWithTranslations(Slider::class, $mainData, $request, $translationFields);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $slider)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // Prepare main data (non-translatable fields)
            $mainData = [
                'alt_image' => $data['alt_image'] ?? $slider->alt_image,
                'alt_mobile_image' => $data['alt_mobile_image'] ?? $slider->alt_mobile_image,
                'alt_icon' => $data['alt_icon'] ?? $slider->alt_icon,
                'status' => $data['status'] ?? $slider->status,
                'order' => $data['order'] ?? $slider->order,
                'type' => $data['type'] ?? $slider->type,
                'language' => $data['language'] ?? $slider->language,
            ];

            // Handle file uploads
            if ($request->hasFile('image')) {
                if ($slider->image) {
                    Media::removeFile('sliders', $slider->image);
                }
                $mainData['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'sliders');
            }
            if ($request->hasFile('mobile_image')) {
                if ($slider->mobile_image) {
                    Media::removeFile('sliders', $slider->mobile_image);
                }
                $mainData['mobile_image'] = Media::uploadAndAttachImageStorage($request->file('mobile_image'), 'sliders');
            }
            if ($request->hasFile('icon')) {
                if ($slider->icon) {
                    Media::removeFile('sliders', $slider->icon);
                }
                $mainData['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'sliders');
            }

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('slider');

            // Update model with JSON translations
            JsonTranslationService::updateWithTranslations($slider, $mainData, $request, $translationFields);

            DB::commit();
            return $slider;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($selectedIds, $data)
    {
        DB::beginTransaction();
        try {
            if (is_array($selectedIds)) {
                foreach ($selectedIds as $id) {
                    $slider = Slider::find($id);
                    if ($slider) {
                        // Delete images from storage
                        if ($slider->image) {
                            Media::removeFile('sliders', $slider->image);
                        }
                        if ($slider->mobile_image) {
                            Media::removeFile('sliders', $slider->mobile_image);
                        }
                        if ($slider->icon) {
                            Media::removeFile('sliders', $slider->icon);
                        }

                        // Delete the slider
                        $slider->delete();
                    }
                }
            } else {
                $slider = Slider::find($selectedIds);
                if ($slider) {
                    // Delete images from storage
                    if ($slider->image) {
                        Media::removeFile('sliders', $slider->image);
                    }
                    if ($slider->mobile_image) {
                        Media::removeFile('sliders', $slider->mobile_image);
                    }
                    if ($slider->icon) {
                        Media::removeFile('sliders', $slider->icon);
                    }

                    // Delete the slider
                    $slider->delete();
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
