<?php

namespace App\Models;

use App\Traits\HasLanguage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    /** @use HasFactory<\Database\Factories\BlogCategoryFactory> */
    use HasFactory , HasLanguage;
    protected $table = 'blog_categories';

    protected $fillable = [
        'name_en',
        'name_fr',
        'name_ar',
        'short_desc_en',
        'short_desc_fr',
        'short_desc_ar',
        'long_desc_en',
        'long_desc_fr',
        'long_desc_ar',
        'image',
        'alt_image',
        'icon',
        'alt_icon',
        'meta_title_en',
        'meta_title_fr',
        'meta_title_ar',
        'meta_desc_en',
        'meta_desc_fr',
        'meta_desc_ar',
        'slug_en',
        'slug_fr',
        'slug_ar',
        'status',
        'show_in_home',
        'show_in_header',
        'show_in_footer',
        'index',
        'order',
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }

    public function getImagePathAttribute()
    {
        return $this->attributes['image'] ? asset('storage/blog_categories/' . $this->attributes['image']) : asset('assets/dashboard/images/noimage.png');
    }
    public function getIconPathAttribute()
    {
        return $this->attributes['icon'] ? asset('storage/blog_categories/' . $this->attributes['icon']) : asset('assets/dashboard/images/noimage.png');
    }

    public  function getNameAttribute()
    {
        return $this->{'name_'.$this->lang};
    }
}
