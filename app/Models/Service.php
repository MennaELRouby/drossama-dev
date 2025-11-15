<?php

namespace App\Models;

use App\Traits\HasJsonTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Service extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceFactory> */
    use HasFactory, HasJsonTranslations;

    protected $table = 'services';
    protected $fillable = [
        'parent_id',
        'name',
        'short_desc',
        'long_desc',
        'meta_title',
        'meta_desc',
        'slug',
        'image',
        'alt_image',
        'icon',
        'alt_icon',
        'status',
        'show_in_home',
        'show_in_header',
        'show_in_footer',
        'index',
        'order',
    ];

    protected $casts = [
        'name' => 'array',
        'short_desc' => 'array',
        'long_desc' => 'array',
        'meta_title' => 'array',
        'meta_desc' => 'array',
        'slug' => 'array',
    ];

    public function getRouteKeyName()
    {
        if (!request()->is('*dashboard*')) {
            return 'id'; // Use ID for frontend routing with JSON system
        }

        return 'id'; // for dashboard/admin
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKey()
    {
        if (!request()->is('*dashboard*')) {
            return $this->getKey(); // Return ID for frontend routing
        }

        return $this->getKey();
    }

    public function parent()
    {
        return $this->belongsTo(Service::class, 'parent_id');
    }

    public function serviceImages()
    {
        return $this->hasMany(ServiceImage::class, 'service_id')->orderBy('order');
    }

    public function images()
    {
        return $this->serviceImages();
    }

    public function getNameAttribute()
    {
        return $this->getTranslation('name');
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

    public function getImagePathAttribute()
    {
        return $this->image ? asset('storage/services/' . $this->image) : asset('assets/dashboard/images/noimage.png');
    }

    public function getIconPathAttribute()
    {
        return $this->icon ? asset('storage/services/' . $this->icon) : asset('assets/dashboard/images/noIcon.png');
    }

    /**
     * Generate SEO-friendly alt text for main image
     */
    public function getImageAltAttribute()
    {
        if ($this->alt_image) {
            return $this->alt_image;
        }

        return $this->name . ' - ' . __('website.service') . ' | ' . config('configrations.site_name');
    }

    /**
     * Generate SEO-friendly alt text for icon
     */
    public function getIconAltAttribute()
    {
        if ($this->alt_icon) {
            return $this->alt_icon;
        }

        return $this->name . ' - ' . __('website.service_icon') . ' | ' . config('configrations.site_name');
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }

    public function scopeHome(Builder $query): void
    {
        $query->where('show_in_home', 1);
    }

    public function scopeFooter(Builder $query): void
    {
        $query->where('show_in_footer', 1);
    }
    public function scopeHeader(Builder $query): void
    {
        $query->where('show_in_header', 1);
    }

    /**
     * Get localized URL for specific locale
     */
    public function getLocalizedUrl($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $slug = $this->getTranslation('slug', $locale);

        if (!$slug) {
            // Fallback to any available slug
            $allTranslations = $this->getAllTranslations('slug');
            $slug = reset($allTranslations);
        }

        return $slug ? LaravelLocalization::getLocalizedURL($locale, 'services/' . $slug) : '';
    }



    public function getLinkAttribute()
    {
        $slug = $this->getTranslation('slug');
        if (!$slug) return '#';

        $locale = app()->getLocale();
        return url($locale . '/services/' . $slug);
    }
}
