<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyDetail extends Model
{
    protected $fillable = [
        'listing_id',
        'purpose',
        'property_type',
        'area_size',
        'area_unit',
        'bedrooms',
        'bathrooms',
        'amenities',
    ];

    protected $casts = [
        'amenities' => 'array',
        'area_size' => 'decimal:2',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}

