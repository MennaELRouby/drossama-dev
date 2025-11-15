<?php

namespace App\Models;

use App\Traits\HasJsonTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Benefit extends Model
{
    use HasFactory, HasJsonTranslations;
    protected $table = 'benefits';
    protected $fillable = [
        'benefitable_id',
        'benefitable_type',
        'title_en',
        'title_fr',
        'title_ar',
        'short_description_en',
        'short_description_ar',
        'long_description_en',
        'long_description_ar',
        'image',
        'icon',
        'status',
        'order',
        'alt_image',
        'alt_icon',

        'name',
        'description',
    ];


    protected $casts = [
        'name' => 'array',
        'description' => 'array',
    ];
    public function benefitable()
    {
        return $this->morphTo();
    }

    public function getImagePathAttribute()
    {
        return $this->image ? asset('storage/benefits/' . $this->image) : asset('assets/dashboard/images/noimage.png');;
    }

    public function getIconPathAttribute()
    {
        return $this->icon ? asset('storage/benefits/' . $this->icon) : asset('assets/dashboard/images/noimage.png');
    }
    public function getTitleAttribute()
    {
        return $this->{'title_' . $this->lang};
    }
    public function getShortDescAttribute()
    {
        return $this->{'short_description_' . $this->lang};
    }
    public function getLongDescAttribute()
    {
        return $this->{'long_description_' . $this->lang};
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeGeneral($query)
    {
        return $query->where('benefitable_type', null);
    }
}
