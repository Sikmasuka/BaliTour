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
        // Clears any leftover stamps before each test runs
        RateLimiter::clear('127.0.0.1');
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
     * Test registration returns 429 Too Many Requests after 8 attempts in 1 minute.
     */
    public function test_registration_throttles_after_eight_attempts_per_minute(): void
    {
        // Execute 8 rapid guest registration attempts from the same IP
        for ($i = 1; $i <= 8; $i++) {
            $this->post('/register', [
                'username' => "spamuser{$i}",
                'password' => 'short', // Fails validation, remains unauthenticated guest
            ]);
        }

        // The 9th attempt from the same IP is blocked with 429 Too Many Requests
        $blockedResponse = $this->post('/register', [
            'username' => 'spamuser9',
            'password' => 'short',
        ]);

        $blockedResponse->assertStatus(429);
    }
}
