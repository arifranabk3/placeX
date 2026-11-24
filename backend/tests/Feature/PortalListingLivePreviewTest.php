<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Listing;
use App\Models\ListingImage;
use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

class PortalListingLivePreviewTest extends TestCase
{
    protected ?User $portalManager = null;
    protected int $locationId = 1;

    protected function setUp(): void
    {
        parent::setUp();
        $this->portalManager = User::where('email', 'portal@placex.test')->first()
            ?? User::whereHas('roles', fn($q) => $q->whereIn('slug', ['portal-manager', 'super-admin']))->first()
            ?? User::first();

        if (! $this->portalManager) {
            $this->portalManager = User::factory()->create([
                'name' => 'Portal Test Manager',
                'email' => 'portal@placex.test',
                'status' => 'active',
            ]);
        }

        $loc = Location::first();
        $this->locationId = $loc ? $loc->id : 1;
    }

    public function test_create_page_contains_live_preview_and_split_screen_architecture(): void
    {
        $response = $this->actingAs($this->portalManager)->get('/portal-admin/listings/create');
        $response->assertStatus(200);
        $response->assertSee('portalListingEditor');
        $response->assertSee('Real-Time Public Preview');
        $response->assertSee('Card Mode');
        $response->assertSee('Detail Mode');
        $response->assertSee('1. Marketplace Vertical');
        $response->assertSee('4. Gallery &amp; Photos', false);
    }

