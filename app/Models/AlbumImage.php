<?php

namespace App\Models;

use App\Traits\HasLanguage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbumImage extends Model
{
    use HasLanguage , HasFactory;
    protected $table = 'album_images';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/albums/' . $this->image) : asset('assets/dashboard/images/noimage.png');
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }
} 