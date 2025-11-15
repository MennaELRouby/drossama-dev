<?php

namespace App\Models;

use App\Traits\HasLanguage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory,HasLanguage;
    protected $fillable = [
        'name_en',
        'name_fr',
        'name_ar',
        'description_en',
        'description_fr',
        'description_ar',
        'logo',
        'status',
        'order'
    ];

    public function getLogoPathAttribute()
    {
        return $this->attributes['logo'] ? asset('storage/clients/' . $this->attributes['logo']) : asset('assets/dashboard/images/noimage.png');

    }

    public function getNameAttribute()
    {
       return  $this->{'name_'.$this->lang};
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
