<?php

namespace App\Models;

use App\Traits\HasLanguage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partener extends Model
{
    /** @use HasFactory<\Database\Factories\PartenerFactory> */
    use HasFactory, HasLanguage;
    protected $fillable = [
        'name_en',
        'name_fr',
        'name_ar',
        'logo',
        'alt_logo',
        'status',
        'order'
    ];

    public function getLogoPathAttribute()
    {
        return $this->attributes['logo'] ? asset('storage/parteners/' . $this->attributes['logo']) : asset('assets/dashboard/images/noimage.png');
    }

    public function getNameAttribute()
    {
        return  $this->{'name_' . $this->lang};
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Get the products associated with the partner.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'partener_product', 'partener_id', 'product_id')->withTimestamps();
    }
}
