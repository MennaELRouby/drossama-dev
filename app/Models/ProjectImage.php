<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use DB;

class ProjectImage extends Model
{
    protected $table='project_images';

    public $timestamps = true; // Fixed: was false but table has timestamps

    protected $fillable = ['project_id', 'image', 'order'];

    /**
     * Get the project that owns the image
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the image URL with proper asset path
     */
    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('storage/projects/' . $value);
        }
        return asset('assets/dashboard/images/noimage.png');
    }

    /**
     * Get the raw filename from database
     */
    public function getImageFilenameAttribute()
    {
        return $this->attributes['image'] ?? null;
    }

    /**
     * Get the image URL (alias for getImageAttribute)
     */
    public function getImageUrlAttribute()
    {
        return $this->getImageAttribute($this->attributes['image'] ?? null);
    }
}   