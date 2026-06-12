<?php

namespace App\Observers;

use App\Mail\FriendRequestAcceptedMail;
use App\Mail\FriendRequestReceivedMail;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class FriendshipObserver
{
    /**
     * A new (pending) friend request was created — notify the addressee.
     */
    public function created(Friendship $friendship): void
    {
        if ($friendship->status !== 'pending') {
            return;
        }

        $addressee = User::find($friendship->addressee_id);

        if ($addressee && $addressee->email && $addressee->wantsNotification('friend_requests')) {
            Mail::to($addressee->email)->send(new FriendRequestReceivedMail(route('friends.index')));
        }
    }

    /**
     * A friend request was accepted — notify the original requester.
     */
    public function updated(Friendship $friendship): void
    {
        if (! $friendship->wasChanged('status') || $friendship->status !== 'accepted') {
            return;
        }

        $requester = User::find($friendship->requester_id);

        if ($requester && $requester->email && $requester->wantsNotification('friend_accepted')) {
            Mail::to($requester->email)->send(new FriendRequestAcceptedMail(route('friends.index')));
        }
    }
}
