<?php

namespace App\Models\Dashboard;

use App\Traits\HasJsonTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutStruct extends Model
{
    use HasJsonTranslations, HasFactory;

    protected $table = 'about_structs';

    protected $fillable = [
        'name',
        'long_desc',
        'icon',
        'alt_icon',
        'order',
        'status',
    ];

    protected $casts = [
        'name' => 'array',
        'long_desc' => 'array',
    ];

    /**
     * Get the name attribute based on current locale
     */
    public function getNameAttribute()
    {
        return $this->getTranslation('name', app()->getLocale());
    }

    /**
     * Get the long_desc attribute based on current locale
     */
    public function getLongDescAttribute()
    {
        return $this->getTranslation('long_desc', app()->getLocale());
    }

    public function getIconPathAttribute()
    {
        return $this->attributes['icon'] ? asset('storage/about_structs/' . $this->attributes['icon']) : asset('assets/dashboard/images/noimage.png');
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
