<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

use App\Traits\HasJsonTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory, HasJsonTranslations;

    protected $table = 'sliders';

    protected $fillable = [
        'image',
        'mobile_image',
        'alt_image',
        'alt_mobile_image',
        'icon',
        'alt_icon',
        'order',
        'status',
        'type',
        'language',
        'title',
        'title2',
        'text',
    ];


    protected $casts = [
        'title' => 'array',
        'title2' => 'array',
        'text' => 'array',
    ];
    public static function getTypeSelect()
    {
        return [
            'top_header' => __('dashboard.top_header'),
            'middle'     => __('dashboard.slider'),
            'bottom'     => __('dashboard.bottom'),
        ];
    }

    public function getTitleAttribute()
    {
        return $this->getTranslatableAttribute('title');
    }
    public function getSubTitleAttribute()
    {
        return $this->getTranslatableAttribute('title2');
    }
    public function getTextAttribute()
    {
        return $this->getTranslatableAttribute('text');
    }

    public function getImagePathAttribute()
    {
        return $this->attributes['image'] ? asset('storage/sliders/' . $this->attributes['image']) : asset('assets/dashboard/images/noimage.png');
    }

    public function getMobileImagePathAttribute()
    {
        return $this->attributes['mobile_image'] ? asset('storage/sliders/' . $this->attributes['mobile_image']) : $this->getImagePathAttribute();
    }

    public function getIconPathAttribute()
    {
        return $this->attributes['icon'] ? asset('storage/sliders/' . $this->attributes['icon']) : asset('assets/dashboard/images/noimage.png');
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }
    public function scopeHome(Builder $query): void
    {
        $query->where('type', 'middle');
    }
    public function scopeTopHeader(Builder $query): void
    {
        $query->where('type', 'top_header');
    }

    public function scopeForLanguage(Builder $query, string $language = null): void
    {
        if ($language) {
            $query->where(function ($q) use ($language) {
                $q->where('language', 'all')
                    ->orWhere('language', $language);
            });
        }
    }

    public static function getLanguageSelect()
    {
        $languages = config('laravellocalization.supportedLocales', []);
        $options = ['all' => __('dashboard.all_languages')];

        foreach ($languages as $code => $language) {
            $options[$code] = $language['native'] ?? $language['name'] ?? strtoupper($code);
        }

        return $options;
    }
}
