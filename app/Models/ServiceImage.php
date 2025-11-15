<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use DB;

class ServiceImage extends Model
{
	protected $table='service_images';

    public $timestamps = true; // Fixed: was false but table has timestamps

    protected $fillable = ['service_id', 'image', 'order'];

    /**
     * Get the service that owns the image
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the image URL with proper asset path
     */
    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('storage/services/' . $value);
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
