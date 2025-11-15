<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Services\JsonTranslationService;
use App\Models\JobPosition;
use Illuminate\Support\Facades\DB;

class JobPositionService
{
    public function store($request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // Handle file uploads
            if ($request->hasFile('image')) {
                $data['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'job_positions');
            }
            if ($request->hasFile('icon')) {
                $data['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'job_positions');
            }

            // Prepare main model data
            $mainData = $data;

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('job_position');

            // Create model with JSON translations
            $model = JsonTranslationService::createWithTranslations(JobPosition::class, $mainData, $request, $translationFields);

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
                    Media::removeFile('job_positions', $model->image);
                }
                $data['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'job_positions');
            }

            if ($request->hasFile('icon')) {
                if ($model->icon) {
                    Media::removeFile('job_positions', $model->icon);
                }
                $data['icon'] = Media::uploadAndAttachImageStorage($request->file('icon'), 'job_positions');
            }

            // Prepare main model data
            $mainData = $data;

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('job_position');

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
            $jobPositions = JobPosition::whereIn('id', $selectedIds)->get();
            foreach ($jobPositions as $jobPosition) {
                if ($jobPosition->image) {
                    Media::removeFile('job_positions', $jobPosition->image);
                }
                if ($jobPosition->icon) {
                    Media::removeFile('job_positions', $jobPosition->icon);
                }
            }
            $deleted = JobPosition::whereIn('id', $selectedIds)->delete();
            DB::commit();
            return $deleted > 0;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
