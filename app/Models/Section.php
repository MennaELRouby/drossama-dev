<?php

namespace App\Models;

use App\Traits\HasJsonTranslations;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasJsonTranslations;
    protected $table = 'sections';
    protected $fillable = [
        'name',
        'title',
        'short_desc',
        'long_desc',
        'key',
        'image',
        'alt_image',
        'icon',
        'alt_icon',
        'status',
    ];


    protected $casts = [
        'name' => 'array',
        'title' => 'array',
        'short_desc' => 'array',
        'long_desc' => 'array',
    ];
    public static function getKeySelect()
    {
        return [
            'products'          => 'Products Section',
            'testimonial'        => 'Testimonial Section',
            'services'   =>     'Services Section',
            'blogs'             => 'Blogs Section',
            'about'             => 'About Section',
            'contact'          => 'Contact Section',
            'whyus'             => 'Why Us Section',
            'video'             => 'Video Section',
            'photos'     => 'Photos Section',
            'clients'     => 'Clients Section',
        ];
    }
    public function getImagePathAttribute()
    {
        return $this->attributes['image'] ? asset('storage/sections/' . $this->attributes['image']) : asset('assets/dashboard/images/noimage.png');
    }
    public function getIconPathAttribute()
    {
        return $this->attributes['icon'] ? asset('storage/sections/' . $this->attributes['icon']) : asset('assets/dashboard/images/noimage.png');
    }

    public function getNameAttribute()
    {
        return $this->getTranslation('name');
    }

    public function getTitleAttribute()
    {
        return $this->getTranslation('title');
    }

    public function getShortDescAttribute()
    {
        return $this->getTranslation('short_desc');
    }

    public function getLongDescAttribute()
    {
        $longDesc = $this->getTranslation('long_desc', app()->getLocale());

        // If this is for display and contains #call# placeholder, replace it
        if (strpos($longDesc, '#call#') !== false) {
            $callButtonsHtml = view('Website.partials._call-buttons', ['phones' => \App\Models\Phone::active()->orderBy('order')->get()])->render();
            $longDesc = str_replace('#call#', $callButtonsHtml, $longDesc);
        }

        return $longDesc;
    }

    public function getAllTranslations($field)
    {
        $translations = $this->getRawOriginal($field);

        if (is_string($translations)) {
            $decoded = json_decode($translations, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $translations = $decoded;
            } else {
                // Double decode for escaped JSON
                $doubleDecoded = json_decode($decoded, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($doubleDecoded)) {
                    $translations = $doubleDecoded;
                }
            }
        }

        return is_array($translations) ? $translations : [];
    }
}