<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the rate limiting throttle key for this registration attempt.
     */
    public function throttleKey(): string
    {
        $identity = $this->input('email')
            ?? $this->input('username')
            ?? ($this->session()?->getId() ?? $this->ip());

        return Str::transliterate(Str::lower($identity));
    }

    /**
     * Prepare the data for validation and check for active lockout.
     */
    protected function prepareForValidation(): void
    {
        $throttleKey = $this->throttleKey();
        $currentAttempts = RateLimiter::attempts($throttleKey);
        $maxAttempts = $currentAttempts >= 10 ? 10 : 5;

        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            Log::channel('security')->warning('AUTH_REGISTER_LOCKED', [
                'identity' => $this->input('email') ?? $this->input('username') ?? $this->ip(),
                'ip' => $this->ip(),
                'locked_for_seconds' => $seconds,
            ]);

            if ($this->expectsJson()) {
                throw new HttpResponseException(
                    response()->json([
                        'success' => false,
                        'locked' => true,
                        'lockout_seconds' => $seconds,
                        'message' => 'Registration temporarily locked due to multiple failed attempts.',
                    ], 429)
                );
            }

            abort(429, 'Registration temporarily locked.');
        }
    }

    /**
     * Handle a failed validation attempt with progressive rate limiting.
     */
    protected function failedValidation(Validator $validator): void
    {
        $throttleKey = $this->throttleKey();
        $currentAttempts = RateLimiter::attempts($throttleKey);
        $decaySeconds = $currentAttempts >= 9 ? 600 : 180;
        $maxAttempts = $currentAttempts >= 9 ? 10 : 5;

        RateLimiter::hit($throttleKey, $decaySeconds);
        $attemptsAfter = RateLimiter::attempts($throttleKey);

        Log::channel('security')->warning('AUTH_REGISTER_FAILED', [
            'identity' => $this->input('email') ?? $this->input('username') ?? $this->ip(),
            'ip' => $this->ip(),
            'attempts' => $attemptsAfter,
        ]);

        if (RateLimiter::tooManyAttempts($throttleKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            Log::channel('security')->warning('AUTH_REGISTER_LOCKED', [
                'identity' => $this->input('email') ?? $this->input('username') ?? $this->ip(),
                'ip' => $this->ip(),
                'locked_for_seconds' => $seconds,
                'total_attempts' => $attemptsAfter,
            ]);

            if ($this->expectsJson()) {
                throw new HttpResponseException(
                    response()->json([
                        'success' => false,
                        'locked' => true,
                        'lockout_seconds' => $seconds,
                        'message' => 'Registration temporarily locked due to multiple failed attempts.',
                    ], 429)
                );
            }

            abort(429, 'Registration temporarily locked.');
        }

        $remaining = max(0, $maxAttempts - $attemptsAfter);
        $isWarning = $remaining <= 2 && $remaining > 0;

        if ($this->expectsJson()) {
            $errors = $validator->errors()->toArray();
            $firstErrorMessage = $validator->errors()->first();

            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => $isWarning
                        ? "{$firstErrorMessage} {$remaining} attempts remaining before temporary lockout."
                        : $firstErrorMessage,
                    'errors' => $errors,
                    'remaining_attempts' => $remaining,
                    'is_warning' => $isWarning,
                ], 422)
            );
        }

        parent::failedValidation($validator);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'mobile_number' => ['required', 'string', 'max:20'],
            'barangay' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'username' => ['required', 'string', 'lowercase', 'alpha_dash', 'min:3', 'max:30', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }
}
