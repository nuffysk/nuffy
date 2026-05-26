<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleOAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')->withErrors(['email' => 'Google prihlásenie zlyhalo.']);
        }

        $email = $googleUser->getEmail();
        if (! $email) {
            return redirect()->route('login')->withErrors(['email' => 'Google účet nemá email.']);
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $googleUser->getName() ?: explode('@', $email)[0],
                'display_name' => $googleUser->getName() ?: explode('@', $email)[0],
                'avatar_url' => $googleUser->getAvatar(),
                'password' => bcrypt(Str::random(40)),
                'email_verified_at' => now(),
            ]
        );

        Auth::login($user, remember: true);
        return redirect()->intended(route('home'));
    }
}
