<?php

namespace Tests\Feature;

use App\Models\TouristProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login view screen rendering.
     */
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertRedirect('/');
    }

    /**
     * Test successful authentication with valid user credentials.
     */
    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create([
            'username' => 'juandelacruz',
            'email' => 'juan.delacruz@example.com',
            'password' => Hash::make('Secret123!'),
        ]);

        $response = $this->post('/login', [
            'username' => 'juandelacruz',
            'password' => 'Secret123!',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/user/dashboard');

        $user->refresh();
        $this->assertNotNull($user->last_login_at);
    }

    /**
     * Test login failure with invalid password.
     */
    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'username' => 'juandelacruz',
            'email' => 'juan.delacruz@example.com',
            'password' => Hash::make('Secret123!'),
        ]);

        $response = $this->post('/login', [
            'username' => 'juandelacruz',
            'password' => 'WrongPassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('username');
    }

    /**
     * Test login validation errors when inputs are missing.
     */
    public function test_users_can_not_authenticate_with_missing_credentials(): void
    {
        $response = $this->post('/login', [
            'username' => '',
            'password' => '',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['username', 'password']);
    }

    /**
     * Test register view screen rendering.
     */
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertRedirect('/');
    }

    /**
     * Test successful user registration creating User and TouristProfile models.
     */
    public function test_new_users_can_register_and_creates_tourist_profile(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'Maria',
            'middle_name' => 'Clara',
            'last_name' => 'Santos',
            'mobile_number' => '09171234567',
            'barangay' => 'Poblacion',
            'email' => 'maria.santos@example.com',
            'username' => 'mariasantos',
            'password' => 'B@liT0urs#2026!P@ss',
            'password_confirmation' => 'B@liT0urs#2026!P@ss',
        ]);

        $response->assertRedirect('/user/dashboard');

        // Verify User was created
        $this->assertDatabaseHas('users', [
            'username' => 'mariasantos',
            'email' => 'maria.santos@example.com',
            'role' => 'tourist',
            'status' => 'active',
        ]);

        $user = User::where('username', 'mariasantos')->first();
        $this->assertNotNull($user);
        $this->assertAuthenticatedAs($user);

        // Verify TouristProfile was created via DB transaction
        $this->assertDatabaseHas('tourist_profiles', [
            'user_id' => $user->id,
            'first_name' => 'Maria',
            'middle_name' => 'Clara',
            'last_name' => 'Santos',
            'mobile_number' => '09171234567',
            'city_municipality' => 'Balingasag',
            'province' => 'Misamis Oriental',
            'barangay' => 'Poblacion',
        ]);
    }

    /**
     * Test registration failure when using an already registered email.
     */
    public function test_registration_fails_with_duplicate_email(): void
    {
        User::factory()->create([
            'email' => 'existing.user@example.com',
            'username' => 'existinguser',
        ]);

        $response = $this->post('/register', [
            'first_name' => 'Pedro',
            'last_name' => 'Penduko',
            'mobile_number' => '09189876543',
            'barangay' => 'Hermano',
            'email' => 'existing.user@example.com',
            'username' => 'newuser',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    /**
     * Test registration failure when using an already registered username.
     */
    public function test_registration_fails_with_duplicate_username(): void
    {
        User::factory()->create([
            'email' => 'user1@example.com',
            'username' => 'takenusername',
        ]);

        $response = $this->post('/register', [
            'first_name' => 'Pedro',
            'last_name' => 'Penduko',
            'mobile_number' => '09189876543',
            'barangay' => 'Hermano',
            'email' => 'user2@example.com',
            'username' => 'takenusername',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('username');
    }

    /**
     * Test registration failure when password confirmation does not match.
     */
    public function test_registration_fails_when_passwords_do_not_match(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'Pedro',
            'last_name' => 'Penduko',
            'mobile_number' => '09189876543',
            'barangay' => 'Hermano',
            'email' => 'pedro.penduko@example.com',
            'username' => 'pedropenduko',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'MismatchPassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('password');
    }

    /**
     * Test registration validation failure when required fields are missing.
     */
    public function test_registration_fails_when_required_fields_are_missing(): void
    {
        $response = $this->post('/register', []);

        $this->assertGuest();
        $response->assertSessionHasErrors([
            'first_name',
            'last_name',
            'mobile_number',
            'barangay',
            'email',
            'username',
            'password',
        ]);
    }

    /**
     * Test authenticated user logout flow.
     */
    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
