<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionEntitlement extends Model
{
    protected $fillable = [
        'user_id',
        'promotion_plan_id',
        'credits_remaining',
        'granted_by',
        'notes',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(PromotionPlan::class, 'promotion_plan_id');
    }

    public function grantedBy()
    {
        return $this->belongsTo(User::class, 'granted_by');
    }
}
