<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingPromotion extends Model
{
    protected $fillable = [
        'listing_id',
        'promotion_plan_id',
        'applied_by',
        'starts_at',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function plan()
    {
        return $this->belongsTo(PromotionPlan::class, 'promotion_plan_id');
    }

    public function appliedBy()
    {
        return $this->belongsTo(User::class, 'applied_by');
    }
}
