<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class AuthRateLimitingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('test@example.com|127.0.0.1');
        RateLimiter::clear('login_ip|127.0.0.1');
    }

    public function test_login_throttles_tier_one_after_five_failed_attempts(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('B@liT0urs#2026!P@ss'),
        ]);

        // Failed attempts 1 to 5
        for ($i = 1; $i <= 5; $i++) {
            $response = $this->post('/login', [
                'login' => 'test@example.com',
                'password' => "wrong-password-{$i}",
            ]);
            $response->assertSessionHasErrors('login');
        }

        // Attempt 6: Locked out (Tier 1 lockout - 3 minutes)
        $response6 = $this->post('/login', [
            'login' => 'test@example.com',
            'password' => 'B@liT0urs#2026!P@ss',
        ]);

        $response6->assertSessionHasErrors('login');
        $errors = session('errors')->get('login');
        $this->assertStringContainsString('Too many failed login attempts', $errors[0]);
    }

    public function test_login_throttles_tier_two_after_ten_failed_attempts(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('B@liT0urs#2026!P@ss'),
        ]);

        // Failed attempts 1 to 10
        for ($i = 1; $i <= 10; $i++) {
            $this->post('/login', [
                'login' => 'test@example.com',
                'password' => "wrong-password-{$i}",
            ]);
        }

        // Attempt 11: Locked out (Tier 2 lockout - 10 minutes)
        $response11 = $this->post('/login', [
            'login' => 'test@example.com',
            'password' => 'B@liT0urs#2026!P@ss',
        ]);

        $response11->assertSessionHasErrors('login');
        $errors = session('errors')->get('login');
        $this->assertStringContainsString('Too many failed login attempts', $errors[0]);
    }

    public function test_login_throttles_ip_only_password_spraying_attempts(): void
    {
        // Attacker cycles through 50 different email addresses from 1 IP
        for ($i = 1; $i <= 50; $i++) {
            $this->post('/login', [
                'login' => "victim_{$i}@example.com",
                'password' => 'CommonPassword123',
            ]);
        }

        // Attempt 51: IP-only Password Spraying Lockout triggered (15 minutes)
        $response51 = $this->post('/login', [
            'login' => 'new.victim@example.com',
            'password' => 'CommonPassword123',
        ]);

        $response51->assertSessionHasErrors('login');
        $errors = session('errors')->get('login');
        $this->assertStringContainsString('Too many total login attempts from this IP address', $errors[0]);
    }

    public function test_successful_login_clears_rate_limiter(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('B@liT0urs#2026!P@ss'),
        ]);

        // Attempt 1: Failed
        $this->post('/login', [
            'login' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        // Attempt 2: Successful
        $response = $this->post('/login', [
            'login' => 'test@example.com',
            'password' => 'B@liT0urs#2026!P@ss',
        ]);

        $response->assertRedirect('/user/dashboard');
        $this->assertAuthenticatedAs($user);
    }
}
