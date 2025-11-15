<?php

namespace App\Models;

use App\Traits\HasJsonTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, HasJsonTranslations;
    protected $table = 'products';
    protected $fillable = [
        'category_id',
        'service_id',
        'parent_id',
        'name',
        'short_desc',
        'long_desc',
        'meta_title',
        'meta_desc',
        'slug',
        'clients',
        'location',
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
        'clients' => 'array',
        'location' => 'array',
    ];

    public function getRouteKeyName()
    {
        if (!request()->is('*dashboard*')) {
            return 'id'; // We'll handle slug routing in controller
        }

        return 'id'; // for dashboard/admin
    }

    public function parent()
    {
        return $this->belongsTo(Product::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(Product::class, 'parent_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getImagePathAttribute()
    {
        return $this->image ? asset('storage/products/' . $this->image) : asset('assets/dashboard/images/noimage.png');
    }
    public function getIconPathAttribute()
    {
        return $this->icon ? asset('storage/products/' . $this->icon) : asset('assets/dashboard/images/noimage.png');
    }

    public function getClientsAttribute()
    {
        return $this->getTranslation('clients');
    }

    public function getLocationAttribute()
    {
        return $this->getTranslation('location');
    }

    /**
     * Generate SEO-friendly alt text for main image
     */
    public function getImageAltAttribute()
    {
        if ($this->alt_image) {
            return $this->alt_image;
        }

        return $this->name . ' - ' . __('website.product') . ' | ' . config('configrations.site_name');
    }

    /**
     * Generate SEO-friendly alt text for icon
     */
    public function getIconAltAttribute()
    {
        if ($this->alt_icon) {
            return $this->alt_icon;
        }

        return $this->name . ' - ' . __('website.product_icon') . ' | ' . config('configrations.site_name');
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

    public function getLinkAttribute()
    {
        $slug = $this->getTranslation('slug');
        if (!$slug) {
            return '';
        }

        // Check if product has children (sub-products)
        $hasChildren = $this->children()->where('status', 1)->exists();

        if ($hasChildren) {
            // Go to sub-products page
            return LaravelLocalization::localizeUrl('products/' . $slug . '/sub-products');
        }

        // Go to product details page
        return LaravelLocalization::localizeUrl('products/' . $slug);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('order');
    }
    public function images()
    {
        return $this->productImages();
    }
    public function getcategoryNameAttribute()
    {
        return $this->{'category_' . $this->lang};
    }
    public function getserviceAttribute()
    {
        return $this->{'service_' . $this->lang};
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

        return $slug ? LaravelLocalization::getLocalizedURL($locale, 'products/' . $slug) : '';
    }

    /**
     * Get the partners associated with the product.
     */
    public function parteners()
    {
        return $this->belongsToMany(Partener::class, 'partener_product', 'product_id', 'partener_id')->withTimestamps();
    }
}
