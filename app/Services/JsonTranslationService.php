<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class JsonTranslationService
{
    /**
     * Get translation data from request
     */
    public static function getTranslationData($request, $fields, $languages = ['en', 'ar', 'fr'])
    {
        $translations = [];

        foreach ($languages as $lang) {
            $translationData = [];
            foreach ($fields as $field) {
                $key = "{$field}_{$lang}";
                if ($request->has($key)) {
                    $translationData[$field] = $request->input($key);
                }
            }

            if (!empty($translationData)) {
                $translations[$lang] = $translationData;
            }
        }

        return $translations;
    }

    /**
     * Prepare JSON data for database storage
     */
    public static function prepareJsonData($request, $fields, $languages = null)
    {
        // Use form languages from config if not provided
        if ($languages === null) {
            $languages = config('app.form_languages', ['en', 'ar', 'fr', 'de']);
        }

        $jsonData = [];

        foreach ($fields as $field) {
            $fieldTranslations = [];
            foreach ($languages as $lang) {
                $key = "{$field}_{$lang}";
                $value = $request->input($key, '');

                // Auto-generate slug if field is 'slug' and value is empty
                if ($field === 'slug' && empty($value)) {
                    $nameKey = "name_{$lang}";
                    $nameValue = $request->input($nameKey, '');
                    if (!empty($nameValue)) {
                        if ($lang === 'ar') {
                            // For Arabic, keep it as Arabic characters and just replace spaces with dashes
                            $value = preg_replace('/\s+/u', '-', trim($nameValue));
                            $value = preg_replace('/[^\p{L}\p{N}_-]+/u', '', $value);
                        } else {
                            $value = \Illuminate\Support\Str::slug($nameValue);
                        }
                    }
                }

                if (!empty($value)) {
                    $fieldTranslations[$lang] = $value;
                }
            }

            if (!empty($fieldTranslations)) {
                $jsonData[$field] = $fieldTranslations;
            }
        }

        return $jsonData;
    }

    /**
     * Create model with JSON translations
     */
    public static function createWithTranslations($modelClass, $data, $request, $translationFields)
    {
        DB::beginTransaction();

        try {
            // Prepare JSON translations
            $jsonTranslations = self::prepareJsonData($request, $translationFields);

            // Merge with main data
            $allData = array_merge($data, $jsonTranslations);

            // Create the model
            $model = $modelClass::create($allData);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update model with JSON translations
     */
    public static function updateWithTranslations($model, $data, $request, $translationFields)
    {
        DB::beginTransaction();

        try {
            // Prepare JSON translations
            $jsonTranslations = self::prepareJsonData($request, $translationFields);

            // Merge with main data
            $allData = array_merge($data, $jsonTranslations);

            // Update the model
            $model->update($allData);

            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get supported languages
     */
    public static function getSupportedLanguages()
    {
        return config('app.form_languages', ['en', 'ar', 'fr']);
    }

    /**
     * Get translation fields for a model type
     */
    public static function getTranslationFields($modelType)
    {
        $fields = [
            'blog' => ['name', 'short_desc', 'long_desc', 'meta_title', 'meta_desc', 'slug'],
            'product' => ['name', 'short_desc', 'long_desc', 'meta_title', 'meta_desc', 'slug', 'clients', 'location'],
            'service' => ['name', 'short_desc', 'long_desc', 'meta_title', 'meta_desc', 'slug'],
            'project' => ['name', 'short_desc', 'long_desc', 'meta_title', 'meta_desc', 'slug'],
            'category' => ['name', 'short_desc', 'long_desc', 'meta_title', 'meta_desc', 'slug'],
            'faq' => ['question', 'answer'],
            'page' => ['title', 'content', 'slug'],
            'menu' => ['name'],
            'benefit' => ['name', 'description'],
            'testimonial' => ['name', 'content', 'position'],
            'certificate' => ['name'],
            'slider' => ['title', 'title2', 'text'],
            'section' => ['name', 'title', 'short_desc', 'long_desc'],
            'about_struct' => ['name', 'long_desc'],
            'plan' => ['name', 'description'],
            'job_position' => ['title', 'description', 'requirements'],
            'phone' => ['name', 'description'],
        ];

        return $fields[$modelType] ?? [];
    }

    /**
     * Generate slugs for all languages
     */
    public static function generateSlugs($translations, $field = 'name')
    {
        $slugs = [];

        foreach ($translations as $lang => $data) {
            if (isset($data[$field])) {
                if ($lang === 'ar') {
                    $slugs[$lang] = preg_replace('/\s+/u', '-', trim($data[$field]));
                    $slugs[$lang] = preg_replace('/[^\p{L}\p{N}_-]+/u', '', $slugs[$lang]);
                } else {
                    $slugs[$lang] = \Illuminate\Support\Str::slug($data[$field]);
                }
            }
        }

        return $slugs;
    }
}
