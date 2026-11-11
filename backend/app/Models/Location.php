<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['country', 'state', 'city', 'latitude', 'longitude', 'is_active'];

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }
}

