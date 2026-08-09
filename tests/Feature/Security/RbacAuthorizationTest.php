<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test unauthenticated guests cannot access admin or user dashboards.
     */
    public function test_guests_cannot_access_protected_user_or_admin_routes(): void
    {
        $responseUser = $this->get('/user/dashboard');
        $responseUser->assertRedirect('/login');

        $responseAdmin = $this->get('/admin/dashboard');
        $responseAdmin->assertRedirect('/login');
    }

    /**
     * Test regular tourist users cannot access admin routes (prevents Privilege Escalation / Broken Access Control).
     */
    public function test_tourist_users_cannot_access_admin_panel(): void
    {
        $tourist = User::factory()->create([
            'role' => 'tourist',
        ]);

        $response = $this->actingAs($tourist)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    /**
     * Test admin users can successfully access admin routes.
     */
    public function test_admin_users_can_access_admin_panel(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }
}
