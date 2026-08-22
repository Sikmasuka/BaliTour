<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicRouteProtectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test guests cannot access internal debug error route.
     */
    public function test_guest_cannot_access_test_error_route(): void
    {
        $response = $this->get('/test-error/500');

        $response->assertRedirect('/login');
    }

    /**
     * Test regular tourist user cannot access admin error testing route (403 Forbidden).
     */
    public function test_tourist_cannot_access_test_error_route(): void
    {
        $tourist = User::factory()->create([
            'role' => 'tourist',
        ]);

        $response = $this->actingAs($tourist)->get('/test-error/500');

        $response->assertStatus(403);
    }

    /**
     * Test administrator can trigger test error route for error page verification.
     */
    public function test_admin_can_access_test_error_route(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/test-error/404');

        $response->assertStatus(404);
    }

    /**
     * Test unauthenticated guest cannot trigger logout.
     */
    public function test_guest_cannot_trigger_logout(): void
    {
        $response = $this->post('/logout');

        $response->assertRedirect('/login');
    }

    /**
     * Test authenticated user can successfully log out.
     */
    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
