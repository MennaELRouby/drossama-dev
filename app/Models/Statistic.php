<?php

namespace App\Models;

use App\Traits\HasLanguage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    /** @use HasFactory<\Database\Factories\StatisticFactory> */
    use HasFactory, HasLanguage;
    protected $fillable = [
        'title_en',
        'title_fr',
        'title_ar',
        'value',
        'text_en',
        'text_ar',
        'status'
    ];

    public function getTitleAttribute()
    {
        return $this->{'title_'.$this->lang};
    }
    public function getTextAttribute()
    {
        return $this->{'text_'.$this->lang};
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
