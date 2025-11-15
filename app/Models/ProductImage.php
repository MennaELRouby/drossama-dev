<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $table = 'product_images';

    // Fix timestamps to match database schema
    public $timestamps = true;

    protected $fillable = ['product_id', 'image', 'order'];

    /**
     * Get the product that owns the image
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the image filename (raw value from database)
     */
    public function getImageFilenameAttribute()
    {
        return $this->attributes['image'] ?? null;
    }

    /**
     * Get the full image URL
     */
    public function getImagePathAttribute()
    {
        $value = $this->attributes['image'] ?? null;
        if ($value) {
            return asset('storage/products/' . $value);
        }
        return asset('assets/dashboard/images/noimage.png');
    }

    /**
     * Get the image URL (alias for getImagePathAttribute)
     */
    public function getImageUrlAttribute()
    {
        return $this->getImagePathAttribute();
    }
}
