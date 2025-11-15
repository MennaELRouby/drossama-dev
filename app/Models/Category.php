<?php

namespace App\Models;

use App\Traits\HasJsonTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, HasJsonTranslations;
    protected $fillable = [
        'order',
        'parent_id',
        'image',
        'icon',
        'alt_image',
        'alt_icon',
        'status',
        'show_in_home',
        'show_in_header',
        'show_in_footer',
        'index',
        'name',
        'short_desc',
        'long_desc',
        'meta_title',
        'meta_desc',
        'slug',
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
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function images()
    {
        return $this->hasMany(CategoryImage::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeHome($query)
    {
        return $query->where('show_in_home', 1);
    }
    public function getLinkAttribute()
    {
        return  LaravelLocalization::LocalizeUrl('products/' . $this->getTranslation('slug'));
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

        return $slug ? LaravelLocalization::getLocalizedURL($locale, 'categories/' . $slug) : '';
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

    public function getNameAttribute()
    {
        return $this->getTranslation('name', app()->getLocale());
    }
}
