<?php

namespace Tests\Feature\Security;

use App\Models\TouristDestination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class XssProtectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_script_tag_in_destination_description_is_escaped_when_rendered(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $destination = TouristDestination::factory()->create([
            'created_by' => $admin->id,
            'name' => 'Safe Beach Resort',
            'slug' => 'safe-beach-resort',
            'short_description' => '<script>alert("xss-short")</script>',
            'description' => "<script>alert('xss-description')</script>\nLine two of description",
            'is_published' => true,
        ]);

        $response = $this->get(route('destinations.show', $destination->slug));

        $response->assertStatus(200);
        // Ensure raw script tag is NOT in the response
        $response->assertDontSee('<script>alert(\'xss-description\')</script>', false);
        $response->assertDontSee('<script>alert("xss-short")</script>', false);
        // Ensure it is properly HTML-entity escaped
        $response->assertSee('&lt;script&gt;alert(&#039;xss-description&#039;)&lt;/script&gt;', false);
    }

    public function test_img_onerror_in_review_is_escaped_in_blade_output(): void
    {
        $user = User::factory()->create(['role' => 'tourist']);
        $admin = User::factory()->create(['role' => 'admin']);
        $destination = TouristDestination::factory()->create([
            'created_by' => $admin->id,
            'is_published' => true,
        ]);

        $xssComment = '<img src="invalid-image" onerror="alert(document.cookie)"> Nice place!';
        
        $this->actingAs($user)->post(route('destinations.reviews.store', $destination->slug), [
            'rating' => 5,
            'title' => '<script>alert("xss-title")</script>',
            'comment' => $xssComment,
        ]);

        $response = $this->get(route('destinations.show', $destination->slug));

        $response->assertStatus(200);
        // Verify that unescaped dangerous payload is NOT rendered
        $response->assertDontSee('<img src="invalid-image" onerror="alert(document.cookie)">', false);
        $response->assertDontSee('<script>alert("xss-title")</script>', false);
        // Verify that HTML special characters are escaped
        $response->assertSee('&lt;img src=&quot;invalid-image&quot; onerror=&quot;alert(document.cookie)&quot;&gt;', false);
    }
}
