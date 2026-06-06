<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFactorController extends Controller
{
    private function engine(): Google2FA
    {
        return new Google2FA();
    }

    /* ---------------------------------------------------------------------
     | Settings — manage 2FA for the logged-in user
     * ------------------------------------------------------------------- */

    public function show(): View
    {
        $user = Auth::user();

        if ($user->two_factor_confirmed_at) {
            $status = 'on';
        } elseif ($user->two_factor_secret) {
            $status = 'enrolling';
        } else {
            $status = 'off';
        }

        $qr = null;
        $secret = null;
        if ($status === 'enrolling') {
            $secret = $user->two_factor_secret;
            $qr = $this->engine()->getQRCodeInline(
                config('app.name', 'Ňuffy'),
                $user->email,
                $secret,
            );
        }

        return view('settings.two-factor', compact('status', 'qr', 'secret'));
    }

    public function enable(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $user->two_factor_secret = $this->engine()->generateSecretKey();
        $user->two_factor_confirmed_at = null;
        $user->save();

        return redirect()->route('settings.two-factor');
    }

    public function confirm(Request $request): RedirectResponse
    {
        $request->validate(['code' => ['required', 'string']]);
        $user = Auth::user();

        if (! $user->two_factor_secret || ! $this->engine()->verifyKey($user->two_factor_secret, $request->input('code'))) {
            throw ValidationException::withMessages(['code' => 'Kód je nesprávny alebo expiroval.']);
        }

        $user->two_factor_confirmed_at = now();
        $user->save();

        return redirect()->route('settings.two-factor')->with('status', 'Dvojfaktorové overenie bolo zapnuté.');
    }

    public function disable(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $user->two_factor_secret = null;
        $user->two_factor_confirmed_at = null;
        $user->save();

        return redirect()->route('settings.two-factor');
    }

    /* ---------------------------------------------------------------------
     | Login challenge — second step after password during sign-in
     * ------------------------------------------------------------------- */

    public function challenge(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('login.id')) {
            return redirect()->route('login');
        }

        return view('auth.two-factor-challenge');
    }

    public function verifyChallenge(Request $request): RedirectResponse
    {
        $request->validate(['code' => ['required', 'string']]);

        $userId = $request->session()->get('login.id');
        $user = $userId ? User::find($userId) : null;

        if (! $user || ! $user->two_factor_secret) {
            return redirect()->route('login');
        }

        if (! $this->engine()->verifyKey($user->two_factor_secret, $request->input('code'))) {
            throw ValidationException::withMessages(['code' => 'Kód je nesprávny alebo expiroval.']);
        }

        $remember = (bool) $request->session()->pull('login.remember', false);
        $request->session()->forget('login.id');

        Auth::login($user, $remember);
        $request->session()->regenerate();

        return redirect()->intended(route('home', absolute: false));
    }
}
