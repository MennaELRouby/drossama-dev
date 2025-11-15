<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Services\JsonTranslationService;
use App\Models\Benefit;
use Illuminate\Support\Facades\DB;

class BenefitService
{
    public function store($request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // Handle file uploads
            if ($request->hasFile('image')) {
                $data['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'benefits');
            }
            if ($request->hasFile('icon')) {
                $data['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'benefits');
            }

            // Prepare main model data
            $mainData = $data;

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('benefit');

            // Create model with JSON translations
            $model = JsonTranslationService::createWithTranslations(Benefit::class, $mainData, $request, $translationFields);

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
                    Media::removeFile('benefits', $model->image);
                }
                $data['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'benefits');
            }

            if ($request->hasFile('icon')) {
                if ($model->icon) {
                    Media::removeFile('benefits', $model->icon);
                }
                $data['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'benefits');
            }

            // Prepare main model data
            $mainData = $data;

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('benefit');

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
        DB::beginTransaction();
        try {
            $benefits = Benefit::whereIn('id', $selectedIds)->get();
            foreach ($benefits as $benefit) {
                if ($benefit->image) {
                    Media::removeFile('benefits', $benefit->image);
                }
                if ($benefit->icon) {
                    Media::removeFile('benefits', $benefit->icon);
                }
            }
            $deleted = Benefit::whereIn('id', $selectedIds)->delete();
            DB::commit();
            return $deleted > 0;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
