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

        return $response;
    }
}
