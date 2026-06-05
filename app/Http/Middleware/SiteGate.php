<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteGate
{
    /**
     * Beta access gate — requires a shared access password before the site is usable.
     * Disabled automatically when SITE_GATE_PASSWORD is empty.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $password = config('platform.gate_password');

        // Gate disabled (no password configured) or already unlocked.
        if (empty($password) || $request->session()->get('site_gate_unlocked')) {
            return $next($request);
        }

        // Allow the gate routes and the health check through.
        if ($request->is('gate', 'gate/*', 'up')) {
            return $next($request);
        }

        return redirect()->route('gate.show');
    }
}
