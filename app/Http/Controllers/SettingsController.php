<?php

namespace App\Http\Controllers;

use App\Mail\AccountDeletionRequestMail;
use App\Mail\DataExportReadyMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /** Notification preference keys that map to the toggles on the settings page. */
    private const NOTIFICATION_KEYS = ['friend_requests', 'friend_accepted', 'sos', 'videos'];

    public function index(): View { return view('settings.index'); }
    public function account(): View { return view('settings.account'); }
    public function emailForm(): View { return view('settings.email'); }
    public function passwordForm(): View { return view('settings.password'); }
    public function notifications(): View { return view('settings.notifications'); }
    public function blocked(): View
    {
        $blocks = Auth::user()->blocks()->with('blocked:id,name,display_name,avatar_url,city')->latest()->get();

        return view('settings.blocked', compact('blocks'));
    }

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
        $user->sendEmailVerificationNotification();

        return back()->with('status', 'Email zmenený. Over si novú adresu cez odkaz, ktorý sme ti poslali.');
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

    /**
     * Save which e-mail notifications the user wants to receive.
     */
    public function updateNotifications(Request $request): RedirectResponse
    {
        $prefs = [];
        foreach (self::NOTIFICATION_KEYS as $key) {
            $prefs[$key] = $request->boolean($key);
        }

        $user = Auth::user();
        $user->notification_prefs = $prefs;
        $user->save();

        return back()->with('status', 'Notifikácie uložené.');
    }

    /**
     * Web GDPR export — downloads the JSON immediately AND e-mails the user a
     * 24-hour link to the same export (per the design).
     */
    public function export(): JsonResponse
    {
        $user = Auth::user();

        $url = URL::temporarySignedRoute(
            'settings.export.download',
            now()->addHours(24),
            ['user' => $user->id],
        );
        Mail::to($user->email)->send(new DataExportReadyMail($url));

        return $this->exportResponse($user);
    }

    /**
     * Signed download link sent by e-mail. Valid for 24 hours.
     */
    public function downloadExport(User $user): JsonResponse
    {
        return $this->exportResponse($user);
    }

    /**
     * Build the JSON export payload + download response for a user.
     */
    private function exportResponse(User $user): JsonResponse
    {
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

    /**
     * Account deletion is now confirmed by e-mail: validate the password, then
     * send a signed 24-hour confirmation link instead of deleting immediately.
     */
    public function deleteAccount(Request $request): RedirectResponse
    {
        $request->validate(['password' => ['required', 'current_password']]);

        $user = Auth::user();
        $url = URL::temporarySignedRoute(
            'settings.account.delete.confirm',
            now()->addHours(24),
            ['user' => $user->id],
        );
        Mail::to($user->email)->send(new AccountDeletionRequestMail($url));

        return back()->with('status', 'Poslali sme ti potvrdzovací email. Účet vymažeme až po kliknutí na odkaz.');
    }

    /**
     * Confirmation page reached from the deletion e-mail (signed, no side effects).
     */
    public function confirmDeleteShow(User $user): View
    {
        return view('settings.confirm-delete', ['user' => $user]);
    }

    /**
     * Perform the actual, irreversible account deletion (signed POST).
     */
    public function confirmDeletePerform(Request $request, User $user): RedirectResponse
    {
        $wasCurrentUser = Auth::id() === $user->id;

        $user->delete();

        if ($wasCurrentUser) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('home')->with('status', 'Účet bol natrvalo vymazaný.');
    }
}
