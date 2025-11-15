<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasJsonTranslations;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Menu extends Model
{
    use HasJsonTranslations;

    protected $table = 'menus';

    protected $fillable = ['parent_id', 'segment', 'status', 'order', 'type', 'name'];

    protected $casts = [
        'name' => 'array',
    ];


    public static function getSegmentSelect()
    {
        return [
            '#'          => __('dashboard.parent_menu_only'),
            '/'          => __('dashboard.home'),
            'about-us'   => __('dashboard.about_us'),
            'hostings'   => __('dashboard.hostings'),
            'services'   => __('dashboard.services'),
            'products'   => __('dashboard.products'),
            'projects'   => __('dashboard.projects'),
            'careers'    => __('dashboard.careers'),
            'blogs'      => __('dashboard.blogs'),
            'contact-us' => __('dashboard.contact_us'),
            'gallery'    => __('dashboard.gallery'),
            'videos'     => __('dashboard.videos'),
            'solutions'  => __('dashboard.solutions'),
            'faq'        => __('dashboard.faq'),
            'testimonials' => __('dashboard.testimonials'),
            'team'       => __('dashboard.team'),
            'clients'    => __('dashboard.clients'),
            'custom'     => __('dashboard.custom_link'),
            'why-us'     => __('dashboard.why_us'),
        ];
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->active()->orderBy('order');
    }

    public function getParentNameAttribute()
    {
        return $this->parent ? $this->parent->getTranslation('name') : __('dashboard.no_parent');
    }

    /**
     * Get the name attribute based on current locale
     */
    public function getNameAttribute()
    {
        return $this->getTranslation('name', app()->getLocale());
    }


    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }

    public function getLinkAttribute()
    {
        if ($this->segment === '#') {
            return '#';
        }

        return $this->segment ? LaravelLocalization::LocalizeUrl($this->segment) : '#';
    }
}
