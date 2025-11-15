<?php

namespace App\Traits;

trait HasMultilingualValidation
{
    /**
     * Generate multilingual validation rules
     */
    protected function getMultilingualRules(array $fields = [], ?array $languages = null): array
    {
        $rules = [];

        // Use provided languages or get from config
        $languages = $languages ?? config('app.form_languages', ['en', 'ar', 'fr']);

        // Default fields if none provided
        $fields = empty($fields) ? ['name', 'title', 'short_desc', 'long_desc', 'meta_title', 'meta_desc', 'slug', 'position', 'content', 'title2', 'text', 'address'] : $fields;

        foreach ($fields as $field) {
            foreach ($languages as $lang) {
                $rules["{$field}_{$lang}"] = ['nullable', 'string'];

                // Add max length for specific fields
                if (in_array($field, ['name', 'title', 'meta_title'])) {
                    $rules["{$field}_{$lang}"][] = 'max:255';
                }
            }
        }

        return $rules;
    }
}