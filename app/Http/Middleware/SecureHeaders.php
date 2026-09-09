<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureHeaders
{
    /**
     * HTTP security headers applied to every response.
     *
     * X-Frame-Options      – legacy clickjacking guard (broad browser support).
     * Content-Security-Policy frame-ancestors – modern clickjacking guard; overrides
     *                        X-Frame-Options in CSP-aware browsers.
     * X-Content-Type-Options – prevents MIME-type sniffing attacks.
     * Referrer-Policy      – limits referrer information leaked to third parties.
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(self)');
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');
        $response->headers->set('X-XSS-Protection', '0');

        // Content Security Policy allowing required assets (Leaflet, OpenStreetMap, ESRI, OSRM, Google Fonts, Alpine, Unsplash)
        $cspDirectives = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://unpkg.com https://cdn.jsdelivr.net",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://unpkg.com",
            "font-src 'self' https://fonts.gstatic.com data:",
            "img-src 'self' data: blob: https://images.unsplash.com https://*.tile.openstreetmap.org https://server.arcgisonline.com",
            "connect-src 'self' https://router.project-osrm.org https://photon.komoot.io https://*.tile.openstreetmap.org https://server.arcgisonline.com",
            "media-src 'self' data: blob: https://images.unsplash.com",
            "frame-ancestors 'self'",
        ];
        $response->headers->set('Content-Security-Policy', implode('; ', $cspDirectives));

        // Enforce HTTPS HSTS in production or when connection is secure
        if ($request->isSecure() || app()->isProduction()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        // Remove technology & server disclosure headers
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        if (function_exists('header_remove')) {
            header_remove('X-Powered-By');
            header_remove('Server');
        }

        return $response;
    }
}
