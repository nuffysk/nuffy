<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserPublicController extends Controller
{
    public function show(User $user): View
    {
        abort_if(Auth::id() === $user->id, 302, '/profile');
        $me = Auth::user();

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

        $reverse = Friendship::where('requester_id', $user->id)
            ->where('addressee_id', $me->id)
            ->first();
        if ($reverse) {
            if ($reverse->status === 'pending') {
                $reverse->update(['status' => 'accepted']);
                return back()->with('status', 'Ste kamoši ♥');
            }
            return back()->with('status', $reverse->status === 'accepted' ? 'Už ste kamoši.' : 'Žiadosť bola predtým odmietnutá.');
        }

        Friendship::firstOrCreate(
            ['requester_id' => $me->id, 'addressee_id' => $user->id],
            ['status' => 'pending']
        );
        return back()->with('status', 'Žiadosť o priateľstvo odoslaná.');
    }
}
