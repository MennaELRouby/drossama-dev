<?php

namespace App\Models;

use App\Traits\HasLanguage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryVideo extends Model
{
    /** @use HasFactory<\Database\Factories\GalleryVideoFactory> */
    use HasFactory , HasLanguage;
    protected $table = 'gallery_videos';

    protected $fillable = [
        'title_ar',
        'title_en',
        'title_fr',
        'video_url',
        'description_ar',
        'description_en',
        'description_fr',
        'image',
        'icon',
        'status',
        'created_at',
        'updated_at',
    ];

      public function getImagePathAttribute()
    {
        return $this->attributes['image'] ? asset('storage/gallery_videos/' . $this->attributes['image']) : asset('assets/dashboard/images/noimage.png');
    }
    public function getIconPathAttribute()
    {
        return $this->attributes['icon'] ? asset('storage/gallery_videos/' . $this->attributes['icon']) : asset('assets/dashboard/images/noimage.png');
    }

    public function getTitleAttribute()
    {
        return $this->{'title_' . $this->lang};
    }
    public function getDescriptionAttribute()
    {
        return $this->{'description_' . $this->lang};
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
