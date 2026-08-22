<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class LoginRateLimitingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('targetuser');
        RateLimiter::clear('victimuser');
        RateLimiter::clear('validuser');
    }

    /**
     * Test Tier 1 per-user lockout after 5 failed login attempts (3 minutes lockout).
     */
    public function test_login_locks_account_after_five_failed_attempts(): void
    {
        User::factory()->create([
            'username' => 'targetuser',
            'password' => Hash::make('CorrectP@ssword123!'),
        ]);

        // 5 consecutive failed attempts
        for ($i = 1; $i <= 5; $i++) {
            $response = $this->post('/login', [
                'username' => 'targetuser',
                'password' => "wrong_pass_{$i}",
            ]);
            $response->assertSessionHasErrors('username');
        }

        // 6th attempt with CORRECT password is still locked
        $lockedResponse = $this->post('/login', [
            'username' => 'targetuser',
            'password' => 'CorrectP@ssword123!',
        ]);

        $lockedResponse->assertSessionHas('is_locked', true);
        $this->assertGuest();
    }

    /**
     * Test per-user rate limiting prevents brute force across rotating IP addresses.
     */
    public function test_login_throttles_target_account_across_multiple_ips(): void
    {
        User::factory()->create([
            'username' => 'victimuser',
            'password' => Hash::make('CorrectP@ssword123!'),
        ]);

        // 5 failed attempts from 5 distinct IP addresses
        for ($i = 1; $i <= 5; $i++) {
            $this->withServerVariables(['REMOTE_ADDR' => "10.0.1.{$i}"])
                ->post('/login', [
                    'username' => 'victimuser',
                    'password' => "wrong_pass_{$i}",
                ]);
        }

        // 6th attempt from a brand new IP address must still be blocked
        $responseFromNewIp = $this->withServerVariables(['REMOTE_ADDR' => '172.16.0.99'])
            ->post('/login', [
                'username' => 'victimuser',
                'password' => 'CorrectP@ssword123!',
            ]);

        $responseFromNewIp->assertSessionHas('is_locked', true);
        $this->assertGuest();
    }

    /**
     * Test successful login clears the failed attempts rate limiter.
     */
    public function test_successful_login_resets_rate_limiter(): void
    {
        $user = User::factory()->create([
            'username' => 'validuser',
            'password' => Hash::make('B@liT0urs#2026!'),
        ]);

        // 1 failed attempt
        $this->post('/login', [
            'username' => 'validuser',
            'password' => 'wrongpassword',
        ]);

        // Subsequent valid login
        $response = $this->post('/login', [
            'username' => 'validuser',
            'password' => 'B@liT0urs#2026!',
        ]);

        $response->assertRedirect('/user/dashboard');
        $this->assertAuthenticatedAs($user);
    }
}
