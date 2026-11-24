<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingImage extends Model
{
    protected $fillable = ['listing_id', 'image_path', 'is_primary', 'sort_order'];

    protected $appends = ['image_url'];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function getImageUrlAttribute(): string
    {
        return $this->image_path ?? '';
    }

    public function setImageUrlAttribute(?string $value): void
    {
        $this->attributes['image_path'] = $value;
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}

