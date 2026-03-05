<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || (!Auth::user()->isStaff() && !Auth::user()->isAdmin())) {
            abort(403, 'Unauthorized. Staff or Admin access required.');
        }

        // Admins bypass timing restrictions
        if (Auth::user()->isAdmin()) {
            return $next($request);
        }

        // Check if staff timing restriction is enabled
        if (Setting::get('staff_timing_enabled', '0') === '1') {
            $now = Carbon::now('Asia/Kolkata');
            $openingTime = Carbon::createFromFormat('H:i', Setting::get('staff_opening_time', '09:00'), 'Asia/Kolkata');
            $closingTime = Carbon::createFromFormat('H:i', Setting::get('staff_closing_time', '18:00'), 'Asia/Kolkata');

            if ($now->lt($openingTime) || $now->gte($closingTime)) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors([
                    'email' => 'Staff access is only allowed between ' . $openingTime->format('h:i A') . ' and ' . $closingTime->format('h:i A') . '.',
                ]);
            }
        }

        return $next($request);
    }
}
