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
        $response->headers->set('Content-Security-Policy', "frame-ancestors 'self'");
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(self)');
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');

        // Enforce HTTPS in production or HTTPS environments
        if ($request->isSecure()) {
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
