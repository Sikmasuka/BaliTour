<?php

namespace Tests\Feature\Security;

use App\Models\TouristDestination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class SecurityEventLoggingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('loguser');
        RateLimiter::clear('lockuser');
    }

    /**
     * Test successful authentication logs an info event to the security channel.
     */
    public function test_successful_login_logs_security_event(): void
    {
        Log::shouldReceive('channel')
            ->with('security')
            ->andReturnSelf();

        Log::shouldReceive('info')
            ->once()
            ->withArgs(function (string $event, array $context) {
                return $event === 'AUTH_LOGIN_SUCCESS'
                    && isset($context['user_id'], $context['username'], $context['role'], $context['ip']);
            });

        Log::shouldReceive('warning')->zeroOrMoreTimes();
        Log::shouldReceive('error')->zeroOrMoreTimes();

        $user = User::factory()->create([
            'username' => 'loguser',
            'password' => Hash::make('B@liT0urs#2026!'),
        ]);

        $this->post('/login', [
            'username' => 'loguser',
            'password' => 'B@liT0urs#2026!',
        ]);
    }

    /**
     * Test failed authentication attempts log a warning event to the security channel.
     */
    public function test_failed_login_logs_security_warning(): void
    {
        Log::shouldReceive('channel')
            ->with('security')
            ->andReturnSelf();

        Log::shouldReceive('warning')
            ->once()
            ->withArgs(function (string $event, array $context) {
                return $event === 'AUTH_LOGIN_FAILED'
                    && $context['username'] === 'unknownuser'
                    && isset($context['ip'], $context['attempts']);
            });

        Log::shouldReceive('info')->zeroOrMoreTimes();
        Log::shouldReceive('error')->zeroOrMoreTimes();

        $this->post('/login', [
            'username' => 'unknownuser',
            'password' => 'badpassword',
        ]);
    }

    /**
     * Test user registration logs an info event to the security channel.
     */
    public function test_registration_logs_security_event(): void
    {
        Log::shouldReceive('channel')
            ->with('security')
            ->andReturnSelf();

        Log::shouldReceive('info')
            ->once()
            ->withArgs(function (string $event, array $context) {
                return $event === 'AUTH_REGISTER_SUCCESS'
                    && isset($context['user_id'], $context['username'], $context['email'], $context['ip']);
            });

        Log::shouldReceive('warning')->zeroOrMoreTimes();
        Log::shouldReceive('error')->zeroOrMoreTimes();

        $this->post('/register', [
            'first_name'            => 'Security',
            'last_name'             => 'Auditor',
            'mobile_number'         => '09171239999',
            'barangay'              => 'Poblacion',
            'email'                 => 'auditor@example.com',
            'username'              => 'secauditor',
            'password'              => 'B@liT0urs#2026!',
            'password_confirmation' => 'B@liT0urs#2026!',
        ]);
    }

    /**
     * Test user logout logs an event to the security channel.
     */
    public function test_logout_logs_security_event(): void
    {
        Log::shouldReceive('channel')
            ->with('security')
            ->andReturnSelf();

        Log::shouldReceive('info')
            ->once()
            ->withArgs(function (string $event, array $context) {
                return $event === 'AUTH_LOGOUT'
                    && isset($context['user_id'], $context['username'], $context['ip']);
            });

        Log::shouldReceive('warning')->zeroOrMoreTimes();
        Log::shouldReceive('error')->zeroOrMoreTimes();

        $user = User::factory()->create();

        $this->actingAs($user)->post('/logout');
    }

    /**
     * Test admin destination creation emits an audit log to security channel.
     */
    public function test_admin_destination_creation_logs_audit_event(): void
    {
        Log::shouldReceive('channel')
            ->with('security')
            ->andReturnSelf();

        Log::shouldReceive('info')
            ->once()
            ->withArgs(function (string $event, array $context) {
                return $event === 'ADMIN_DESTINATION_CREATED'
                    && isset($context['admin_id'], $context['destination_id'], $context['destination_name'], $context['ip']);
            });

        Log::shouldReceive('warning')->zeroOrMoreTimes();
        Log::shouldReceive('error')->zeroOrMoreTimes();

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin)->post('/admin/destinations', [
            'name'         => 'Logged Nature Park',
            'description'  => 'A park created to verify audit logging.',
            'category'     => 'falls_nature',
            'address'      => 'Balingasag, Misamis Oriental',
            'latitude'     => 8.7450,
            'longitude'    => 124.7800,
            'is_published' => true,
        ]);
    }

    /**
     * Test admin destination deletion emits a warning audit log to security channel.
     */
    public function test_admin_destination_deletion_logs_audit_event(): void
    {
        Log::shouldReceive('channel')
            ->with('security')
            ->andReturnSelf();

        Log::shouldReceive('warning')
            ->once()
            ->withArgs(function (string $event, array $context) {
                return $event === 'ADMIN_DESTINATION_DELETED'
                    && isset($context['admin_id'], $context['destination_id'], $context['destination_name'], $context['ip']);
            });

        Log::shouldReceive('info')->zeroOrMoreTimes();
        Log::shouldReceive('error')->zeroOrMoreTimes();

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $destination = TouristDestination::factory()->create([
            'name' => 'Destination To Remove',
        ]);

        $this->actingAs($admin)->delete("/admin/destinations/{$destination->id}");
    }
}
