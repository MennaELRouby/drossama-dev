<?php

namespace App\Models\Dashboard;

use App\Traits\HasLanguage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasLanguage;
    protected $table = 'domains';

    protected $fillable = ['title_en',
        'title_fr','title_ar','yearly_price','transfer_price','renewal_price','short_desc_en',
        'short_desc_fr','short_desc_ar','slug_en',
        'slug_fr','slug_ar','status','meta_title_ar','meta_title_en',
        'meta_title_fr','meta_desc_ar','meta_desc_en',
        'meta_desc_fr','index'];

    public function getTitleAttribute()
    {
        return $this->{'title_'.$this->lang } ;
    }
    public function getShortDescAttribute()
    {
        return $this->{'short_desc_'.$this->lang } ;
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }
    
}
