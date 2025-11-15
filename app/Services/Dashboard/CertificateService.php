<?php

namespace App\Services\Dashboard;

use App\Helper\Media;
use App\Services\JsonTranslationService;
use App\Models\Certificate;
use Illuminate\Support\Facades\DB;

class CertificateService
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
                'status' => $data['status'] ?? 1,
                'order' => $data['order'] ?? 0,
            ];

            // Handle file upload
            if ($request->hasFile('image')) {
                $mainData['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'certificates');
            }

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('certificate');

            // Create model with JSON translations
            $model = JsonTranslationService::createWithTranslations(Certificate::class, $mainData, $request, $translationFields);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($request, $certificate)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // Prepare main data (non-translatable fields)
            $mainData = [
                'alt_image' => $data['alt_image'] ?? $certificate->alt_image,
                'status' => $data['status'] ?? $certificate->status,
                'order' => $data['order'] ?? $certificate->order,
            ];

            // Handle file upload
            if ($request->hasFile('image')) {
                if ($certificate->image) {
                    Media::removeFile('certificates', $certificate->image);
                }
                $mainData['image'] = Media::uploadAndAttachImageStorage($request->file('image'), 'certificates');
            }

            // Get translation fields
            $translationFields = JsonTranslationService::getTranslationFields('certificate');

            // Update model with JSON translations
            JsonTranslationService::updateWithTranslations($certificate, $mainData, $request, $translationFields);

            DB::commit();
            return $certificate;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($selectedIds, $data)
    {
        DB::beginTransaction();
        try {
            $certificates = Certificate::whereIn('id', $selectedIds)->get();

            foreach ($certificates as $certificate) {
                if ($certificate->image) {
                    Media::removeFile('certificates', $certificate->image);
                }
                $certificate->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
