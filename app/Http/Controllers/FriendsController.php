<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FriendsController extends Controller
{
    public function index(): View
    {
        $me = Auth::user();

        $friendships = Friendship::with(['requester:id,name,display_name,avatar_url,city', 'addressee:id,name,display_name,avatar_url,city'])
            ->where(function ($q) use ($me) {
                $q->where('requester_id', $me->id)->orWhere('addressee_id', $me->id);
            })
            ->orderByDesc('created_at')
            ->get();

        $accepted = $friendships->where('status', 'accepted');
        $incoming = $friendships->where('status', 'pending')->where('addressee_id', $me->id);

        $excludeIds = $friendships->flatMap(fn ($f) => [$f->requester_id, $f->addressee_id])
            ->push($me->id)
            ->merge($me->blockedUserIds())
            ->unique();
        $suggestions = User::whereNotIn('id', $excludeIds)
            ->select('id', 'name', 'display_name', 'avatar_url', 'city')
            ->inRandomOrder()
            ->limit(12)
            ->get();

        return view('friends.index', compact('accepted', 'incoming', 'suggestions', 'me'));
    }

    public function respond(Friendship $friendship, string $action): RedirectResponse
    {
        abort_if($friendship->addressee_id !== Auth::id(), 403);
        abort_unless(in_array($action, ['accept', 'decline']), 422);
        $friendship->update(['status' => $action === 'accept' ? 'accepted' : 'declined']);
        return back()->with('status', $action === 'accept' ? 'Kamoš pridaný!' : 'Odmietnuté');
    }

    /**
     * Remove a friendship. Allowed for either side of the relationship
     * (unfriend an accepted friend, or cancel a request you sent).
     */
    public function unfriend(Friendship $friendship): RedirectResponse
    {
        $me = Auth::id();
        abort_if($friendship->requester_id !== $me && $friendship->addressee_id !== $me, 403);

        $friendship->delete();

        return back()->with('status', 'Kamoš odobraný.');
    }
}
