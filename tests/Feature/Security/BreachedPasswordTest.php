<?php

namespace Tests\Feature\Security;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BreachedPasswordTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test registration rejects known breached passwords (e.g. 'password123').
     */
    public function test_registration_rejects_breached_passwords(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'username' => 'juantest',
            'mobile_number' => '09170000000',
            'barangay' => 'Poblacion',
            'email' => 'juan.test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('password');
    }

    /**
     * Test registration accepts secure uncompromised password.
     */
    public function test_registration_accepts_uncompromised_password(): void
    {
        $response = $this->post('/register', [
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'username' => 'juansecure',
            'mobile_number' => '09170000000',
            'barangay' => 'Poblacion',
            'email' => 'juan.secure@example.com',
            'password' => 'X9#vL$8qP!M2vR99',
            'password_confirmation' => 'X9#vL$8qP!M2vR99',
        ]);

        $response->assertRedirect('/user/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'juan.secure@example.com',
        ]);
    }
}
