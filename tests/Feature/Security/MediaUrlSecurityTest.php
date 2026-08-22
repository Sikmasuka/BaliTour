<?php

namespace Tests\Feature\Security;

use App\Models\TouristDestination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MediaUrlSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_image_urls_are_accepted_for_cover_image_and_gallery(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $payload = [
            'name' => 'Paradise Seashore',
            'category' => 'seashore',
            'address' => 'Barangay Baliwagan, Balingasag',
            'cover_image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e.jpg?auto=format&fit=crop',
            'gallery_urls' => [
                'https://cdn.example.com/images/beach1.png',
                'https://cdn.example.com/images/beach2.webp?width=800',
                'https://cdn.example.com/images/beach3.avif',
            ],
            'is_published' => true,
        ];

        $response = $this->actingAs($admin)
            ->postJson(route('admin.destinations.store'), $payload);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tourist_destinations', [
            'name' => 'Paradise Seashore',
            'cover_image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e.jpg?auto=format&fit=crop',
        ]);
        $this->assertDatabaseCount('destination_media', 3);
    }

    public function test_non_image_urls_are_rejected(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $payload = [
            'name' => 'Dangerous Site',
            'category' => 'other',
            'address' => 'Sample Address',
            'cover_image' => 'https://evil.example.com/exploit.php',
            'gallery_urls' => [
                'https://evil.example.com/malicious.js',
                'https://evil.example.com/hack.exe',
            ],
        ];

        $response = $this->actingAs($admin)
            ->post(route('admin.destinations.store'), $payload);

        $response->assertSessionHasErrors(['cover_image', 'gallery_urls.0', 'gallery_urls.1']);
    }

    public function test_javascript_protocol_is_rejected(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $payload = [
            'name' => 'JS Protocol Injection',
            'category' => 'cafe',
            'address' => 'Sample Address',
            'cover_image' => 'javascript:alert(document.domain)',
            'gallery_urls' => [
                'javascript:void(0)',
            ],
        ];

        $response = $this->actingAs($admin)
            ->post(route('admin.destinations.store'), $payload);

        $response->assertSessionHasErrors(['cover_image', 'gallery_urls.0']);
    }

    public function test_data_uri_scheme_is_rejected(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $payload = [
            'name' => 'Data URI Injection',
            'category' => 'cafe',
            'address' => 'Sample Address',
            'cover_image' => 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxzY3JpcHQ+YWxlcnQoMSk8L3NjcmlwdD48L3N2Zz4=',
        ];

        $response = $this->actingAs($admin)
            ->post(route('admin.destinations.store'), $payload);

        $response->assertSessionHasErrors(['cover_image']);
    }
}
