<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobDetail extends Model
{
    protected $fillable = [
        'listing_id',
        'employment_type',
        'workplace_type',
        'min_salary',
        'max_salary',
        'salary_period',
        'experience_level',
        'company_name',
        'company_logo',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}

