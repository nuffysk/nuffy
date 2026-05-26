<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InboxController extends Controller
{
    public function index(): View
    {
        $me = Auth::id();

        // Build conversations: partner = the other user in each thread.
        $messages = Message::where(function ($q) use ($me) {
                $q->where('sender_id', $me)->orWhere('receiver_id', $me);
            })
            ->orderByDesc('id')
            ->limit(500)
            ->get(['id', 'sender_id', 'receiver_id', 'body', 'read_at', 'created_at']);

        $grouped = $messages->groupBy(fn ($m) => $m->sender_id === $me ? $m->receiver_id : $m->sender_id);

        $conversations = $grouped->map(function ($msgs, $partnerId) use ($me) {
            $last = $msgs->sortByDesc('id')->first();
            $unread = $msgs->filter(fn ($m) => $m->receiver_id === $me && $m->read_at === null)->count();
            return (object) [
                'partner_id' => $partnerId,
                'last_message' => $last,
                'unread' => $unread,
            ];
        })->sortByDesc(fn ($c) => $c->last_message?->created_at)->values();

        $partners = User::whereIn('id', $conversations->pluck('partner_id'))
            ->get(['id', 'name', 'display_name', 'avatar_url'])->keyBy('id');

        return view('inbox.index', compact('conversations', 'partners'));
    }

    public function show(User $user): View
    {
        $me = Auth::id();
        abort_if($me === $user->id, 404);

        Message::where('sender_id', $user->id)->where('receiver_id', $me)->whereNull('read_at')->update(['read_at' => now()]);

        $messages = Message::where(function ($q) use ($me, $user) {
            $q->where(['sender_id' => $me, 'receiver_id' => $user->id])
              ->orWhere(['sender_id' => $user->id, 'receiver_id' => $me]);
        })->orderBy('created_at')->get();

        return view('inbox.show', ['partner' => $user, 'messages' => $messages]);
    }

    public function send(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate(['body' => ['required', 'string', 'max:2000']]);
        abort_if($user->id === Auth::id(), 422);
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'body' => trim($data['body']),
        ]);
        return redirect()->route('inbox.show', $user);
    }

    public function poll(Request $request, User $user): JsonResponse
    {
        $me = Auth::id();
        $afterId = (int) $request->query('after', 0);
        $messages = Message::where(function ($q) use ($me, $user) {
            $q->where(['sender_id' => $me, 'receiver_id' => $user->id])
              ->orWhere(['sender_id' => $user->id, 'receiver_id' => $me]);
        })->where('id', '>', $afterId)->orderBy('created_at')->get();

        Message::where('sender_id', $user->id)->where('receiver_id', $me)->whereNull('read_at')->update(['read_at' => now()]);

        return response()->json([
            'messages' => $messages->map(fn ($m) => [
                'id' => $m->id,
                'sender_id' => $m->sender_id,
                'body' => $m->body,
                'created_at' => $m->created_at->toIso8601String(),
            ]),
        ]);
    }
}
