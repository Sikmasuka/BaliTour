<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\TouristProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Display the login view.
     */
    public function showLoginForm()
    {
        return view('login_with_register');
    }

    /**
     * Handle an incoming authentication request using the users table with rate limiting throttle.
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        // 1. Layer 1: IP-Only Rate Limiter (Password Spraying Defense)
        // Restricts total failed login requests from a single IP across all account emails (Max 50 attempts per 15 minutes)
        $ipThrottleKey = 'login_ip|'.$request->ip();
        $maxIpAttempts = 50;
        $ipDecaySeconds = 900; // 15 minutes

        if (RateLimiter::tooManyAttempts($ipThrottleKey, $maxIpAttempts)) {
            $seconds = RateLimiter::availableIn($ipThrottleKey);
            $minutes = (int) ceil($seconds / 60);

            return back()->withErrors([
                'login' => "Too many total login attempts from this IP address (Password Spraying Defense). Please try again in {$seconds} seconds ({$minutes} min).",
            ])->onlyInput('login');
        }

        // 2. Layer 2: Email + IP Progressive Rate Limiter (Targeted Account Brute-Force Defense)
        // Tier 1: 5 failed attempts -> 3 minutes (180s) lockout.
        // Tier 2: 10 failed attempts -> 10 minutes (600s) extended lockout.
        $throttleKey = Str::transliterate(Str::lower($credentials['login']).'|'.$request->ip());
        $currentAttempts = RateLimiter::attempts($throttleKey);
        $maxAttempts = $currentAttempts >= 10 ? 10 : 5;
        $decaySeconds = $currentAttempts >= 10 ? 600 : 180;

        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $minutes = (int) ceil($seconds / 60);

            return back()->withErrors([
                'login' => "Too many failed login attempts. Account temporarily locked for security. Please try again in {$seconds} seconds ({$minutes} min).",
            ])->onlyInput('login');
        }

        if (Auth::attempt(['email' => $credentials['login'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            RateLimiter::clear($ipThrottleKey);
            RateLimiter::clear($throttleKey);

            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();
            $user->update(['last_login_at' => now()]);

            return redirect()->intended('/user/dashboard');
        }

        RateLimiter::hit($ipThrottleKey, $ipDecaySeconds);
        RateLimiter::hit($throttleKey, $decaySeconds);

        $remaining = RateLimiter::remaining($throttleKey, $maxAttempts);
        $lockoutMin = (int) ($decaySeconds / 60);
        $errorMessage = $remaining > 0
            ? "The provided credentials do not match our records. You have {$remaining} attempt(s) remaining."
            : "The provided credentials do not match our records. Account is now locked for {$lockoutMin} minutes.";

        return back()->withErrors([
            'login' => $errorMessage,
        ])->onlyInput('login');
    }

    /**
     * Display the registration view.
     */
    public function showRegisterForm()
    {
        return view('register');
    }

    /**
     * Handle an incoming registration request and store user in the users table and tourist profile.
     */
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = DB::transaction(function () use ($validated) {
            $user = User::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'tourist',
                'status' => 'active',
            ]);

            TouristProfile::create([
                'user_id' => $user->id,
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'mobile_number' => $validated['mobile_number'],
                'city_municipality' => 'Balingasag',
                'province' => 'Misamis Oriental',
                'barangay' => $validated['barangay'],
            ]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/user/dashboard');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
