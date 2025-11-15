<?php

namespace App\Traits;

use App\Services\JsonTranslationService;

trait UsesJsonTranslations
{
    /**
     * Create model with JSON translations
     * 
     * @param string $modelClass - The model class to create
     * @param array $mainData - Non-translatable fields
     * @param \Illuminate\Http\Request $request - The request containing form data
     * @param string $modelType - The model type for getting translation fields
     * @return mixed - The created model instance
     */
    protected function createWithTranslations(string $modelClass, array $mainData, $request, string $modelType)
    {
        $translationFields = JsonTranslationService::getTranslationFields($modelType);
        return JsonTranslationService::createWithTranslations($modelClass, $mainData, $request, $translationFields);
    }

    /**
     * Update model with JSON translations
     * 
     * @param mixed $model - The model instance to update
     * @param array $mainData - Non-translatable fields
     * @param \Illuminate\Http\Request $request - The request containing form data
     * @param string $modelType - The model type for getting translation fields
     * @return mixed - The updated model instance
     */
    protected function updateWithTranslations($model, array $mainData, $request, string $modelType)
    {
        $translationFields = JsonTranslationService::getTranslationFields($modelType);
        return JsonTranslationService::updateWithTranslations($model, $mainData, $request, $translationFields);
    }

    /**
     * Get translation fields for a model type
     * 
     * @param string $modelType
     * @return array
     */
    protected function getTranslationFields(string $modelType): array
    {
        return JsonTranslationService::getTranslationFields($modelType);
    }

    /**
     * Prepare JSON data for manual processing (if needed)
     * 
     * @param \Illuminate\Http\Request $request
     * @param array $fields
     * @param array|null $languages
     * @return array
     */
    protected function prepareJsonData($request, array $fields, array $languages = null): array
    {
        return JsonTranslationService::prepareJsonData($request, $fields, $languages);
    }
}
