<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Services\JsonTranslationService;
use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class FaqService
{
    /**
     * Create a new class instance.
     */
    public function store($request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // Handle file uploads
            if ($request->hasFile('image')) {
                $data['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'faqs');
            }
            if ($request->hasFile('icon')) {
                $data['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'faqs');
            }

            // Prepare main model data
            $mainData = $data;

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('faq');

            // Create model with JSON translations
            $model = JsonTranslationService::createWithTranslations(Faq::class, $mainData, $request, $translationFields);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $model)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            // Handle file uploads
            if ($request->hasFile('image')) {
                if ($model->image) {
                    Media::removeFile('faqs', $model->image);
                }
                $data['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'faqs');
            }

            if ($request->hasFile('icon')) {
                if ($model->icon) {
                    Media::removeFile('faqs', $model->icon);
                }
                $data['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'faqs');
            }

            // Prepare main model data
            $mainData = $data;

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('faq');

            // Update model with JSON translations
            $model = JsonTranslationService::updateWithTranslations($model, $mainData, $request, $translationFields);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($selectedIds)
    {
        try {
            return Faq::whereIn('id', $selectedIds)->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
