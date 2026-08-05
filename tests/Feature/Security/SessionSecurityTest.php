<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SessionSecurityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test AuthenticateSession middleware invalidates stolen/other device sessions when password changes.
     */
    public function test_authenticate_session_invalidates_other_device_sessions(): void
    {
        $user = User::factory()->create([
            'email' => 'juan.session@example.com',
            'password' => Hash::make('B@liT0urs#2026!P@ss'),
        ]);

        // Simulate Session A (Device 1)
        $this->actingAs($user);
        $responseA = $this->get('/user/dashboard');
        $responseA->assertStatus(200);

        // User updates password / logs out other devices
        $user->update([
            'password' => Hash::make('NewB@liT0urs#2026!P@ss'),
        ]);

        // Request using old session hash should be redirected to login because session was invalidated
        $responseStolen = $this->get('/user/dashboard');
        $responseStolen->assertRedirect('/login');
    }

    /**
     * Test session ID is regenerated upon authentication to prevent Session Fixation attacks.
     */
    public function test_session_id_is_regenerated_on_login_to_prevent_session_fixation(): void
    {
        $user = User::factory()->create([
            'email' => 'juan.fixation@example.com',
            'password' => Hash::make('B@liT0urs#2026!P@ss'),
        ]);

        $this->get('/login');
        $oldSessionId = session()->getId();

        $response = $this->post('/login', [
            'login' => 'juan.fixation@example.com',
            'password' => 'B@liT0urs#2026!P@ss',
        ]);

        $newSessionId = session()->getId();

        $this->assertNotEquals($oldSessionId, $newSessionId);
        $response->assertRedirect('/user/dashboard');
    }
}
