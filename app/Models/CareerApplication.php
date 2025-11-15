<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerApplication extends Model
{
    protected $table = 'career_applications';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'cv',
        'job_position_id',
        'position',
        'cover_letter',
        'status',
        'seen'
    ];

    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class, 'job_position_id');
    }

   public function getCvPathAttribute()
{
    return $this->attributes['cv']
        ? 'career-applications/' . $this->attributes['cv']
        : null;
}

    public function getCvUrlAttribute()
    {
        return $this->attributes['cv'] ? asset('storage/career-applications/' . $this->attributes['cv']) : null;
    }
}
