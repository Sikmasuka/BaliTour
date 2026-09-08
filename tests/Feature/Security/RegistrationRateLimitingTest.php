<?php

namespace Tests\Feature\Security;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class RegistrationRateLimitingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('spamuser');
        RateLimiter::clear('spamuser@example.com');
        RateLimiter::clear('mariarate');
        RateLimiter::clear('maria.rate@example.com');
        RateLimiter::clear('user1@example.com');
        RateLimiter::clear('user2@example.com');
    }

    /**
     * Test successful registration under rate limit threshold.
     */
    public function test_registration_allowed_within_rate_limit(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'Maria',
            'last_name' => 'Santos',
            'mobile_number' => '09171234567',
            'barangay' => 'Poblacion',
            'email' => 'maria.rate@example.com',
            'username' => 'mariarate',
            'password' => 'B@liT0urs#2026!',
            'password_confirmation' => 'B@liT0urs#2026!',
        ]);

        $response->assertRedirect('/user/dashboard');
        $this->assertDatabaseHas('users', [
            'username' => 'mariarate',
            'email' => 'maria.rate@example.com',
        ]);
    }

    /**
     * Test registration returns 429 Too Many Requests after 5 attempts for the same account identity.
     */
    public function test_registration_throttles_after_eight_attempts_per_minute(): void
    {
        // Execute 5 rapid guest registration attempts targeting the same account identity
        for ($i = 1; $i <= 5; $i++) {
            $this->post('/register', [
                'username' => 'spamuser',
                'email' => 'spamuser@example.com',
                'password' => 'short', // Fails validation, remains unauthenticated guest
            ]);
        }

        // The 6th attempt for the same target identity is blocked with 429 Too Many Requests
        $blockedResponse = $this->post('/register', [
            'username' => 'spamuser',
            'email' => 'spamuser@example.com',
            'password' => 'short',
        ]);

        $blockedResponse->assertStatus(429);
    }

    /**
     * Test different users on the same IP address are not throttled by each other.
     */
    public function test_different_users_on_same_ip_are_not_throttled(): void
    {
        // User 1 attempts registration 5 times
        for ($i = 1; $i <= 5; $i++) {
            $this->post('/register', [
                'username' => 'userone',
                'email' => 'user1@example.com',
                'password' => 'short',
            ]);
        }

        // User 2 from the same IP should still be able to successfully register
        $response = $this->post('/register', [
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'mobile_number' => '09181234567',
            'barangay' => 'Poblacion',
            'email' => 'user2@example.com',
            'username' => 'usertwo',
            'password' => 'B@liT0urs#2026!',
            'password_confirmation' => 'B@liT0urs#2026!',
        ]);

        $response->assertRedirect('/user/dashboard');
        $this->assertDatabaseHas('users', [
            'username' => 'usertwo',
            'email' => 'user2@example.com',
        ]);
    }

    /**
     * Test JSON registration request returns structured 429 lockout payload with seconds.
     */
    public function test_registration_returns_json_lockout_payload(): void
    {
        RateLimiter::clear('jsonbot');
        RateLimiter::clear('jsonbot@example.com');

        for ($i = 1; $i <= 5; $i++) {
            $this->postJson('/register', [
                'username' => 'jsonbot',
                'email' => 'jsonbot@example.com',
                'password' => 'short',
            ]);
        }

        $blockedJson = $this->postJson('/register', [
            'username' => 'jsonbot',
            'email' => 'jsonbot@example.com',
            'password' => 'short',
        ]);

        $blockedJson->assertStatus(429)
            ->assertJson([
                'success' => false,
                'locked' => true,
            ])
            ->assertJsonStructure(['success', 'locked', 'lockout_seconds', 'message']);
    }

    /**
     * Test progressive warning returns remaining attempts on validation failures.
     */
    public function test_registration_returns_remaining_attempts_warning(): void
    {
        RateLimiter::clear('warnreg');
        RateLimiter::clear('warnreg@example.com');

        // Attempt 1: 4 attempts remaining (no warning yet)
        $res1 = $this->postJson('/register', [
            'username' => 'warnreg',
            'email' => 'warnreg@example.com',
            'password' => 'short',
        ]);
        $res1->assertStatus(422)
            ->assertJson([
                'success' => false,
                'remaining_attempts' => 4,
                'is_warning' => false,
            ]);

        // Attempt 2
        $this->postJson('/register', [
            'username' => 'warnreg',
            'email' => 'warnreg@example.com',
            'password' => 'short',
        ]);

        // Attempt 3: 2 attempts remaining (warning triggered)
        $res3 = $this->postJson('/register', [
            'username' => 'warnreg',
            'email' => 'warnreg@example.com',
            'password' => 'short',
        ]);
        $res3->assertStatus(422)
            ->assertJson([
                'success' => false,
                'remaining_attempts' => 2,
                'is_warning' => true,
            ]);
    }
}
