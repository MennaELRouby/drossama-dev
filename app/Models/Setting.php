<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'lang'];

    public const IMAGE_KEYS = ['site_logo', 'site_footer_logo', 'site_favicon', 'site_banner'];

    // Accessor for the image path
    public function getValueAttribute($value)
    {
        if (in_array($this->key, self::IMAGE_KEYS)) {
            // إذا كانت القيمة رابط كامل بالفعل، أرجعها كما هي
            if ($value && (str_starts_with($value, 'http://') || str_starts_with($value, 'https://'))) {
                return $value;
            }
            // تحقق من وجود الملف في مجلد configurations
            if ($value && \Illuminate\Support\Facades\Storage::disk('public')->exists("configurations/{$value}")) {
                return asset('storage/configurations/' . $value);
            }
            return asset('assets/dashboard/images/noimage.png');
        }

        return $value;
    }
}
