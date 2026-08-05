<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SqlInjectionDefenseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test SQL injection payload in login field is safely parameterized by PDO.
     */
    public function test_login_safely_parameterizes_sql_injection_payloads(): void
    {
        $user = User::factory()->create([
            'email' => 'legit.user@example.com',
            'password' => Hash::make('B@liT0urs#2026!P@ss'),
        ]);

        // Classic SQLi payloads trying to bypass auth
        $sqlPayloads = [
            "' OR '1'='1",
            "admin' --",
            "' OR 1=1 --",
            "legit.user@example.com' UNION SELECT NULL, NULL, NULL--",
            "'; DROP TABLE users; --",
        ];

        foreach ($sqlPayloads as $payload) {
            $response = $this->post('/login', [
                'login' => $payload,
                'password' => 'B@liT0urs#2026!P@ss',
            ]);

            $this->assertGuest();
            $response->assertSessionHasErrors('login');
        }

        // Verify users table remains intact and unmodified
        $this->assertDatabaseHas('users', [
            'email' => 'legit.user@example.com',
        ]);
    }

    /**
     * Test SQL injection payload in registration fields is safely parameterized and stored as literal string.
     */
    public function test_registration_safely_parameterizes_sql_payloads(): void
    {
        $response = $this->post('/register', [
            'first_name' => "Robert'; DROP TABLE users; --",
            'last_name' => 'O\'Connor',
            'mobile_number' => '09179998888',
            'barangay' => "Poblacion' OR '1'='1",
            'email' => 'sqli.test@example.com',
            'password' => 'B@liT0urs#2026!P@ss',
            'password_confirmation' => 'B@liT0urs#2026!P@ss',
        ]);

        $response->assertRedirect('/user/dashboard');

        // Verify database safely stored the string value literally without executing SQL statements
        $this->assertDatabaseHas('tourist_profiles', [
            'first_name' => "Robert'; DROP TABLE users; --",
            'last_name' => "O'Connor",
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'sqli.test@example.com',
        ]);
    }
}
