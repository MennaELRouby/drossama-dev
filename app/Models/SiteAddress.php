<?php

namespace App\Models;

use App\Traits\HasJsonTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteAddress extends Model
{
    /** @use HasFactory<\Database\Factories\SiteAddressFactory> */
    use HasFactory, HasJsonTranslations;

    protected $table = 'site_addresses';

    protected $fillable = [
        'title',
        'address',
        'email',
        'phone',
        'phone2',
        'code',
        'code2',
        'map_url',
        'map_link',
        'order',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
        'title' => 'array',
        'address' => 'array',
    ];

    public function getTitleAttribute()
    {
        $title = $this->getRawOriginal('title');

        if (is_string($title)) {
            $decoded = json_decode($title, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $title = $decoded;
            } else {
                // If JSON decode failed, try to decode the string again
                $doubleDecoded = json_decode($decoded, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($doubleDecoded)) {
                    $title = $doubleDecoded;
                }
            }
        }

        if (is_array($title) && !empty($title)) {
            $locale = app()->getLocale();
            return $title[$locale] ?? $title['en'] ?? $title['ar'] ?? '';
        }

        return '';
    }

    public function getAddressAttribute()
    {
        $address = $this->getRawOriginal('address');

        if (is_string($address)) {
            $decoded = json_decode($address, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $address = $decoded;
            } else {
                // If JSON decode failed, try to decode the string again
                $doubleDecoded = json_decode($decoded, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($doubleDecoded)) {
                    $address = $doubleDecoded;
                }
            }
        }

        if (is_array($address) && !empty($address)) {
            $locale = app()->getLocale();
            return $address[$locale] ?? $address['en'] ?? $address['ar'] ?? '';
        }

        return '';
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Get all translations for a field
     */
    public function getAllTranslations($field)
    {
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

        return is_array($translations) ? $translations : [];
    }

    /**
     * Get translation for specific locale
     */
    public function getTranslation($field, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $translations = $this->getAllTranslations($field);

        if (is_array($translations) && isset($translations[$locale])) {
            return $translations[$locale];
        }

        return '';
    }
}
