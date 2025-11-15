<?php

namespace App\Models\Dashboard;

use App\Traits\HasLanguage;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasJsonTranslations;

class AboutUs extends Model
{
    use HasLanguage, HasJsonTranslations;
    protected $table = 'about';

    protected $fillable = ['title', 'title2', 'short_desc', 'long_desc', 'text', 'image', 'alt_image', 'banner', 'alt_banner', 'video_link'];

    protected $casts = [
        'title' => 'array',
        'title2' => 'array',
        'short_desc' => 'array',
        'long_desc' => 'array',
        'text' => 'array',
    ];
    public function getTitleAttribute()
    {
        return $this->getTranslation('title');
    }

    public function getTitle2Attribute()
    {
        return $this->getTranslation('title2');
    }

    public function getShortDescAttribute()
    {
        return $this->getTranslation('short_desc');
    }

    public function getLongDescAttribute()
    {
        return $this->getTranslation('long_desc');
    }

    public function getTextAttribute()
    {
        return $this->getTranslation('text');
    }



    public function getImagePathAttribute()
    {
        return $this->attributes['image'] ? asset('storage/about/' . $this->attributes['image']) : asset('assets/dashboard/images/noimage.png');
    }

    public function getBannerPathAttribute()
    {
        return $this->attributes['banner'] ? asset('storage/about/' . $this->attributes['banner']) : asset('assets/dashboard/images/noimage.png');
    }
}