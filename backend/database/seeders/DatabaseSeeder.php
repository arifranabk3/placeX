<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles & Permissions
        $adminRoleId = DB::table('roles')->insertGetId([
            'name' => 'Administrator',
            'slug' => 'admin',
            'description' => 'Super administrative access',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $moderatorRoleId = DB::table('roles')->insertGetId([
            'name' => 'Moderator',
            'slug' => 'moderator',
            'description' => 'Content and trust moderation',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $userRoleId = DB::table('roles')->insertGetId([
            'name' => 'User',
            'slug' => 'user',
            'description' => 'Standard marketplace user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Initial Admin and Demo User
        $adminUserId = DB::table('users')->insertGetId([
            'name' => 'PlaceX Admin',
            'email' => 'admin@placex.test',
            'phone' => '+923000000000',
            'password' => Hash::make('AdminPlaceX2026!'),
            'status' => 'active',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $demoUserId = DB::table('users')->insertGetId([
            'name' => 'Haseeb Seller',
            'email' => 'seller@placex.test',
            'phone' => '+923001112233',
            'password' => Hash::make('SellerPlaceX2026!'),
            'status' => 'active',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('role_user')->insert([
            ['user_id' => $adminUserId, 'role_id' => $adminRoleId],
            ['user_id' => $demoUserId, 'role_id' => $userRoleId],
        ]);

        DB::table('user_profiles')->insert([
            [
                'user_id' => $adminUserId,
                'avatar' => null,
                'bio' => 'System administrator for PlaceX marketplace.',
                'city' => 'Islamabad',
                'country' => 'Pakistan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $demoUserId,
                'avatar' => null,
                'bio' => 'Verified seller and community contributor on PlaceX.',
                'city' => 'Rawalpindi',
                'country' => 'Pakistan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // 3. Top-Level Categories (Preserving PlaceX approved categories)
        $categories = [
            ['name' => 'Jobs', 'slug' => 'jobs', 'icon' => 'fa-briefcase', 'sort_order' => 1],
            ['name' => 'Property', 'slug' => 'property', 'icon' => 'fa-house', 'sort_order' => 2],
            ['name' => 'Classifieds', 'slug' => 'classifieds', 'icon' => 'fa-border-all', 'sort_order' => 3],
            ['name' => 'Vehicles', 'slug' => 'vehicles', 'icon' => 'fa-car', 'sort_order' => 4],
            ['name' => 'Matrimonial', 'slug' => 'matrimonial', 'icon' => 'fa-heart', 'sort_order' => 5],
        ];

        $categoryIds = [];
        foreach ($categories as $cat) {
            $categoryIds[$cat['slug']] = DB::table('categories')->insertGetId([
                'name' => $cat['name'],
                'slug' => $cat['slug'],
                'icon' => $cat['icon'],
                'sort_order' => $cat['sort_order'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Initial Major Locations
        $locations = [
            ['country' => 'Pakistan', 'state' => 'Federal', 'city' => 'Islamabad', 'latitude' => 33.6844, 'longitude' => 73.0479],
            ['country' => 'Pakistan', 'state' => 'Punjab', 'city' => 'Rawalpindi', 'latitude' => 33.5651, 'longitude' => 73.0169],
            ['country' => 'Pakistan', 'state' => 'Punjab', 'city' => 'Lahore', 'latitude' => 31.5204, 'longitude' => 74.3587],
            ['country' => 'Pakistan', 'state' => 'Sindh', 'city' => 'Karachi', 'latitude' => 24.8607, 'longitude' => 67.0011],
        ];

        $locationIds = [];
        foreach ($locations as $loc) {
            $locationIds[$loc['city']] = DB::table('locations')->insertGetId([
                'country' => $loc['country'],
                'state' => $loc['state'],
                'city' => $loc['city'],
                'latitude' => $loc['latitude'],
                'longitude' => $loc['longitude'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 5. Initial Promotion Plans
        $plans = [
            ['name' => 'Standard Free', 'slug' => 'standard-free', 'duration_days' => 30, 'price' => 0.00, 'badge_label' => null, 'badge_color' => null],
            ['name' => 'Featured Listing', 'slug' => 'featured', 'duration_days' => 14, 'price' => 1500.00, 'badge_label' => 'FEATURED', 'badge_color' => '#f97316'],
            ['name' => 'Urgent Deal', 'slug' => 'urgent', 'duration_days' => 7, 'price' => 1000.00, 'badge_label' => 'URGENT', 'badge_color' => '#dc2626'],
        ];

        foreach ($plans as $p) {
            DB::table('promotion_plans')->insert([
                'name' => $p['name'],
                'slug' => $p['slug'],
                'duration_days' => $p['duration_days'],
                'price' => $p['price'],
                'badge_label' => $p['badge_label'],
                'badge_color' => $p['badge_color'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 6. Sample Listings across each of the 5 categories (matching the existing approved HTML content)
        // A. Job Listing
        $jobListingId = DB::table('listings')->insertGetId([
            'user_id' => $demoUserId,
            'category_id' => $categoryIds['jobs'],
            'location_id' => $locationIds['Islamabad'],
            'title' => 'Senior Laravel Developer',
            'slug' => 'senior-laravel-developer-islamabad',
            'description' => 'Join our tech team at TechNova to build and scale modern web applications with Laravel and Next.js.',
            'price' => 200000.00,
            'currency' => 'PKR',
            'latitude' => 33.6844,
            'longitude' => 73.0479,
            'listing_status' => 'active',
            'moderation_status' => 'approved',
            'published_at' => now(),
            'expires_at' => now()->addDays(30),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('job_details')->insert([
            'listing_id' => $jobListingId,
            'employment_type' => 'full_time',
            'workplace_type' => 'hybrid',
            'min_salary' => 150000.00,
            'max_salary' => 200000.00,
            'salary_period' => 'month',
            'experience_level' => 'senior',
            'company_name' => 'TechNova',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // B. Property Listing
        $propertyListingId = DB::table('listings')->insertGetId([
            'user_id' => $demoUserId,
            'category_id' => $categoryIds['property'],
            'location_id' => $locationIds['Rawalpindi'],
            'title' => 'Modern Family House 5 Marla',
            'slug' => 'modern-family-house-5-marla-bahria-town',
            'description' => '5 Marla double-story luxury house in Bahria Town Rawalpindi with premium fixtures and parking.',
            'price' => 22500000.00,
            'currency' => 'PKR',
            'latitude' => 33.5651,
            'longitude' => 73.0169,
            'listing_status' => 'active',
            'moderation_status' => 'approved',
            'published_at' => now(),
            'expires_at' => now()->addDays(60),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('property_details')->insert([
            'listing_id' => $propertyListingId,
            'purpose' => 'sale',
            'property_type' => 'house',
            'area_size' => 5.00,
            'area_unit' => 'marla',
            'bedrooms' => 3,
            'bathrooms' => 4,
            'amenities' => json_encode(['Electricity', 'Water Supply', 'Sui Gas', 'Security Guard']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // C. Classified Listing
        $classifiedListingId = DB::table('listings')->insertGetId([
            'user_id' => $demoUserId,
            'category_id' => $categoryIds['classifieds'],
            'location_id' => $locationIds['Islamabad'],
            'title' => 'iPhone 15 Pro Max 256GB',
            'slug' => 'iphone-15-pro-max-256gb-islamabad',
            'description' => 'Brand new pin-pack iPhone 15 Pro Max Natural Titanium 256GB with full warranty and official receipt.',
            'price' => 425000.00,
            'currency' => 'PKR',
            'latitude' => 33.6844,
            'longitude' => 73.0479,
            'listing_status' => 'active',
            'moderation_status' => 'approved',
            'published_at' => now(),
            'expires_at' => now()->addDays(30),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('classified_details')->insert([
            'listing_id' => $classifiedListingId,
            'sub_category' => 'Mobile Phones',
            'condition' => 'new',
            'brand' => 'Apple',
            'model' => 'iPhone 15 Pro Max',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // D. Vehicle Listing
        $vehicleListingId = DB::table('listings')->insertGetId([
            'user_id' => $demoUserId,
            'category_id' => $categoryIds['vehicles'],
            'location_id' => $locationIds['Lahore'],
            'title' => 'Toyota Corolla Altis Grande 2023',
            'slug' => 'toyota-corolla-altis-grande-2023-lahore',
            'description' => '2023 model, single-owner driven, total genuine paint, low mileage, sunroof and navigation.',
            'price' => 7450000.00,
            'currency' => 'PKR',
            'latitude' => 31.5204,
            'longitude' => 74.3587,
            'listing_status' => 'active',
            'moderation_status' => 'approved',
            'published_at' => now(),
            'expires_at' => now()->addDays(45),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('vehicle_details')->insert([
            'listing_id' => $vehicleListingId,
            'make' => 'Toyota',
            'model' => 'Corolla',
            'variant' => 'Altis Grande 1.8 CVT',
            'year' => 2023,
            'mileage' => 14500,
            'transmission' => 'automatic',
            'fuel_type' => 'petrol',
            'engine_capacity' => 1800,
            'body_type' => 'sedan',
            'assembly' => 'local',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // E. Matrimonial Profile
        $matrimonialListingId = DB::table('listings')->insertGetId([
            'user_id' => $demoUserId,
            'category_id' => $categoryIds['matrimonial'],
            'location_id' => $locationIds['Islamabad'],
            'title' => 'PX-1024 Educated Bride Profile',
            'slug' => 'px-1024-educated-bride-profile-islamabad',
            'description' => 'Looking for a well-educated and practicing life partner for an educated family residing in Islamabad.',
            'price' => null,
            'currency' => 'PKR',
            'latitude' => 33.6844,
            'longitude' => 73.0479,
            'listing_status' => 'active',
            'moderation_status' => 'approved',
            'published_at' => now(),
            'expires_at' => now()->addDays(90),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $matrimonialProfileId = DB::table('matrimonial_profiles')->insertGetId([
            'listing_id' => $matrimonialListingId,
            'profile_for' => 'daughter',
            'gender' => 'female',
            'age' => 27,
            'marital_status' => 'single',
            'height_cm' => 165,
            'religion' => 'Islam',
            'sect' => 'Sunni',
            'education' => 'Masters in Software Engineering',
            'profession' => 'Senior Developer',
            'monthly_income' => 'PKR 250,000+',
            'family_details' => 'Respectable family based in Islamabad.',
            'privacy_level' => 'verified_only',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('matrimonial_preferences')->insert([
            'matrimonial_profile_id' => $matrimonialProfileId,
            'min_age' => 28,
            'max_age' => 33,
            'preferred_city' => 'Islamabad, Rawalpindi, Lahore',
            'preferred_education' => 'Masters / Graduate Engineer or Doctor',
            'preferred_profession' => 'IT Professional / Doctor / Business',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
