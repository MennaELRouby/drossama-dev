<?php

namespace App\Models;

use App\Traits\HasJsonTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Project extends Model
{
    use HasFactory, HasJsonTranslations;
    protected $table = 'projects';
    protected $fillable = [
        'category_id',
        'parent_id',
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

    public function projectImages()
    {
        return $this->hasMany(ProjectImage::class, 'project_id')->orderBy('order');
    }

    public function images()
    {
        return $this->projectImages();
    }

    public function parent()
    {
        return $this->belongsTo(Project::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(Project::class, 'parent_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function getImagePathAttribute()
    {
        return $this->image ? asset('storage/projects/' . $this->image) : asset('assets/dashboard/images/noimage.png');
    }
    public function getIconPathAttribute()
    {
        return $this->icon ? asset('storage/projects/' . $this->icon) : asset('assets/dashboard/images/noimage.png');
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
    public function getMetaTitleAttribute()
    {
        return $this->getTranslation('meta_title');
    }
    public function getMetaDescAttribute()
    {
        return $this->getTranslation('meta_desc');
    }
    public function getLinkAttribute()
    {
        return  LaravelLocalization::localizeUrl('projects/' . $this->getTranslation('slug'));
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

        return $slug ? LaravelLocalization::getLocalizedURL($locale, 'projects/' . $slug) : '';
    }
}
