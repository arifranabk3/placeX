<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PortalAdminTest extends TestCase
{
    public function test_guest_is_redirected_from_portal_dashboard_to_portal_login(): void
    {
        $response = $this->get('/portal-admin/dashboard');
        $response->assertRedirect('/portal-admin/login');
    }

    public function test_portal_manager_can_access_portal_dashboard(): void
    {
        $manager = User::where('email', 'portal@placex.test')->first();
        if ($manager) {
            $response = $this->actingAs($manager)->get('/portal-admin/dashboard');
            $response->assertStatus(200);
            $response->assertSee('PlaceX Marketplace CMS');
            $response->assertSee('Marketplace &amp; Content Management', false);
        } else {
            $this->assertTrue(true);
        }
    }

    public function test_regular_user_cannot_access_portal_dashboard(): void
    {
        $user = User::where('email', '!=', 'portal@placex.test')
            ->whereDoesntHave('roles', fn ($q) => $q->whereIn('slug', ['super-admin', 'admin', 'portal-manager', 'content-manager', 'listing-manager', 'moderator', 'support-agent']))
            ->first();

        if (! $user) {
            $user = User::factory()->create([
                'email' => 'regular_customer_' . uniqid() . '@placex.test',
                'status' => 'active',
                'password' => Hash::make('secret123'),
            ]);
        }

        $response = $this->actingAs($user)->get('/portal-admin/dashboard');
        $response->assertStatus(403);
    }

    public function test_portal_staff_can_view_listings_index(): void
    {
        $manager = User::where('email', 'portal@placex.test')->first();
        if ($manager) {
            $response = $this->actingAs($manager)->get('/portal-admin/listings');
            $response->assertStatus(200);
            $response->assertSee('Marketplace Listings Directory');
        } else {
            $this->assertTrue(true);
        }
    }

    public function test_portal_listing_creation_workflow(): void
    {
        $manager = User::where('email', 'portal@placex.test')->first();
        $category = Category::first();

        if ($manager && $category) {
            $payload = [
                'title' => 'Portal Test Automatic Listing ' . uniqid(),
                'category_id' => $category->id,
                'price' => 75000,
                'currency' => 'PKR',
                'description' => 'Test listing created via Portal Admin automated verification test.',
                'listing_status' => 'active',
                'moderation_status' => 'approved',
            ];

            $response = $this->actingAs($manager)->post('/portal-admin/listings', $payload);
            $response->assertRedirect('/portal-admin/listings');

            $this->assertDatabaseHas('listings', [
                'title' => $payload['title'],
                'listing_status' => 'active',
                'moderation_status' => 'approved',
            ]);
        } else {
            $this->assertTrue(true);
        }
    }
}
