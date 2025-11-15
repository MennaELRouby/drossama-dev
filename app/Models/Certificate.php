<?php

namespace App\Models;

use App\Traits\HasJsonTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory, HasJsonTranslations;

    protected $table = 'certificates';

    protected $fillable = [
        'name',
        'image',
        'alt_image',
        'status',
        'order',
    ];

    protected $casts = [
        'name' => 'array',
    ];

    public function getNameAttribute()
    {
        return $this->getTranslation('name');
    }

    public function getImagePathAttribute()
    {
        return $this->image ? asset('storage/certificates/' . $this->image) : asset('assets/dashboard/images/noimage.png');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
