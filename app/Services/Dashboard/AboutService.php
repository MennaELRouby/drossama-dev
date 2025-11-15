<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Services\JsonTranslationService;
use Illuminate\Support\Facades\DB;

class AboutService
{

    public function update($request, $data, $about)
    {
        DB::beginTransaction();

        try {
            // Prepare main data (non-translatable fields)
            $mainData = [
                'alt_image' => $data['alt_image'] ?? $about->alt_image,
                'alt_banner' => $data['alt_banner'] ?? $about->alt_banner,
                'video_link' => $data['video_link'] ?? $about->video_link,
            ];

            // Handle file uploads
            if ($request->hasFile('image')) {
                if ($about->image) {
                    Media::removeFile('about', $about->image);
                }
                $mainData['image'] = Media::uploadAndAttachImage($request->file('image'), 'about');
            }

            if ($request->hasFile('banner')) {
                if ($about->banner) {
                    Media::removeFile('about', $about->banner);
                }
                $mainData['banner'] = Media::uploadAndAttachImage($request->file('banner'), 'about');
            }

            // Get translation fields
            $translationFields = ['title', 'title2', 'short_desc', 'text'];

            // Update model with JSON translations
            JsonTranslationService::updateWithTranslations($about, $mainData, $request, $translationFields);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
