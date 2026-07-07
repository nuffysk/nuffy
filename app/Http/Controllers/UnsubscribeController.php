<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Unsubscribe;
use Illuminate\View\View;

class UnsubscribeController extends Controller
{
    /** Human-readable labels for each preference. */
    private const LABELS = [
        'friend_requests' => 'žiadosti o priateľstvo',
        'friend_accepted' => 'prijaté priateľstvá',
        'sos' => 'SOS prípady',
        'videos' => 'videá Závoditko',
    ];

    /**
     * One-click unsubscribe from a notification category. Reached via a signed
     * link in e-mails, so it works without logging in.
     */
    public function __invoke(User $user, string $pref): View
    {
        abort_unless(in_array($pref, Unsubscribe::PREFS, true), 404);

        $prefs = $user->notification_prefs ?? [];
        $prefs[$pref] = false;
        $user->notification_prefs = $prefs;
        $user->save();

        return view('unsubscribe', [
            'label' => self::LABELS[$pref] ?? $pref,
        ]);
    }
}
