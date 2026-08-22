<?php

namespace Tests\Feature\Security;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClickjackingProtectionTest extends TestCase
{
    use RefreshDatabase;

    // -----------------------------------------------------------------------
    // X-Frame-Options Tests
    // -----------------------------------------------------------------------

    /**
     * The homepage must carry the X-Frame-Options: SAMEORIGIN header so that
     * legacy browsers refuse to embed the page inside a cross-origin <iframe>.
     */
    public function test_homepage_has_x_frame_options_header(): void
    {
        $response = $this->get('/');

        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    }

    /**
     * Every public tourist-facing route must also be protected.
     * The explore-places page is the highest-risk page because it accepts
     * user interaction (GPS, map clicks, search) that could be hijacked.
     */
    public function test_explore_places_page_has_x_frame_options_header(): void
    {
        $response = $this->get('/explore-places');

        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    }

    // -----------------------------------------------------------------------
    // Content-Security-Policy frame-ancestors Tests
    // -----------------------------------------------------------------------

    /**
     * The homepage must carry a CSP frame-ancestors directive.
     * This is the modern W3C standard that supersedes X-Frame-Options in
     * CSP-aware browsers (Chrome, Firefox, Edge).
     */
    public function test_homepage_has_csp_frame_ancestors_header(): void
    {
        $response = $this->get('/');

        $response->assertHeader('Content-Security-Policy', "frame-ancestors 'self'");
    }

    /**
     * The explore-places page must also carry the CSP frame-ancestors header
     * because it contains interactive map elements that are prime targets
     * for UI redressing / clickjacking attacks.
     */
    public function test_explore_places_page_has_csp_frame_ancestors_header(): void
    {
        $response = $this->get('/explore-places');

        $response->assertHeader('Content-Security-Policy', "frame-ancestors 'self'");
    }

    // -----------------------------------------------------------------------
    // Defence-in-depth: Companion Security Headers
    // -----------------------------------------------------------------------

    /**
     * Ensures MIME-type sniffing is disabled. Without this an attacker could
     * trick a browser into executing an uploaded image as JavaScript.
     */
    public function test_homepage_has_x_content_type_options_nosniff(): void
    {
        $response = $this->get('/');

        $response->assertHeader('X-Content-Type-Options', 'nosniff');
    }

    /**
     * Ensures the Referrer-Policy is set so that sensitive URL parameters
     * (search queries, destination IDs, etc.) are not leaked to third-party
     * sites via the Referer request header.
     */
    public function test_homepage_has_referrer_policy_header(): void
    {
        $response = $this->get('/');

        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    // -----------------------------------------------------------------------
    // All four headers together on a single request
    // -----------------------------------------------------------------------

    /**
     * Asserts all four security headers are present in a single request.
     * This is the canonical "smoke test" that will catch a misconfiguration
     * or accidental removal of the SecureHeaders middleware from the pipeline.
     */
    public function test_all_secure_headers_present_on_homepage(): void
    {
        $response = $this->get('/');

        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Content-Security-Policy', "frame-ancestors 'self'");
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    // -----------------------------------------------------------------------
    // Authenticated routes (admin & user dashboard)
    // -----------------------------------------------------------------------

    /**
     * Even unauthenticated access to a protected admin route (which issues a
     * redirect) must still return the security headers — headers must appear
     * on EVERY response, including redirects.
     */
    public function test_admin_redirect_response_still_has_security_headers(): void
    {
        // Not logged in — Laravel will redirect to login
        $response = $this->get('/admin/dashboard');

        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Content-Security-Policy', "frame-ancestors 'self'");
    }
}
