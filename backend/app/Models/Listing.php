<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'location_id',
        'title',
        'slug',
        'description',
        'price',
        'currency',
        'latitude',
        'longitude',
        'listing_status',
        'moderation_status',
        'published_at',
        'expires_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function images()
    {
        return $this->hasMany(ListingImage::class)->orderBy('sort_order');
    }

    public function attributes()
    {
        return $this->hasMany(ListingAttribute::class);
    }

    public function jobDetail()
    {
        return $this->hasOne(JobDetail::class);
    }

    public function propertyDetail()
    {
        return $this->hasOne(PropertyDetail::class);
    }

    public function classifiedDetail()
    {
        return $this->hasOne(ClassifiedDetail::class);
    }

    public function vehicleDetail()
    {
        return $this->hasOne(VehicleDetail::class);
    }

    public function matrimonialProfile()
    {
        return $this->hasOne(MatrimonialProfile::class);
    }

    public function favourites()
    {
        return $this->belongsToMany(User::class, 'listing_favourites')->withTimestamps();
    }
}

