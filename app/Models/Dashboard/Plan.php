<?php

namespace App\Models\Dashboard;

use App\Traits\HasLanguage;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasLanguage;

    protected $table = 'plans';

    protected $fillable = ['hosting_id','lable','icon','alt_icon','image','alt_image','monthly_price','yearly_price','slug_en',
        'slug_fr','slug_ar','status','show_in_home','meta_title_ar','meta_title_en',
        'meta_title_fr','meta_desc_ar','meta_desc_en',
        'meta_desc_fr','index'];

    public function planAttributes()
    {
        return $this->hasMany(PlanAttribute::class);
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'plan_attribute_values')
                    ->withPivot('attribute_id');
    }

    public function getFormattedAttributes()
{
    return $this->planAttributes->map(function ($planAttribute) {
        // Get the attribute name
        $attributeName = $planAttribute->attribute->name;
        
        // Get the related values for the current plan attribute
        $values = $this->attributeValues
            ->where('attribute_id', $planAttribute->attribute_id)
            ->pluck('value_en')
            ->join(', ');

        return [
            'name' => $attributeName,
            'values' => $values,
        ];
    });
}

    public function getNameAttribute()
    {
        return $this->{'name_'.$this->lang } ;
    }

  

    public function hosting()
    {
        return $this->belongsTo(Hosting::class);    
    }

    public function getImagePathAttribute()
    {
        return $this->attributes['image'] ? asset('storage/plans/' . $this->attributes['image']) : asset('assets/dashboard/images/noimage.png');
    }

    public function getIconPathAttribute()
    {
        return $this->attributes['icon'] ? asset('storage/plans/' . $this->attributes['icon']) : asset('assets/dashboard/images/noIcon.png');
    }

  
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }

    public function scopeHome(Builder $query): void
    {
        $query->where('show_in_home', 1);
    }

    public function getSlugAttribute()
    {
        return $this->{'slug_'.$this->lang } ;
    }

}
