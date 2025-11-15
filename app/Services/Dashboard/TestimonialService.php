<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Services\JsonTranslationService;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;

class TestimonialService
{
    public function store($request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // Prepare main data (non-translatable fields)
            $mainData = [
                'image' => null,
                'alt_image' => $data['alt_image'] ?? null,
                'icon' => null,
                'alt_icon' => $data['alt_icon'] ?? null,
                'video_link' => $data['video_link'] ?? null,
                'status' => $data['status'] ?? 1,
                'order' => $data['order'] ?? 0,
            ];

            // Handle file uploads
            if ($request->hasFile('image')) {
                $mainData['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'testimonials');
            }
            if ($request->hasFile('icon')) {
                $mainData['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'testimonials');
            }

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('testimonial');

            // Create model with JSON translations
            $model = JsonTranslationService::createWithTranslations(Testimonial::class, $mainData, $request, $translationFields);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $testimonial)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // Prepare main data (non-translatable fields)
            $mainData = [
                'alt_image' => $data['alt_image'] ?? $testimonial->alt_image,
                'alt_icon' => $data['alt_icon'] ?? $testimonial->alt_icon,
                'video_link' => $data['video_link'] ?? $testimonial->video_link,
                'status' => $data['status'] ?? $testimonial->status,
                'order' => $data['order'] ?? $testimonial->order,
            ];

            // Handle file uploads
            if ($request->hasFile('image')) {
                if ($testimonial->image) {
                    Media::removeFile('testimonials', $testimonial->image);
                }
                $mainData['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'testimonials');
            }
            if ($request->hasFile('icon')) {
                if ($testimonial->icon) {
                    Media::removeFile('testimonials', $testimonial->icon);
                }
                $mainData['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'testimonials');
            }

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('testimonial');

            // Update model with JSON translations
            JsonTranslationService::updateWithTranslations($testimonial, $mainData, $request, $translationFields);

            DB::commit();
            return $testimonial;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}