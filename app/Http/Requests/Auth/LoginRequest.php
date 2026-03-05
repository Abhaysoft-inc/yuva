<?php

namespace App\Http\Requests\Auth;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // Block staff login outside allowed timing
        $user = Auth::user();
        if ($user && $user->isStaff() && !$user->isAdmin() && Setting::get('staff_timing_enabled', '0') === '1') {
            $now = Carbon::now('Asia/Kolkata');
            $openingTime = Carbon::createFromFormat('H:i', Setting::get('staff_opening_time', '09:00'), 'Asia/Kolkata');
            $closingTime = Carbon::createFromFormat('H:i', Setting::get('staff_closing_time', '18:00'), 'Asia/Kolkata');

            if ($now->lt($openingTime) || $now->gte($closingTime)) {
                Auth::guard('web')->logout();
                $this->session()->invalidate();
                $this->session()->regenerateToken();

                throw ValidationException::withMessages([
                    'email' => 'Staff login is only allowed between ' . $openingTime->format('h:i A') . ' and ' . $closingTime->format('h:i A') . '.',
                ]);
            }
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
