<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;


class UniqueSlug implements ValidationRule
{
    protected $modelClass;
    protected $column;
    protected $ignoreId = null;

    public function __construct(string $modelClass, string $column = 'slug', $ignoreId = null)
    {
        $this->modelClass = $modelClass;
        $this->column = $column;
        $this->ignoreId = $ignoreId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, string): void  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // توليد slug يدعم العربية: يحول المسافات إلى شرطة ويزيل الرموز غير الأحرف والأرقام والشرطة
        $slug = preg_replace('/\s+/u', '-', trim($value));
        $slug = preg_replace('/[^\p{L}\p{N}_-]+/u', '', $slug);
        $query = $this->modelClass::where($this->column, $slug);
        if ($this->ignoreId) {
            $query->where('id', '!=', $this->ignoreId);
        }
        if ($query->exists()) {
            $fail("The slug '{$slug}' already exists. Please choose a different title.");
        }
    }
}

