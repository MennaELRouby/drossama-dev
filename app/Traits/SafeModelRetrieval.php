<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * Safe Model Retrieval Trait
 * 
 * This trait provides methods to safely retrieve models without getting null values.
 * It prevents "Attempt to read property on null" errors.
 * 
 * استخدام:
 * use SafeModelRetrieval;
 * $data['about'] = $this->safeFirst(AboutUs::class);
 */
trait SafeModelRetrieval
{
    /**
     * Safely get first record or return new instance
     * بدلاً من استخدام Model::first() التي ترجع null
     * استخدم هذه الدالة لترجع object دائماً
     *
     * @param string $modelClass
     * @param array $attributes
     * @return Model
     */
    protected function safeFirst(string $modelClass, array $attributes = []): Model
    {
        return $modelClass::firstOrNew($attributes);
    }

    /**
     * Safely get first record or fail with 404
     * إذا كان السجل مطلوب وجوده
     *
     * @param string $modelClass
     * @return Model
     */
    protected function safeFirstOrFail(string $modelClass): Model
    {
        return $modelClass::firstOrFail();
    }

    /**
     * Safely find by ID or return new instance
     * للبحث بال ID بأمان
     *
     * @param string $modelClass
     * @param int $id
     * @return Model
     */
    protected function safeFind(string $modelClass, int $id): Model
    {
        return $modelClass::findOrNew($id);
    }

    /**
     * Safely find by ID or fail with 404
     *
     * @param string $modelClass
     * @param int $id
     * @return Model
     */
    protected function safeFindOrFail(string $modelClass, int $id): Model
    {
        return $modelClass::findOrFail($id);
    }

    /**
     * Get data with default fallback
     * للحصول على البيانات مع قيمة افتراضية
     *
     * @param mixed $data
     * @param mixed $default
     * @return mixed
     */
    protected function withDefault($data, $default = null)
    {
        return $data ?? $default;
    }
}
