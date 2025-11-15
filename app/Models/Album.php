<?php

namespace App\Models;

use App\Traits\HasLanguage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Album extends Model
{
    use HasLanguage, HasFactory;
    protected $table = 'albums';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function images()
    {
        return $this->hasMany(AlbumImage::class, 'album_id')->orderBy('order');
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }

    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $this->{'name_' . $locale} ?? $this->name_ar ?? $this->name_en;
    }
}