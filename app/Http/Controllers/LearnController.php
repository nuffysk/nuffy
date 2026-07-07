<?php

namespace App\Http\Controllers;

use App\Models\ForumReport;
use App\Models\LearnComment;
use App\Models\LearnTopic;
use App\Models\TopicRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LearnController extends Controller
{
    public function index(): View
    {
        $topics = LearnTopic::orderBy('sort_order')->get();
        return view('learn.index', compact('topics'));
    }

    public function show(LearnTopic $topic): View
    {
        $userId = Auth::id();
        $likes = DB::table('learn_likes')->where('topic_id', $topic->id)->count();
        $liked = $userId
            ? DB::table('learn_likes')->where('topic_id', $topic->id)->where('user_id', $userId)->exists()
            : false;
        $comments = LearnComment::with('author:id,name,display_name,avatar_url')
            ->where('topic_id', $topic->id)
            ->orderByDesc('created_at')
            ->get();

        return view('learn.show', compact('topic', 'likes', 'liked', 'comments'));
    }

    public function toggleLike(LearnTopic $topic): RedirectResponse
    {
        $userId = Auth::id();
        $exists = DB::table('learn_likes')->where('topic_id', $topic->id)->where('user_id', $userId)->exists();
        if ($exists) {
            DB::table('learn_likes')->where('topic_id', $topic->id)->where('user_id', $userId)->delete();
        } else {
            DB::table('learn_likes')->insert([
                'topic_id' => $topic->id,
                'user_id' => $userId,
                'created_at' => now(),
            ]);
        }
        return back();
    }

    public function storeComment(Request $request, LearnTopic $topic): RedirectResponse
    {
        $data = $request->validate(['body' => ['required', 'string', 'max:500']]);
        LearnComment::create([
            'topic_id' => $topic->id,
            'author_id' => Auth::id(),
            'body' => trim($data['body']),
        ]);
        return back();
    }

    public function reportComment(Request $request, LearnComment $comment): RedirectResponse
    {
        $data = $request->validate(['reason' => ['required', 'string', 'max:60']]);

        ForumReport::firstOrCreate(
            [
                'reporter_id' => Auth::id(),
                'target_type' => 'learn_comment',
                'target_id' => $comment->id,
            ],
            [
                'reason' => $data['reason'],
                'status' => 'open',
            ]
        );

        return back()->with('status', 'Ďakujeme, nahlásenie bolo odoslané.');
    }

    public function storeSuggestion(Request $request): RedirectResponse
    {
        $data = $request->validate(['suggestion' => ['required', 'string', 'max:120']]);
        TopicRequest::create([
            'user_id' => Auth::id(),
            'suggestion' => trim($data['suggestion']),
        ]);
        return back()->with('status', 'Ďakujeme za tip!');
    }
}
