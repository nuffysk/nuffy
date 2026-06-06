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
        $user = Auth::user();
        $uid = $user->id;

        $payload = [
            'exported_at' => now()->toISOString(),
            'account' => ['id' => $uid, 'email' => $user->email],
            'profile' => $user->only([
                'display_name', 'city', 'avatar_url', 'gender', 'instagram',
                'with_dog_photos', 'bio', 'birth_year',
            ]),
            'roles' => \App\Models\UserRole::where('user_id', $uid)->get(),
            'dogs' => \App\Models\Dog::where('owner_id', $uid)->get(),
            'posts' => \App\Models\Post::where('author_id', $uid)->get(),
            'messages_sent' => \App\Models\Message::where('sender_id', $uid)->get(),
            'messages_received' => \App\Models\Message::where('receiver_id', $uid)->get(),
            'friendships' => \App\Models\Friendship::where('requester_id', $uid)
                ->orWhere('addressee_id', $uid)->get(),
            'sos_reports' => \App\Models\SosReport::where('reporter_id', $uid)->get(),
            'help_reports' => \App\Models\HelpReport::where('reporter_id', $uid)->get(),
            'learn_comments' => \App\Models\LearnComment::where('author_id', $uid)->get(),
            'learn_likes' => \Illuminate\Support\Facades\DB::table('learn_likes')->where('user_id', $uid)->get(),
            'place_suggestions' => \App\Models\PlaceSuggestion::where('user_id', $uid)->get(),
            'topic_requests' => \App\Models\TopicRequest::where('user_id', $uid)->get(),
        ];

        return response()->json($payload)
            ->header('Content-Disposition', 'attachment; filename=nuffy-moje-data-'.now()->format('Y-m-d').'.json');
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
