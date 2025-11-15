<?php

namespace App\Models;

use App\Traits\HasJsonTranslations;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasJsonTranslations;

    protected $table = 'pages';

    protected $fillable = [
        'status',

        'title',
        'content',
        'slug',
    ];


    protected $casts = [
        'title' => 'array',
        'content' => 'array',
        'slug' => 'array',
    ];
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function getTitleAttribute()
    {
        return $this->{'title_' . $this->lang};
    }

    public function getContentAttribute()
    {
        return $this->{'content_' . $this->lang};
    }

    public function getSlugAttribute()
    {
        return $this->{'slug_' . $this->lang};
    }
}
