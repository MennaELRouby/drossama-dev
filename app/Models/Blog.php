<?php

namespace App\Models;

use App\Traits\HasJsonTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Blog extends Model
{
    /** @use HasFactory<\Database\Factories\BlogFactory> */
    use HasFactory, HasJsonTranslations;
    protected $table = 'blogs';
    protected $fillable = [
        'category_id',
        'author_id',
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
        'date',
        'order',
    ];

    protected $casts = [
        'name' => 'array',
        'short_desc' => 'array',
        'long_desc' => 'array',
        'meta_title' => 'array',
        'meta_desc' => 'array',
        'slug' => 'array',
        'date' => 'datetime',
    ];
    public function getRouteKeyName()
    {
        if (!request()->is('*dashboard*')) {
            return 'id'; // Use ID for frontend routing with JSON system
        }

        return 'id'; // for dashboard/admin
    }

    public function getDateAttribute()
    {
        $original = $this->getAttributes()['date'] ?? null;

        return $original ? \Carbon\Carbon::parse($original)->format('Y-m-d') : '';
    }
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function getImagePathAttribute()
    {
        return $this->image ? asset('storage/blogs/' . $this->image) : asset('assets/dashboard/images/noimage.png');
    }

    public function getIconPathAttribute()
    {
        return $this->icon ? asset('storage/blogs/' . $this->icon) : asset('assets/dashboard/images/noimage.png');
    }

    /**
     * Generate SEO-friendly alt text for main image
     */
    public function getImageAltAttribute()
    {
        if ($this->alt_image) {
            return $this->alt_image;
        }

        return $this->name . ' - ' . __('website.blog_article') . ' | ' . config('configrations.site_name');
    }

    /**
     * Generate SEO-friendly alt text for icon
     */
    public function getIconAltAttribute()
    {
        if ($this->alt_icon) {
            return $this->alt_icon;
        }

        return $this->name . ' - ' . __('website.blog_thumbnail') . ' | ' . config('configrations.site_name');
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
    public function getNameAttribute()
    {
        return $this->getTranslation('name');
    }


    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
    public function scopeHome($query)
    {
        return $query->where('show_in_home', true);
    }
    public function scopeHeader($query)
    {
        return $query->where('show_in_header', true);
    }
    public function scopeFooter($query)
    {
        return $query->where('show_in_footer', true);
    }
    public function getLinkAttribute()
    {
        $currentLocale = app()->getLocale();
        $slug = $this->getTranslation('slug', $currentLocale);
        return $slug ? LaravelLocalization::getLocalizedURL($currentLocale, 'blog/' . $slug) : '';
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

        return $slug ? LaravelLocalization::getLocalizedURL($locale, 'blog/' . $slug) : '';
    }
}
