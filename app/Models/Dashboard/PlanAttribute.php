<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;

class PlanAttribute extends Model
{
    protected $table = 'plan_attributes';

    protected $fillable = ['attribute_id','plan_id'];

    public function plan()
    {
      return  $this->belongsTo(Plan::class);
    }

    public function attribute()
    {
       return  $this->belongsTo(Attribute::class,'attribute_id');
    }
}
