<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use App\Models\UserBlock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserPublicController extends Controller
{
    public function show(User $user): View|RedirectResponse
    {
        // Viewing your own public profile → go to the editable one.
        if (Auth::id() === $user->id) {
            return redirect()->route('profile.show');
        }
        $me = Auth::user();

        // Blocked in either direction → the profile is not available.
        if ($me && $me->isBlockedWith($user)) {
            $iBlocked = $me->hasBlocked($user);

            return view('users.unavailable', compact('user', 'iBlocked'));
        }

        $isFriend = $me ? $me->isFriendWith($user) : false;
        $friendship = $me ? Friendship::where(function ($q) use ($me, $user) {
            $q->where(['requester_id' => $me->id, 'addressee_id' => $user->id])
              ->orWhere(['requester_id' => $user->id, 'addressee_id' => $me->id]);
        })->first() : null;

        $dogs = $user->dogs()->get();

        return view('users.show', compact('user', 'dogs', 'isFriend', 'friendship'));
    }

    public function addFriend(User $user): RedirectResponse
    {
        $me = Auth::user();
        abort_if($me->id === $user->id, 422);
        abort_if($me->isBlockedWith($user), 403);

        $reverse = Friendship::where('requester_id', $user->id)
            ->where('addressee_id', $me->id)
            ->first();
        if ($reverse) {
            if ($reverse->status === 'pending') {
                $reverse->update(['status' => 'accepted']);

                return back()->with('status', 'Ste kamoši ♥');
            }
            if ($reverse->status === 'accepted') {
                return back()->with('status', 'Už ste kamoši.');
            }
            // Declined in the past — clear it so a fresh request can be sent.
            $reverse->delete();
        }

        // A previously declined request from me can also be retried.
        Friendship::where('requester_id', $me->id)
            ->where('addressee_id', $user->id)
            ->where('status', 'declined')
            ->delete();

        Friendship::firstOrCreate(
            ['requester_id' => $me->id, 'addressee_id' => $user->id],
            ['status' => 'pending']
        );

        return back()->with('status', 'Žiadosť o priateľstvo odoslaná.');
    }

    /**
     * Block a user: hides profiles both ways and severs any friendship.
     */
    public function block(User $user): RedirectResponse
    {
        $me = Auth::user();
        abort_if($me->id === $user->id, 422);

        UserBlock::firstOrCreate(['blocker_id' => $me->id, 'blocked_id' => $user->id]);

        // Remove any friendship or pending requests between the two.
        Friendship::where(function ($q) use ($me, $user) {
            $q->where(['requester_id' => $me->id, 'addressee_id' => $user->id])
              ->orWhere(['requester_id' => $user->id, 'addressee_id' => $me->id]);
        })->delete();

        return redirect()->route('settings.blocked')->with('status', 'Používateľ zablokovaný.');
    }

    public function unblock(User $user): RedirectResponse
    {
        UserBlock::where('blocker_id', Auth::id())
            ->where('blocked_id', $user->id)
            ->delete();

        return back()->with('status', 'Blokovanie zrušené.');
    }
}
