<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'transaction_reference',
        'user_id',
        'promotion_plan_id',
        'listing_id',
        'amount',
        'currency',
        'payment_method',
        'payment_status',
        'notes',
        'gateway_response',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_response' => 'array',
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(PromotionPlan::class, 'promotion_plan_id');
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
