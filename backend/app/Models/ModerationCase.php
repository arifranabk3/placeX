<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModerationCase extends Model
{
    protected $fillable = [
        'listing_id',
        'assigned_to',
        'trigger_type',
        'verdict',
        'notes',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function moderator()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
