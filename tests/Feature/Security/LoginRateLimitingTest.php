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

    /**
     * Test lockout of one user does not affect another innocent user on the same IP address.
     */
    public function test_login_lockout_on_one_user_does_not_affect_another_user_on_same_ip(): void
    {
        $userLocked = User::factory()->create([
            'username' => 'baduser',
            'password' => Hash::make('CorrectP@ssword123!'),
        ]);

        $userInnocent = User::factory()->create([
            'username' => 'gooduser',
            'password' => Hash::make('GoodP@ssword123!'),
        ]);

        // baduser fails 5 times and gets locked
        for ($i = 1; $i <= 5; $i++) {
            $this->post('/login', [
                'username' => 'baduser',
                'password' => 'wrongpassword',
            ]);
        }

        // baduser is locked
        $badUserResponse = $this->post('/login', [
            'username' => 'baduser',
            'password' => 'CorrectP@ssword123!',
        ]);
        $badUserResponse->assertSessionHas('is_locked', true);
        $this->assertGuest();

        // gooduser on the exact same IP logs in without any issue
        $goodUserResponse = $this->post('/login', [
            'username' => 'gooduser',
            'password' => 'GoodP@ssword123!',
        ]);
        $goodUserResponse->assertRedirect('/user/dashboard');
        $this->assertAuthenticatedAs($userInnocent);
    }

    /**
     * Test progressive attempt warning displays remaining attempts on consecutive failures.
     */
    public function test_login_displays_remaining_attempts_warning(): void
    {
        RateLimiter::clear('warnuser');

        User::factory()->create([
            'username' => 'warnuser',
            'password' => Hash::make('CorrectP@ssword123!'),
        ]);

        // Attempt 1: Standard error message
        $res1 = $this->postJson('/login', [
            'username' => 'warnuser',
            'password' => 'wrongpass1',
        ]);
        $res1->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'These credentials do not match our records.',
                'remaining_attempts' => 4,
                'is_warning' => false,
            ]);

        // Attempt 2: Standard error message
        $this->postJson('/login', [
            'username' => 'warnuser',
            'password' => 'wrongpass2',
        ]);

        // Attempt 3: Warning message (2 attempts remaining)
        $res3 = $this->postJson('/login', [
            'username' => 'warnuser',
            'password' => 'wrongpass3',
        ]);
        $res3->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'These credentials do not match our records. 2 attempts remaining before temporary lockout.',
                'remaining_attempts' => 2,
                'is_warning' => true,
            ]);

        // Attempt 4: Warning message (1 attempt remaining)
        $res4 = $this->postJson('/login', [
            'username' => 'warnuser',
            'password' => 'wrongpass4',
        ]);
        $res4->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'These credentials do not match our records. 1 attempt remaining before temporary lockout.',
                'remaining_attempts' => 1,
                'is_warning' => true,
            ]);
    }
}
