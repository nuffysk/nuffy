<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    /**
     * One-time step for Google-OAuth users: birth year (18+) + consents.
     */
    public function show(): View|RedirectResponse
    {
        if (Auth::user()->birth_year !== null) {
            return redirect()->route('home');
        }

        return view('auth.onboarding');
    }

    public function store(Request $request): RedirectResponse
    {
        $maxYear = (int) now()->year - 18;

        $request->validate([
            'birth_year' => ['required', 'integer', 'min:1900', 'max:'.$maxYear],
            'agree_terms' => ['accepted'],
            'agree_privacy' => ['accepted'],
        ], [
            'birth_year.max' => 'Aplikáciu môžu používať iba osoby od 18 rokov.',
            'birth_year.required' => 'Zadaj svoj rok narodenia.',
            'agree_terms.accepted' => 'Pre pokračovanie musíš súhlasiť s podmienkami.',
            'agree_privacy.accepted' => 'Pre pokračovanie musíš súhlasiť so spracovaním osobných údajov.',
        ]);

        $user = Auth::user();
        $user->birth_year = (int) $request->input('birth_year');
        $user->save();

        return redirect()->route('home')->with('status', 'Vitaj v Ňuffy! 🐾');
    }
}
