<?php

namespace App\Models;

use App\Traits\HasLanguage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    /** @use HasFactory<\Database\Factories\AuthorFactory> */
    use HasFactory , HasLanguage;

    public $fillable = [
        'name_en',
        'name_ar',
        'email',
        'phone',
        'image',
        'alt_image',
        'role',
        'status',
    ];

    public function getNameAttribute()
    {
        return $this->{'name_'.$this->lang};
    }
    public function getImagePathAttribute()
    {
        return $this->attributes['image'] ? asset('storage/authors/' . $this->attributes['image']) : asset('assets/dashboard/images/noimage.png');
    }
}
