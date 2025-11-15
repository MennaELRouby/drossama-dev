<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $table = 'attribute_values';

    protected $fillable = ['attribute_id','value_ar', 'value_en','price', 'status'];

    public function getValueAttribute()
    {
        $lang = app()->getLocale();

        return $this->{'value_'.$lang } ;
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_attribute_value')
                    ->withPivot('attribute_id');
    }
}
