<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $maxYear = (int) now()->year - 16;
        $request->validate([
            'name' => ['required', 'string', 'max:60'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::min(8)],
            'birth_year' => ['required', 'integer', 'min:1900', 'max:'.$maxYear],
            'agree_terms' => ['accepted'],
            'agree_privacy' => ['accepted'],
        ], [
            'birth_year.max' => 'Aplikáciu môžu používať iba osoby od 16 rokov.',
            'birth_year.required' => 'Zadaj svoj rok narodenia.',
            'agree_terms.accepted' => 'Pre dokončenie registrácie musíš súhlasiť s podmienkami.',
            'agree_privacy.accepted' => 'Pre dokončenie registrácie musíš súhlasiť so spracovaním osobných údajov.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'display_name' => $request->name,
            'email' => $request->email,
            'birth_year' => $request->birth_year,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
