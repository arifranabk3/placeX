<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionPlan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'duration_days',
        'badge_label',
        'badge_color',
        'price',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function activePromotions()
    {
        return $this->hasMany(ListingPromotion::class);
    }
}
