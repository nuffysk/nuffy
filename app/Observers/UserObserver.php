<?php

namespace App\Observers;

use App\Models\DeletionLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    /**
     * Record an audit entry before a user account is deleted (GDPR erasure log).
     */
    public function deleting(User $user): void
    {
        $actor = Auth::user();
        $deletedBy = 'system';
        if ($actor) {
            $deletedBy = $actor->id === $user->id ? 'self' : 'admin';
        }

        DeletionLog::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'name' => $user->display_name ?? $user->name,
            'deleted_by' => $deletedBy,
            'deleted_at' => now(),
        ]);
    }
}
