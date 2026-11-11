<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatrimonialProfile extends Model
{
    protected $fillable = [
        'listing_id',
        'profile_for',
        'gender',
        'age',
        'marital_status',
        'height_cm',
        'religion',
        'sect',
        'caste_or_clan',
        'education',
        'profession',
        'monthly_income',
        'family_details',
        'privacy_level',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function preferences()
    {
        return $this->hasOne(MatrimonialPreference::class);
    }
}

