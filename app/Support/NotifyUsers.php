<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class NotifyUsers
{
    /**
     * Send a (queued) mailable to every user who has the given notification
     * preference enabled. Users without an e-mail or matching the excluded id
     * are skipped. The mailable implements ShouldQueue, so each send is queued.
     */
    public static function broadcast(string $prefKey, Mailable $mail, ?int $excludeId = null): void
    {
        User::query()
            ->whereNotNull('email')
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->select('id', 'email', 'notification_prefs')
            ->chunkById(200, function ($users) use ($prefKey, $mail) {
                foreach ($users as $user) {
                    if ($user->wantsNotification($prefKey)) {
                        Mail::to($user->email)->send($mail);
                    }
                }
            });
    }
}
