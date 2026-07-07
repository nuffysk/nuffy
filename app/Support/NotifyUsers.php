<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

class NotifyUsers
{
    /**
     * Send a (queued) mailable to every user who has the given notification
     * preference enabled. Users without an e-mail or matching the excluded id
     * are skipped. The mailable implements ShouldQueue, so each send is queued.
     *
     * @param  callable(User): \Illuminate\Mail\Mailable  $mailFactory
     *         Builds the mailable per recipient (so each gets their own
     *         one-click unsubscribe link).
     */
    public static function broadcast(string $prefKey, callable $mailFactory, ?int $excludeId = null): void
    {
        User::query()
            ->whereNotNull('email')
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->select('id', 'email', 'notification_prefs')
            ->chunkById(200, function ($users) use ($prefKey, $mailFactory) {
                foreach ($users as $user) {
                    if ($user->wantsNotification($prefKey)) {
                        Mail::to($user->email)->send($mailFactory($user));
                    }
                }
            });
    }
}
