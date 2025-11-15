<?php

namespace App\Models\Dashboard;

use App\Models\Benefit;
use App\Models\Faq;
use App\Traits\HasLanguage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hosting extends Model
{
    use HasFactory,HasLanguage;

    protected $table = 'hostings';

    protected $fillable = ['name_ar','name_en',
        'name_fr','parent_id','short_desc_ar','short_desc_en',
        'short_desc_fr','long_desc_ar','long_desc_en',
        'long_desc_fr','image','alt_image','icon','alt_icon','status','slug_ar','slug_en',
        'slug_fr','meta_title_ar','meta_title_en',
        'meta_title_fr','meta_desc_ar','meta_desc_en',
        'meta_desc_fr','index'];

    public function benefits()
    {
        return $this->morphMany(Benefit::class,'benefitable');
    }

    public function faqs()
    {
        return $this->morphMany(Faq::class,'faqable');
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function getNameAttribute()
    {
        return $this->{'name_'.$this->lang } ;
    }
    public function getShortDescAttribute()
    {
        return $this->{'short_desc_'.$this->lang } ;
    }
    public function getSlugAttribute()
    {
        return $this->{'slug_'.$this->lang } ;
    }
    public function parentHosting()
    {
        return $this->belongsTo(Hosting::class, 'parent_id');
    }

    public function getImagePathAttribute()
    {
        return $this->attributes['image'] ? asset('storage/hostings/' . $this->attributes['image']) : asset('assets/dashboard/images/noimage.png');
    }
    public function getIconPathAttribute()
    {
        return $this->attributes['icon'] ? asset('storage/hostings/' . $this->attributes['icon']) : asset('assets/dashboard/images/noIcon.png');
    }

    public function getParentNameAttribute()
    {
      
        return $this->parentHosting ? $this->parentHosting->{'name_' . $this->lang} : __('dashboard.no_parent');

    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }

    public function scopeHome(Builder $query): void
    {
        $query->where('show_in_home', 1);
    }
    public function scopeHeader(Builder $query): void
    {
        $query->where('show_in_header', 1);
    }



}
