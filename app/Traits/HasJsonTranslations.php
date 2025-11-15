<?php

namespace App\Traits;

trait HasJsonTranslations
{
    /**
     * Get translation for specific locale
     */
    public function getTranslation($field, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();

        // Get all translations using the getAllTranslations method
        $translations = $this->getAllTranslations($field);

        // If it's an array, get the locale value
        if (is_array($translations) && isset($translations[$locale])) {
            return $translations[$locale];
        }

        return '';
    }

    /**
     * Get all translations for a field
     */
    public function getAllTranslations($field)
    {
        // Get raw data from database
        $translations = $this->getRawOriginal($field);

        if (is_string($translations)) {
            $decoded = json_decode($translations, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $translations = $decoded;
            } else {
                // If JSON decode failed, try to decode the string again
                $doubleDecoded = json_decode($decoded, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($doubleDecoded)) {
                    $translations = $doubleDecoded;
                }
            }
        }

        // Ensure we always return an array
        return is_array($translations) ? $translations : [];
    }

    /**
     * Set translation for specific locale
     */
    public function setTranslation($field, $locale, $value)
    {
        $translations = $this->getAllTranslations($field);
        $translations[$locale] = $value;
        $this->setAttribute($field, $translations);
    }

    /**
     * Set multiple translations
     */
    public function setTranslations($field, $translations)
    {
        $this->setAttribute($field, $translations);
    }

    /**
     * Get attribute based on current locale
     */
    public function getTranslatableAttribute($attribute)
    {
        return $this->getTranslation($attribute);
    }

    /**
     * Get current locale
     */
    protected function getCurrentLocale()
    {
        return app()->getLocale();
    }

    /**
     * Get supported languages
     */
    public function getSupportedLanguages()
    {
        return config('app.form_languages', ['en', 'ar']);
    }

    /**
     * Check if translation exists for locale
     */
    public function hasTranslation($field, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $translations = $this->getAllTranslations($field);

        // Ensure translations is an array
        if (!is_array($translations)) {
            return false;
        }

        return isset($translations[$locale]) && !empty($translations[$locale]);
    }

    /**
     * Get available locales for a field
     */
    public function getAvailableLocales($field)
    {
        $translations = $this->getAllTranslations($field);

        // Ensure translations is an array
        if (!is_array($translations)) {
            return [];
        }

        return array_keys(array_filter($translations));
    }

    /**
     * Get fallback translation (try en, then ar, then first available)
     */
    public function getFallbackTranslation($field, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $translations = $this->getAllTranslations($field);

        // Ensure translations is an array
        if (!is_array($translations)) {
            return '';
        }

        // Try requested locale
        if (isset($translations[$locale]) && !empty($translations[$locale])) {
            return $translations[$locale];
        }

        // Try English
        if (isset($translations['en']) && !empty($translations['en'])) {
            return $translations['en'];
        }

        // Try Arabic
        if (isset($translations['ar']) && !empty($translations['ar'])) {
            return $translations['ar'];
        }

        // Return first available
        $available = array_filter($translations);
        return !empty($available) ? reset($available) : '';
    }
}
