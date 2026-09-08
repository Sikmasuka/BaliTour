<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. GLOBAL PASSWORD SECURITY RULES
        // Requires minimum 8 characters and checks against compromised/leaked password databases.
        Password::defaults(function () {
            return Password::min(8)->uncompromised();
        });

        // 2. PER-USER LOGIN ROUTE LIMITER
        // Allows a burst ceiling of 20 req/min per username to stop automated flood attacks,
        // while the Controller enforces the progressive 5-try lockout & countdown UI.
        RateLimiter::for('login', function (Request $request) {
            $username = $request->input('username');
            $identifier = $username
                ? Str::transliterate(Str::lower($username))
                : ($request->session()->getId() ?? $request->ip());

            return Limit::perMinute(20)->by($identifier);
        });

        // 3. REGISTRATION ROUTE LIMITER (DUAL-LAYER: IDENTITY + CLIENT IP)
        // Limits registration per identity and per IP address to block botnet spam and rotating emails.
        RateLimiter::for('register', function (Request $request) {
            $identity = $request->input('email')
                ?? $request->input('username')
                ?? ($request->session()->getId() ?? $request->ip());

            return [
                Limit::perMinute(20)->by(Str::transliterate(Str::lower($identity))),
                Limit::perMinute(10)->by($request->ip()),
            ];
        });
    }
}
