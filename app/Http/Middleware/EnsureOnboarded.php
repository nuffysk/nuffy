<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureOnboarded
{
    /**
     * Users created via Google OAuth skip the registration form, so they have
     * no birth year (18+ gate) and never confirmed the terms. Send them to a
     * one-time onboarding step before they can use the app.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->birth_year === null && ! $request->routeIs(
            'onboarding.*', 'logout', 'gate.*', 'terms', 'privacy', 'cookies', 'support',
            'verification.*',
        )) {
            return redirect()->route('onboarding.show');
        }

        return $next($request);
    }
}
