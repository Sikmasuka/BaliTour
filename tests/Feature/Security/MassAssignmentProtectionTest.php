<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MassAssignmentProtectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 'role' cannot be mass-assigned directly using Eloquent User::create().
     */
    public function test_role_is_not_mass_assignable_on_user_model(): void
    {
        $user = User::create([
            'username' => 'regularuser',
            'email' => 'regular@example.com',
            'password' => Hash::make('B@liT0urs#2026!'),
            'role' => 'admin', // Attempted mass assignment
        ]);

        $this->assertNotEquals('admin', $user->fresh()->role);
    }

    /**
     * Test an attacker cannot escalate to admin by injecting 'role' into registration payload.
     */
    public function test_registration_request_cannot_inject_admin_role(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'mobile_number' => '09171234567',
            'barangay' => 'Poblacion',
            'email' => 'johndoe@example.com',
            'username' => 'johndoe',
            'password' => 'B@liT0urs#2026!',
            'password_confirmation' => 'B@liT0urs#2026!',
            'role' => 'admin', // Injected privilege escalation field
        ]);

        $response->assertRedirect('/user/dashboard');

        $user = User::where('username', 'johndoe')->first();
        $this->assertNotNull($user);
        $this->assertEquals('tourist', $user->role);
        $this->assertNotEquals('admin', $user->role);
    }
}