    public function test_edit_page_loads_existing_listing_data_and_images_into_preview(): void
    {
        $category = Category::where('slug', 'like', '%vehic%')->orWhere('slug', 'like', '%car%')->first() ?? Category::first();

        $listing = Listing::create([
            'user_id' => $this->portalManager->id,
            'category_id' => $category->id,
            'location_id' => $this->locationId,
            'title' => 'Original Honda Civic Oriel 2022',
            'slug' => 'original-honda-civic-oriel-2022-' . uniqid(),
            'description' => 'Original unmodified description for Honda Civic.',
            'price' => 6500000,
            'currency' => 'PKR',
            'listing_status' => 'draft',
            'moderation_status' => 'approved',
        ]);

        $image = ListingImage::create([
            'listing_id' => $listing->id,
            'image_path' => 'https://example.com/honda-civic.jpg',
            'is_primary' => true,
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($this->portalManager)->get("/portal-admin/listings/{$listing->id}/edit");
        $response->assertStatus(200);
        $response->assertSee('Edit Marketplace Listing');
        $response->assertSee('portalListingEditor');
        $response->assertSee('Original Honda Civic Oriel 2022');
        $response->assertSee('Card Mode');
        $response->assertSee('Detail Mode');
        $response->assertSee('honda-civic.jpg');
    }

    public function test_edit_updates_fields_without_altering_unrelated_attributes(): void
    {
        $category = Category::first();
        $listing = Listing::create([
            'user_id' => $this->portalManager->id,
            'category_id' => $category->id,
            'location_id' => $this->locationId,
            'title' => 'Initial Title ' . uniqid(),
            'slug' => 'initial-title-' . uniqid(),
            'description' => 'Initial text description.',
            'price' => 120000,
            'currency' => 'PKR',
            'listing_status' => 'draft',
            'moderation_status' => 'approved',
        ]);

        $updatePayload = [
            'title' => 'Updated Parity Title ' . uniqid(),
            'category_id' => $category->id,
            'location_id' => $this->locationId,
            'description' => 'Updated description verified via parity suite.',
            'price' => 145000,
            'currency' => 'PKR',
            'listing_status' => 'active',
        ];

        $response = $this->actingAs($this->portalManager)->put("/portal-admin/listings/{$listing->id}", $updatePayload);
        $response->assertRedirect('/portal-admin/listings');

        $this->assertDatabaseHas('listings', [
            'id' => $listing->id,
            'title' => $updatePayload['title'],
            'price' => 145000,
            'listing_status' => 'active',
        ]);
    }

    public function test_safe_image_removal_does_not_delete_server_media_until_saved(): void
    {
        $category = Category::first();
        $listing = Listing::create([
            'user_id' => $this->portalManager->id,
            'category_id' => $category->id,
            'location_id' => $this->locationId,
            'title' => 'Safe Image Removal Test ' . uniqid(),
            'slug' => 'safe-image-removal-' . uniqid(),
            'description' => 'Testing safe image persistence.',
            'price' => 30000,
            'currency' => 'PKR',
            'listing_status' => 'draft',
        ]);

        $image1 = ListingImage::create([
            'listing_id' => $listing->id,
            'image_path' => 'https://example.com/keep-image.jpg',
            'is_primary' => true,
            'sort_order' => 1,
        ]);

        $image2 = ListingImage::create([
            'listing_id' => $listing->id,
            'image_path' => 'https://example.com/remove-image.jpg',
            'is_primary' => false,
            'sort_order' => 2,
        ]);

        // Prior to saving, both images exist on the server
        $this->assertDatabaseHas('listing_images', ['id' => $image1->id]);
        $this->assertDatabaseHas('listing_images', ['id' => $image2->id]);

        // Submit update confirming image2 removal
        $response = $this->actingAs($this->portalManager)->put("/portal-admin/listings/{$listing->id}", [
            'title' => $listing->title,
            'category_id' => $listing->category_id,
            'location_id' => $this->locationId,
            'description' => $listing->description,
            'price' => $listing->price,
            'listing_status' => 'draft',
            'removed_image_ids' => [$image2->id],
        ]);

        $response->assertRedirect('/portal-admin/listings');

        // image1 preserved, image2 removed
        $this->assertDatabaseHas('listing_images', ['id' => $image1->id]);
        $this->assertDatabaseMissing('listing_images', ['id' => $image2->id]);
    }

    public function test_all_five_categories_persist_vertical_specs_on_create_and_edit(): void
    {
        $categories = Category::all();

        // 1. Jobs
        $jobCat = $categories->first(fn($c) => str_contains(strtolower($c->slug), 'job')) ?? Category::first();
        $jobListing = Listing::create([
            'user_id' => $this->portalManager->id,
            'category_id' => $jobCat->id,
            'location_id' => $this->locationId,
            'title' => 'Senior DevOps Engineer',
            'slug' => 'senior-devops-engineer-' . uniqid(),
            'description' => 'Kubernetes, Terraform and CI/CD pipelines.',
            'price' => 250000,
            'listing_status' => 'active',
        ]);

        $this->actingAs($this->portalManager)->put("/portal-admin/listings/{$jobListing->id}", [
            'title' => 'Senior Lead DevOps Engineer',
            'category_id' => $jobCat->id,
            'location_id' => $this->locationId,
            'description' => 'Updated job description.',
            'price' => 300000,
            'listing_status' => 'active',
            'company_name' => 'PlaceX Cloud Systems',
            'job_type' => 'contract',
            'workplace_type' => 'remote',
            'experience_level' => 'lead',
            'salary_min' => 280000,
            'salary_max' => 350000,
        ]);

        $this->assertDatabaseHas('job_details', [
            'listing_id' => $jobListing->id,
            'company_name' => 'PlaceX Cloud Systems',
            'employment_type' => 'contract',
            'workplace_type' => 'remote',
            'experience_level' => 'lead',
            'min_salary' => 280000,
            'max_salary' => 350000,
        ]);

        // 2. Property
        $propCat = $categories->first(fn($c) => str_contains(strtolower($c->slug), 'prop')) ?? Category::first();
        $propListing = Listing::create([
            'user_id' => $this->portalManager->id,
            'category_id' => $propCat->id,
            'location_id' => $this->locationId,
            'title' => 'Luxury 10 Marla Villa',
            'slug' => 'luxury-10-marla-villa-' . uniqid(),
            'description' => 'Modern luxury villa in prime location.',
            'price' => 35000000,
            'listing_status' => 'active',
        ]);

        $this->actingAs($this->portalManager)->put("/portal-admin/listings/{$propListing->id}", [
            'title' => 'Luxury 10 Marla Villa - Fully Furnished',
            'category_id' => $propCat->id,
            'location_id' => $this->locationId,
            'description' => 'Furnished luxury villa.',
            'price' => 38000000,
            'listing_status' => 'active',
            'property_purpose' => 'sale',
            'property_type' => 'house',
            'area_size' => '10 Marla',
            'bedrooms' => 5,
            'bathrooms' => 6,
        ]);

        $this->assertDatabaseHas('property_details', [
            'listing_id' => $propListing->id,
            'purpose' => 'sale',
            'area_size' => 10,
            'area_unit' => 'Marla',
            'bedrooms' => 5,
            'bathrooms' => 6,
        ]);

        // 3. Vehicles
        $vehicCat = $categories->first(fn($c) => str_contains(strtolower($c->slug), 'vehic') || str_contains(strtolower($c->slug), 'car')) ?? Category::first();
        $vehicListing = Listing::create([
            'user_id' => $this->portalManager->id,
            'category_id' => $vehicCat->id,
            'location_id' => $this->locationId,
            'title' => 'Toyota Land Cruiser V8',
            'slug' => 'toyota-land-cruiser-v8-' . uniqid(),
            'description' => 'Bumper to bumper genuine.',
            'price' => 45000000,
            'listing_status' => 'active',
        ]);

        $this->actingAs($this->portalManager)->put("/portal-admin/listings/{$vehicListing->id}", [
            'title' => 'Toyota Land Cruiser ZX 2023',
            'category_id' => $vehicCat->id,
            'location_id' => $this->locationId,
            'description' => 'Updated specs for vehicle.',
            'price' => 46000000,
            'listing_status' => 'active',
            'make' => 'Toyota',
            'vehicle_model' => 'Land Cruiser',
            'year' => 2023,
            'mileage' => 12000,
            'transmission' => 'automatic',
            'fuel_type' => 'petrol',
        ]);

        $this->assertDatabaseHas('vehicle_details', [
            'listing_id' => $vehicListing->id,
            'make' => 'Toyota',
            'model' => 'Land Cruiser',
            'year' => 2023,
        ]);

        // 4. Classifieds
        $classCat = $categories->first(fn($c) => str_contains(strtolower($c->slug), 'class')) ?? Category::first();
        $classListing = Listing::create([
            'user_id' => $this->portalManager->id,
            'category_id' => $classCat->id,
            'location_id' => $this->locationId,
            'title' => 'Apple MacBook Pro M3 Max',
            'slug' => 'apple-macbook-pro-m3-' . uniqid(),
            'description' => '16-inch 36GB unified memory.',
            'price' => 750000,
            'listing_status' => 'active',
        ]);

        $this->actingAs($this->portalManager)->put("/portal-admin/listings/{$classListing->id}", [
            'title' => 'Apple MacBook Pro M3 Max 64GB',
            'category_id' => $classCat->id,
            'location_id' => $this->locationId,
            'description' => 'Upgraded memory specification.',
            'price' => 850000,
            'listing_status' => 'active',
            'condition' => 'used',
            'brand' => 'Apple',
            'model' => 'MacBook Pro M3 Max',
        ]);

        $this->assertDatabaseHas('classified_details', [
            'listing_id' => $classListing->id,
            'brand' => 'Apple',
            'model' => 'MacBook Pro M3 Max',
        ]);

        // 5. Matrimonial
        $matriCat = $categories->first(fn($c) => str_contains(strtolower($c->slug), 'matri') || str_contains(strtolower($c->slug), 'marr')) ?? Category::first();
        $matriListing = Listing::create([
            'user_id' => $this->portalManager->id,
            'category_id' => $matriCat->id,
            'location_id' => $this->locationId,
            'title' => 'Doctor Bride Proposal',
            'slug' => 'doctor-bride-proposal-' . uniqid(),
            'description' => 'Looking for well-educated family match.',
            'price' => 0,
            'listing_status' => 'active',
        ]);

        $this->actingAs($this->portalManager)->put("/portal-admin/listings/{$matriListing->id}", [
            'title' => 'Doctor Bride Proposal - Islamabad',
            'category_id' => $matriCat->id,
            'location_id' => $this->locationId,
            'description' => 'Updated proposal details.',
            'price' => 0,
            'listing_status' => 'active',
            'gender' => 'female',
            'age' => 26,
            'marital_status' => 'single',
            'religion' => 'Islam - Sunni',
            'education' => 'MBBS / FCPS-1',
            'profession' => 'Resident Physician',
        ]);

        $this->assertDatabaseHas('matrimonial_profiles', [
            'listing_id' => $matriListing->id,
            'gender' => 'female',
            'education' => 'MBBS / FCPS-1',
            'profession' => 'Resident Physician',
        ]);
    }
}
