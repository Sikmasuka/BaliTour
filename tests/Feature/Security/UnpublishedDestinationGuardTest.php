<?php

namespace Tests\Feature\Security;

use App\Models\TouristDestination;
use App\Models\User;
use App\Services\DestinationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnpublishedDestinationGuardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test published destination is publicly viewable.
     */
    public function test_published_destination_is_viewable_publicly(): void
    {
        $destination = TouristDestination::factory()->create([
            'name' => 'Kabatanga Falls',
            'slug' => 'kabatanga-falls',
            'is_published' => true,
        ]);

        $response = $this->get("/destinations/{$destination->slug}");

        $response->assertStatus(200);
    }

    /**
     * Test unpublished destination returns 404 for unauthenticated guest.
     */
    public function test_unpublished_destination_returns_404_for_guest(): void
    {
        $destination = TouristDestination::factory()->create([
            'name' => 'Secret Hidden Draft Cave',
            'slug' => 'secret-hidden-draft-cave',
            'is_published' => false,
        ]);

        $response = $this->get("/destinations/{$destination->slug}");

        $response->assertStatus(404);
    }

    /**
     * Test unpublished destination returns 404 for logged-in tourist user.
     */
    public function test_unpublished_destination_returns_404_for_tourist(): void
    {
        $tourist = User::factory()->create([
            'role' => 'tourist',
        ]);

        $destination = TouristDestination::factory()->create([
            'name' => 'Draft Beach Resort',
            'slug' => 'draft-beach-resort',
            'is_published' => false,
        ]);

        $response = $this->actingAs($tourist)->get("/destinations/{$destination->slug}");

        $response->assertStatus(404);
    }

    /**
     * Test DestinationService findBySlug returns unpublished destination only when adminMode is true.
     */
    public function test_service_find_by_slug_respects_admin_mode(): void
    {
        $destination = TouristDestination::factory()->create([
            'name' => 'Admin Only Draft',
            'slug' => 'admin-only-draft',
            'is_published' => false,
        ]);

        $service = app(DestinationService::class);

        // Public query (default: adminMode = false) should return null
        $publicResult = $service->findBySlug('admin-only-draft', false);
        $this->assertNull($publicResult);

        // Admin query (adminMode = true) should successfully retrieve the model
        $adminResult = $service->findBySlug('admin-only-draft', true);
        $this->assertNotNull($adminResult);
        $this->assertEquals($destination->id, $adminResult->id);
    }
}
