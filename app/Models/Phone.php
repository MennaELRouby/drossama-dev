<?php

namespace App\Models;

use App\Traits\HasJsonTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Cache-related imports removed since cache is disabled

class Phone extends Model
{
    /** @use HasFactory<\Database\Factories\PhoneFactory> */
    use HasFactory, HasJsonTranslations;

    protected $table = 'phones';

    protected $fillable = [
        'name',
        'description',
        'phone',
        'email',
        'code',
        'order',
        'type',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
        'name' => 'array',
        'description' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', false);
    }

    // No cache clearing needed - cache is completely disabled

    public function getNameAttribute()
    {
        return $this->getFallbackTranslation('name');
    }

    public function getDescriptionAttribute()
    {
        return $this->getFallbackTranslation('description');
    }
}
