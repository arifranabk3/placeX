<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $categorySlug = $this->category?->slug;

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price !== null ? (float) $this->price : null,
            'currency' => $this->currency,
            'listing_status' => $this->listing_status,
            'published_at' => $this->published_at?->toISOString(),
            'category' => [
                'id' => $this->category?->id,
                'name' => $this->category?->name,
                'slug' => $this->category?->slug,
                'icon' => $this->category?->icon,
            ],
            'location' => [
                'id' => $this->location?->id,
                'city' => $this->location?->city,
                'state' => $this->location?->state,
                'country' => $this->location?->country,
            ],
            'seller' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
                'is_verified' => (bool) $this->user?->sellerProfile?->is_verified,
            ],
            'images' => $this->images->map(fn($img) => [
                'id' => $img->id,
                'image_path' => $img->image_path,
                'is_primary' => $img->is_primary,
            ]),

            // Category Details
            'job_details' => $this->when($categorySlug === 'jobs' && $this->jobDetail, function () {
                return [
                    'employment_type' => $this->jobDetail->employment_type,
                    'workplace_type' => $this->jobDetail->workplace_type,
                    'min_salary' => $this->jobDetail->min_salary,
                    'max_salary' => $this->jobDetail->max_salary,
                    'salary_period' => $this->jobDetail->salary_period,
                    'experience_level' => $this->jobDetail->experience_level,
                    'company_name' => $this->jobDetail->company_name,
                ];
            }),

            'property_details' => $this->when($categorySlug === 'property' && $this->propertyDetail, function () {
                return [
                    'purpose' => $this->propertyDetail->purpose,
                    'property_type' => $this->propertyDetail->property_type,
                    'area_size' => $this->propertyDetail->area_size,
                    'area_unit' => $this->propertyDetail->area_unit,
                    'bedrooms' => $this->propertyDetail->bedrooms,
                    'bathrooms' => $this->propertyDetail->bathrooms,
                    'amenities' => $this->propertyDetail->amenities,
                ];
            }),

            'classified_details' => $this->when($categorySlug === 'classifieds' && $this->classifiedDetail, function () {
                return [
                    'sub_category' => $this->classifiedDetail->sub_category,
                    'condition' => $this->classifiedDetail->condition,
                    'brand' => $this->classifiedDetail->brand,
                    'model' => $this->classifiedDetail->model,
                ];
            }),

            'vehicle_details' => $this->when($categorySlug === 'vehicles' && $this->vehicleDetail, function () {
                return [
                    'make' => $this->vehicleDetail->make,
                    'model' => $this->vehicleDetail->model,
                    'variant' => $this->vehicleDetail->variant,
                    'year' => $this->vehicleDetail->year,
                    'mileage' => $this->vehicleDetail->mileage,
                    'transmission' => $this->vehicleDetail->transmission,
                    'fuel_type' => $this->vehicleDetail->fuel_type,
                    'engine_capacity' => $this->vehicleDetail->engine_capacity,
                    'body_type' => $this->vehicleDetail->body_type,
                    'assembly' => $this->vehicleDetail->assembly,
                ];
            }),

            // Privacy-Protected Matrimonial profile (NEVER leaks private income or family details in public feed)
            'matrimonial_profile' => $this->when($categorySlug === 'matrimonial' && $this->matrimonialProfile, function () {
                return [
                    'profile_for' => $this->matrimonialProfile->profile_for,
                    'gender' => $this->matrimonialProfile->gender,
                    'age' => $this->matrimonialProfile->age,
                    'marital_status' => $this->matrimonialProfile->marital_status,
                    'height_cm' => $this->matrimonialProfile->height_cm,
                    'religion' => $this->matrimonialProfile->religion,
                    'sect' => $this->matrimonialProfile->sect,
                    'education' => $this->matrimonialProfile->education,
                    'profession' => $this->matrimonialProfile->profession,
                    'preferences' => [
                        'min_age' => $this->matrimonialProfile->preferences?->min_age,
                        'max_age' => $this->matrimonialProfile->preferences?->max_age,
                        'preferred_city' => $this->matrimonialProfile->preferences?->preferred_city,
                    ],
                ];
            }),
        ];
    }
}

