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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    /**
     * Handle an incoming authentication request using the users table with per-user rate limiting.
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        // Per-User Progressive Rate Limiter (Targeted Account Brute-Force & Credential Stuffing Defense)
        // Keyed strictly per user/login identity so brute-force attempts across rotating IPs are effectively blocked.
        // Tier 1: 5 failed attempts -> 3 minutes (180s) lockout.
        // Tier 2: 10 failed attempts -> 10 minutes (600s) extended lockout.
        $throttleKey = $this->throttleKey($credentials['username']);
        $currentAttempts = RateLimiter::attempts($throttleKey);
        $maxAttempts = $currentAttempts >= 10 ? 10 : 5;
        $decaySeconds = $currentAttempts >= 10 ? 600 : 180;

        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            Log::channel('security')->warning('AUTH_LOCKOUT_BLOCKED', [
                'username'  => $credentials['username'],
                'ip'        => $request->ip(),
                'locked_for_seconds' => $seconds,
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'locked' => true,
                    'lockout_seconds' => $seconds,
                    'message' => 'Account temporarily locked.',
                ], 429);
            }

            return back()->withErrors([
                'login_error' => 'Account temporarily locked.',
                'username' => 'Account locked.',
            ])->with('lockout_seconds', $seconds)
              ->with('is_locked', true)
              ->onlyInput('username');
        }

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            RateLimiter::clear($throttleKey);

            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();
            $user->update(['last_login_at' => now()]);

            Log::channel('security')->info('AUTH_LOGIN_SUCCESS', [
                'user_id'    => $user->id,
                'username'   => $user->username,
                'role'       => $user->role,
                'ip'         => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            $userName = $user->profile?->first_name ?? $user->username;
            $redirectUrl = $user->role === 'admin' ? '/admin/dashboard' : '/user/dashboard';
            $roleLabel = $user->role === 'admin' ? 'Administrator' : 'Tourist';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => $redirectUrl,
                    'title' => $user->role === 'admin' ? 'Welcome Back, Admin!' : "Welcome Back, {$userName}!",
                    'message' => 'Authenticated successfully. Preparing your dashboard...',
                    'user' => [
                        'name' => $userName,
                        'role' => $roleLabel,
                        'username' => $user->username,
                    ],
                ]);
            }

            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard')->with('auth_success', [
                    'title' => 'Welcome Back, Admin!',
                    'message' => "Signed in successfully as {$user->username}. Administrative controls are now accessible.",
                    'name' => $userName,
                    'role' => 'Administrator'
                ]);
            }

            return redirect()->intended('/user/dashboard')->with('auth_success', [
                'title' => 'Welcome Back!',
                'message' => "Glad to see you, {$userName}! Enjoy exploring Balingasag's attractions, tours, and events.",
                'name' => $userName,
                'role' => 'Tourist'
            ]);
        }

        RateLimiter::hit($throttleKey, $decaySeconds);

        $attemptsAfter = RateLimiter::attempts($throttleKey);

        Log::channel('security')->warning('AUTH_LOGIN_FAILED', [
            'username' => $credentials['username'],
            'ip'       => $request->ip(),
            'attempts' => $attemptsAfter,
        ]);

        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            Log::channel('security')->warning('AUTH_ACCOUNT_LOCKED', [
                'username'           => $credentials['username'],
                'ip'                 => $request->ip(),
                'locked_for_seconds' => $seconds,
                'total_attempts'     => $attemptsAfter,
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'locked' => true,
                    'lockout_seconds' => $seconds,
                    'message' => 'Account temporarily locked.',
                ], 429);
            }

            return back()->withErrors([
                'login_error' => 'Account temporarily locked.',
                'username' => 'Account locked.',
            ])->with('lockout_seconds', $seconds)
              ->with('is_locked', true)
              ->onlyInput('username');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Credentials incorrect.',
            ], 422);
        }

        return back()->withErrors([
            'login_error' => 'Credentials incorrect.',
            'username' => 'Credentials incorrect.',
        ])->onlyInput('username');
    }

    /**
     * Get the rate limiting throttle key for the given user login identifier.
     */
    protected function throttleKey(string $login): string
    {
        return Str::transliterate(Str::lower($login));
    }


    /**
     * Handle an incoming registration request and store user in the users table and tourist profile.
     */
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = DB::transaction(function () use ($validated) {
            $user = User::create([
                'username' => $validated['username'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => 'tourist',
                'status'   => 'active',
            ]);

            TouristProfile::create([
                'user_id'           => $user->id,
                'first_name'        => $validated['first_name'],
                'middle_name'       => $validated['middle_name'] ?? null,
                'last_name'         => $validated['last_name'],
                'mobile_number'     => $validated['mobile_number'],
                'city_municipality' => 'Balingasag',
                'province'          => 'Misamis Oriental',
                'barangay'          => $validated['barangay'],
            ]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        Log::channel('security')->info('AUTH_REGISTER_SUCCESS', [
            'user_id'    => $user->id,
            'username'   => $user->username,
            'email'      => $user->email,
            'ip'         => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'redirect' => '/user/dashboard',
                'title' => 'Account Created Successfully!',
                'message' => "Welcome to BaliTour, {$validated['first_name']}! Preparing your traveler dashboard...",
                'user' => [
                    'name' => $validated['first_name'],
                    'role' => 'Tourist',
                    'username' => $user->username,
                ],
            ]);
        }

        return redirect('/user/dashboard')->with('auth_success', [
            'title' => 'Account Created Successfully!',
            'message' => "Welcome to BaliTour, {$validated['first_name']}! Your traveler account is ready to explore.",
            'name' => $validated['first_name'],
            'role' => 'Tourist'
        ]);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();

        Log::channel('security')->info('AUTH_LOGOUT', [
            'user_id'  => $user?->id,
            'username' => $user?->username,
            'ip'       => $request->ip(),
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully.',
                'redirect' => url('/'),
            ]);
        }

        return redirect('/');
    }
}

