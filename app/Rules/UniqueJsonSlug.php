<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class UniqueJsonSlug implements ValidationRule
{
    protected $modelClass;
    protected $column;
    protected $locale;
    protected $ignoreId = null;

    public function __construct(string $modelClass, string $column, string $locale, $ignoreId = null)
    {
        $this->modelClass = $modelClass;
        $this->column = $column;
        $this->locale = $locale;
        $this->ignoreId = $ignoreId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, string): void  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Generate slug that supports Arabic: converts spaces to dashes and removes non-letter/number/dash characters
        $slug = preg_replace('/\s+/u', '-', trim($value));
        $slug = preg_replace('/[^\p{L}\p{N}_-]+/u', '', $slug);

        // Use the locale passed to constructor
        $locale = $this->locale;

        // Use manual check instead of JSON_EXTRACT to avoid database issues
        $allItems = $this->modelClass::all();
        foreach ($allItems as $item) {
            if ($this->ignoreId && $item->id == $this->ignoreId) {
                continue; // Skip the item being updated
            }
            $itemSlug = $item->getTranslation($this->column, $locale);
            if ($itemSlug === $slug) {
                $fail("The slug '{$slug}' already exists for {$locale}. Please choose a different title.");
                return;
            }
        }

        // If we reach here, the slug is unique
        return;
    }
}