<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassifiedDetail extends Model
{
    protected $fillable = [
        'listing_id',
        'sub_category',
        'condition',
        'brand',
        'model',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}

