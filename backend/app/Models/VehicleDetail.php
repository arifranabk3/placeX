<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleDetail extends Model
{
    protected $fillable = [
        'listing_id',
        'make',
        'model',
        'variant',
        'year',
        'mileage',
        'transmission',
        'fuel_type',
        'engine_capacity',
        'body_type',
        'assembly',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}

