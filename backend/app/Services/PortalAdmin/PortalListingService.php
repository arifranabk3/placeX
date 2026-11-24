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
                    'image_path' => $data['image_url'],
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
                'is_featured' => isset($data['is_featured']) ? (bool)$data['is_featured'] : $listing->is_featured,
                'published_at' => ($data['listing_status'] ?? '') === 'active' && ! $listing->published_at ? now() : $listing->published_at,
            ]);

            $this->syncVerticalDetails($listing, $data, $vertical);

            // 1. Safe removal of images confirmed by the user upon save
            if (! empty($data['removed_image_ids']) && is_array($data['removed_image_ids'])) {
                ListingImage::where('listing_id', $listing->id)
                    ->whereIn('id', $data['removed_image_ids'])
                    ->delete();
            }

            // 2. Add or update primary image from form input
            if (! empty($data['image_url'])) {
                $existing = ListingImage::where('listing_id', $listing->id)
                    ->where('image_path', $data['image_url'])
                    ->first();

                if (! $existing) {
                    ListingImage::create([
                        'listing_id' => $listing->id,
                        'image_path' => $data['image_url'],
                        'is_primary' => true,
                        'sort_order' => 1,
                    ]);
                }
            }

            // Re-normalize primary flag so at most one image is primary
            $primaryImage = ListingImage::where('listing_id', $listing->id)->first();
            if ($primaryImage) {
                ListingImage::where('listing_id', $listing->id)->update(['is_primary' => false]);
                $primaryImage->update(['is_primary' => true]);
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
            $rawEmp = str_replace('-', '_', strtolower($data['job_type'] ?? ($data['employment_type'] ?? 'full_time')));
            $validEmp = ['full_time', 'part_time', 'contract', 'internship', 'temporary'];
            $employmentType = in_array($rawEmp, $validEmp) ? $rawEmp : 'full_time';

            $rawWork = strtolower($data['workplace_type'] ?? 'onsite');
            $validWork = ['onsite', 'remote', 'hybrid'];
            $workplaceType = in_array($rawWork, $validWork) ? $rawWork : 'onsite';

            JobDetail::updateOrCreate(
                ['listing_id' => $listing->id],
                [
                    'company_name' => $data['company_name'] ?? 'PlaceX Employer',
                    'employment_type' => $employmentType,
                    'workplace_type' => $workplaceType,
                    'experience_level' => $data['experience_level'] ?? 'mid-level',
                    'min_salary' => $data['salary_min'] ?? ($data['min_salary'] ?? null),
                    'max_salary' => $data['salary_max'] ?? ($data['max_salary'] ?? null),
                ]
            );
        }

        // Property
        if (str_contains($slug, 'prop') || isset($data['property_purpose'])) {
            $rawArea = $data['area_size'] ?? '5';
            $numericArea = (float) filter_var($rawArea, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            if ($numericArea <= 0) {
                $numericArea = 5.0;
            }

            $areaUnit = 'Marla';
            if (stripos($rawArea, 'kanal') !== false) {
                $areaUnit = 'Kanal';
            } elseif (stripos($rawArea, 'sqft') !== false || stripos($rawArea, 'sq') !== false) {
                $areaUnit = 'Sq. Ft.';
            }

            PropertyDetail::updateOrCreate(
                ['listing_id' => $listing->id],
                [
                    'purpose' => $data['property_purpose'] ?? ($data['purpose'] ?? 'sale'),
                    'property_type' => $data['property_type'] ?? 'house',
                    'area_size' => $numericArea,
                    'area_unit' => $data['area_unit'] ?? $areaUnit,
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
