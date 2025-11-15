<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
   protected $table = 'attributes' ;

   protected $fillable = ['name_ar','name_en',
        'name_fr' , 'icon' , 'alt_icon' , 'status'];

   public function getNameAttribute()
   {

       $lang = app()->getLocale();

       return $this->{'name_'.$lang } ;
   }

   public function getIconPathAttribute()
   {
       return $this->attributes['icon'] ? asset('storage/attributes/' . $this->attributes['icon']) : asset('assets/dashboard/images/noIcon.png');
   }

   public function values()
   {
       return $this->hasMany(AttributeValue::class);
   }
}
