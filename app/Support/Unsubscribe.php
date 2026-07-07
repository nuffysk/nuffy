<?php

namespace App\Support;

use Illuminate\Support\Facades\URL;

class Unsubscribe
{
    /** Notification preference keys that can be unsubscribed from. */
    public const PREFS = ['friend_requests', 'friend_accepted', 'sos', 'videos'];

    /**
     * Signed one-click unsubscribe URL for a given user + preference.
     * No expiry so old e-mails keep working.
     */
    public static function url(int $userId, string $pref): string
    {
        return URL::signedRoute('notifications.unsubscribe', [
            'user' => $userId,
            'pref' => $pref,
        ]);
    }
}
