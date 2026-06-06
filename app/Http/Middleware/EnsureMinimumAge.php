<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureMinimumAge
{
    private const MIN_AGE = 16;

    /**
     * Mirrors paw AgeGate: users whose birth year implies an age below MIN_AGE
     * are signed out and shown the "Mrzí nás to." notice.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->birth_year) {
            $age = (int) date('Y') - (int) $user->birth_year;
            if ($age < self::MIN_AGE) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('home')->with('underage', true);
            }
        }

        return $next($request);
    }
}
