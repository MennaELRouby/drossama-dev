<?php

namespace App\Models;

use App\Traits\HasJsonTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    /** @use HasFactory<\Database\Factories\TestimonialFactory> */
    use HasFactory, HasJsonTranslations;
    protected $table = 'testimonials';
    protected $fillable = [
        'name',
        'position',
        'content',
        'image',
        'video_link',
        'status',
        'order',
    ];

    protected $casts = [
        'name' => 'array',
        'position' => 'array',
        'content' => 'array',
    ];

    public function getNameAttribute()
    {
        return $this->getTranslation('name');
    }

    public function getPositionAttribute()
    {
        return $this->getTranslation('position');
    }

    public function getContentAttribute()
    {
        return $this->getTranslation('content');
    }
    public function getImagePathAttribute()
    {
        return $this->image ?    asset('storage/testimonials/' . $this->image) : asset('assets/dashboard/images/noimage.png');
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
