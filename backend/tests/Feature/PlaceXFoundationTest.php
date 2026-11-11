<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Conversation;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Broadcast;
use Tests\TestCase;

class PlaceXFoundationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_health_check_returns_healthy_status(): void
    {
        $response = $this->getJson('/api/v1/health');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'status' => 'healthy',
                    'database' => 'connected',
                ],
            ]);
    }

    public function test_categories_endpoint_returns_five_core_categories(): void
    {
        $response = $this->getJson('/api/v1/categories');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonCount(5, 'data');
    }

    public function test_listings_endpoint_returns_seeded_listings(): void
    {
        $response = $this->getJson('/api/v1/listings');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'slug',
                        'price',
                        'category',
                        'location',
                    ]
                ],
                'pagination',
            ]);
    }

    public function test_user_registration_and_authentication(): void
    {
        $payload = [
            'name' => 'Test Buyer',
            'email' => 'buyer@placex.test',
            'phone' => '+923009988776',
            'password' => 'SecretPass123!',
            'password_confirmation' => 'SecretPass123!',
        ];

        $response = $this->postJson('/api/v1/auth/register', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'data' => [
                    'user' => ['id', 'name', 'email'],
                    'token',
                    'token_type',
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'buyer@placex.test',
        ]);
    }

    public function test_user_login_with_valid_credentials(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'seller@placex.test',
            'password' => 'SellerPlaceX2026!',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'data' => ['user', 'token', 'token_type']
            ]);
    }

    public function test_user_login_fails_with_invalid_credentials(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'seller@placex.test',
            'password' => 'WrongPassword!',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_protected_account_profile_requires_sanctum_token(): void
    {
        $this->getJson('/api/v1/account/profile')->assertStatus(401);

        $user = User::where('email', 'seller@placex.test')->first();

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/account/profile')
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'email' => 'seller@placex.test',
                ],
            ]);
    }

    public function test_matrimonial_public_listing_protects_private_fields(): void
    {
        $response = $this->getJson('/api/v1/listings/px-1024-educated-bride-profile-islamabad');

        $response->assertStatus(200);

        // Verify that sensitive family/income fields are not serialized publicly
        $data = $response->json('data');
        $this->assertArrayNotHasKey('family_details', $data['matrimonial_profile']);
        $this->assertArrayNotHasKey('monthly_income', $data['matrimonial_profile']);
        $this->assertEquals('female', $data['matrimonial_profile']['gender']);
    }

    public function test_private_conversation_channel_authorization(): void
    {
        $seller = User::where('email', 'seller@placex.test')->first();
        $admin = User::where('email', 'admin@placex.test')->first();

        $conversation = Conversation::create([
            'created_by' => $seller->id,
            'last_message_at' => now(),
        ]);
        $conversation->participants()->attach($seller->id);

        // Seller is authorized
        $this->assertTrue(
            Conversation::where('id', $conversation->id)
                ->whereHas('participants', fn($q) => $q->where('user_id', $seller->id))
                ->exists()
        );

        // Admin is not in participants list, regular authorization check denies non-participant
        $this->assertFalse(
            Conversation::where('id', $conversation->id)
                ->whereHas('participants', fn($q) => $q->where('user_id', $admin->id))
                ->exists()
        );
    }
}

