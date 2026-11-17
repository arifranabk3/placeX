<?php

namespace App\Services\PortalAdmin;

use App\Models\AuditLog;
use App\Models\Category;
use App\Models\ClassifiedDetail;
use App\Models\JobDetail;
use App\Models\Listing;
use App\Models\ListingImage;
use App\Models\Location;
use App\Models\MatrimonialProfile;
use App\Models\PropertyDetail;
use App\Models\VehicleDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PortalListingService
{
    /**
     * Create or store a new marketplace listing with its category-specific details.
     */
    public function createListing(array $data, ?string $vertical = null): Listing
    {
        return DB::transaction(function () use ($data, $vertical) {
            $slugBase = $data['title'];
            $slug = Str::slug($slugBase);
            $count = Listing::where('slug', 'like', "{$slug}%")->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }

            // Fallback user if not specified (authenticated staff acts as publisher)
            $userId = $data['user_id'] ?? Auth::id();

            // Default location if omitted
            $locationId = $data['location_id'] ?? null;
            if (! $locationId) {
                $loc = Location::first();
                $locationId = $loc ? $loc->id : 1;
            }

            $listing = Listing::create([
                'user_id' => $userId,
                'category_id' => $data['category_id'],
                'location_id' => $locationId,
                'title' => $data['title'],
                'slug' => $slug,
                'description' => $data['description'] ?? '',
                'price' => $data['price'] ?? 0,
                'currency' => $data['currency'] ?? 'PKR',
                'listing_status' => $data['listing_status'] ?? 'draft',
                'moderation_status' => $data['moderation_status'] ?? 'approved',
                'published_at' => ($data['listing_status'] ?? '') === 'active' ? now() : null,
            ]);

            // Save vertical specific details
            $this->syncVerticalDetails($listing, $data, $vertical);

            // Handle primary image if provided
            if (! empty($data['image_url'])) {
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_url' => $data['image_url'],
                    'is_primary' => true,
                    'sort_order' => 1,
                ]);
            }

            AuditLog::record('portal.listing_created', Listing::class, $listing->id, [
                'title' => $listing->title,
                'status' => $listing->listing_status,
                'category_id' => $listing->category_id,
            ]);

            return $listing;
        });
    }

    /**
     * Update an existing listing and its vertical details.
     */
    public function updateListing(Listing $listing, array $data, ?string $vertical = null): Listing
    {
        return DB::transaction(function () use ($listing, $data, $vertical) {
            $listing->update([
                'title' => $data['title'] ?? $listing->title,
                'category_id' => $data['category_id'] ?? $listing->category_id,
                'location_id' => $data['location_id'] ?? $listing->location_id,
                'description' => $data['description'] ?? $listing->description,
                'price' => $data['price'] ?? $listing->price,
                'currency' => $data['currency'] ?? $listing->currency,
                'listing_status' => $data['listing_status'] ?? $listing->listing_status,
                'moderation_status' => $data['moderation_status'] ?? $listing->moderation_status,
                'published_at' => ($data['listing_status'] ?? '') === 'active' && ! $listing->published_at ? now() : $listing->published_at,
            ]);

            $this->syncVerticalDetails($listing, $data, $vertical);

            if (! empty($data['image_url'])) {
                ListingImage::updateOrCreate(
                    ['listing_id' => $listing->id, 'is_primary' => true],
                    ['image_url' => $data['image_url'], 'sort_order' => 1]
                );
            }

            AuditLog::record('portal.listing_updated', Listing::class, $listing->id, [
                'title' => $listing->title,
                'status' => $listing->listing_status,
            ]);

            return $listing;
        });
    }

    /**
     * Sync vertical specs based on category.
     */
    protected function syncVerticalDetails(Listing $listing, array $data, ?string $vertical = null): void
    {
        $category = Category::find($listing->category_id);
        $slug = $vertical ?? ($category ? strtolower($category->slug) : '');

        // Jobs
        if (str_contains($slug, 'job') || isset($data['company_name'])) {
            JobDetail::updateOrCreate(
                ['listing_id' => $listing->id],
                [
                    'company_name' => $data['company_name'] ?? 'PlaceX Employer',
                    'job_type' => $data['job_type'] ?? 'full-time',
                    'experience_level' => $data['experience_level'] ?? 'mid-level',
                    'salary_min' => $data['salary_min'] ?? null,
                    'salary_max' => $data['salary_max'] ?? null,
                ]
            );
        }

        // Property
        if (str_contains($slug, 'prop') || isset($data['property_purpose'])) {
            PropertyDetail::updateOrCreate(
                ['listing_id' => $listing->id],
                [
                    'property_purpose' => $data['property_purpose'] ?? 'sale',
                    'property_type' => $data['property_type'] ?? 'house',
                    'area_size' => $data['area_size'] ?? '5 Marla',
                    'area_unit' => $data['area_unit'] ?? 'Marla',
                    'bedrooms' => $data['bedrooms'] ?? 3,
                    'bathrooms' => $data['bathrooms'] ?? 3,
                ]
            );
        }

        // Classifieds
        if (str_contains($slug, 'class') || isset($data['condition'])) {
            ClassifiedDetail::updateOrCreate(
                ['listing_id' => $listing->id],
                [
                    'condition' => $data['condition'] ?? 'used',
                    'brand' => $data['brand'] ?? null,
                    'model' => $data['model'] ?? null,
                ]
            );
        }

        // Vehicles
        if (str_contains($slug, 'vehic') || str_contains($slug, 'car') || isset($data['make'])) {
            VehicleDetail::updateOrCreate(
                ['listing_id' => $listing->id],
                [
                    'make' => $data['make'] ?? 'Toyota',
                    'model' => $data['vehicle_model'] ?? ($data['model'] ?? 'Corolla'),
                    'year' => $data['year'] ?? 2022,
                    'mileage' => $data['mileage'] ?? 45000,
                    'transmission' => $data['transmission'] ?? 'automatic',
                    'fuel_type' => $data['fuel_type'] ?? 'petrol',
                ]
            );
        }

        // Matrimonial
        if (str_contains($slug, 'matri') || str_contains($slug, 'marr') || isset($data['marital_status'])) {
            MatrimonialProfile::updateOrCreate(
                ['listing_id' => $listing->id],
                [
                    'gender' => $data['gender'] ?? 'male',
                    'age' => $data['age'] ?? 28,
                    'marital_status' => $data['marital_status'] ?? 'single',
                    'religion' => $data['religion'] ?? 'Islam',
                    'education' => $data['education'] ?? 'Masters',
                    'profession' => $data['profession'] ?? 'Software Engineer',
                ]
            );
        }
    }
}
