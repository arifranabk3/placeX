<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatrimonialPreference extends Model
{
    protected $fillable = [
        'matrimonial_profile_id',
        'min_age',
        'max_age',
        'preferred_city',
        'preferred_education',
        'preferred_profession',
        'additional_notes',
    ];

    public function profile()
    {
        return $this->belongsTo(MatrimonialProfile::class, 'matrimonial_profile_id');
    }
}

