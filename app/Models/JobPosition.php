<?php

namespace App\Models;

use App\Traits\HasLanguage;
use App\Traits\HasJsonTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class JobPosition extends Model
{
    /** @use HasFactory<\Database\Factories\JobPositionFactory> */
    use HasFactory, HasLanguage;

    protected $table = 'job_positions';

    protected $fillable = [
        'location',
        'image',
        'alt_image',
        'icon',
        'alt_icon',
        'type',
        'status',
        'title',
        'description',
        'requirements',
    ];


    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'requirements' => 'array',
    ];
    public static function getTypeSelect()
    {
        return [
            'full-time' => __('dashboard.full_time'),
            'part-time' => __('dashboard.part_time'),
            'contract'  => __('dashboard.contract'),
        ];
    }

    public function getImagePathAttribute()
    {
        return $this->attributes['image'] ? asset('storage/job-positions/' . $this->attributes['image']) : asset('assets/dashboard/images/noimage.png');
    }
    public function getIconPathAttribute()
    {
        return $this->attributes['icon'] ? asset('storage/job-positions/' . $this->attributes['icon']) : asset('assets/dashboard/images/noimage.png');
    }
    public function getTitleAttribute()
    {
        return $this->getTranslation('title');
    }
    public function getDescriptionAttribute()
    {
        return $this->getTranslation('description');
    }
    public function getRequirementsAttribute()
    {
        return $this->getTranslation('requirements');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
