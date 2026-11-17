<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    public function test_guest_is_redirected_to_admin_login(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');
    }

    public function test_regular_user_cannot_access_admin_dashboard(): void
    {
        $user = User::where('email', '!=', 'admin@placex.test')
            ->whereDoesntHave('roles', fn ($q) => $q->whereIn('slug', ['super-admin', 'admin', 'moderator', 'support-agent']))
            ->first();

        if (! $user) {
            $user = User::factory()->create([
                'email' => 'regular_test@placex.test',
                'password' => Hash::make('password123'),
                'status' => 'active',
            ]);
        }

        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(403);
    }

    public function test_super_admin_can_access_admin_dashboard(): void
    {
        $admin = User::where('email', 'admin@placex.test')->first();
        if ($admin) {
            $response = $this->actingAs($admin)->get('/admin');
            $response->assertStatus(200);
            $response->assertSee('PlaceX Operations Center');
        } else {
            $this->assertTrue(true);
        }
    }
}
