<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View { return view('settings.index'); }
    public function account(): View { return view('settings.account'); }
    public function emailForm(): View { return view('settings.email'); }
    public function passwordForm(): View { return view('settings.password'); }
    public function notifications(): View { return view('settings.notifications'); }
    public function blocked(): View { return view('settings.blocked'); }

    public function updateEmail(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.Auth::id()],
            'password' => ['required', 'current_password'],
        ]);
        $user = Auth::user();
        $user->email = $data['email'];
        $user->email_verified_at = null;
        $user->save();
        return back()->with('status', 'Email zmenený.');
    }

    public function sendPasswordReset(Request $request): RedirectResponse
    {
        $status = Password::sendResetLink(['email' => Auth::user()->email]);
        return back()->with('status',
            $status === Password::ResetLinkSent
                ? 'Link na zmenu hesla sme poslali na tvoj email.'
                : 'Nepodarilo sa odoslať link. Skús to znova.'
        );
    }

    public function export(): JsonResponse
    {
        $user = Auth::user()->load([
            'dogs', 'posts', 'sentMessages', 'receivedMessages',
            'friendshipsAsRequester', 'friendshipsAsAddressee', 'appRoles',
        ]);
        return response()->json($user->toArray())
            ->header('Content-Disposition', 'attachment; filename=nuffy-export-'.now()->format('Y-m-d').'.json');
    }

    public function deleteAccount(Request $request): RedirectResponse
    {
        $request->validate(['password' => ['required', 'current_password']]);
        $user = Auth::user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('status', 'Účet bol zmazaný.');
    }
}
