<?php

namespace App\Http\Controllers;

use App\Models\ForumComment;
use App\Models\ForumTopic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WalksController extends Controller
{
    public function index(): View
    {
        $topics = ForumTopic::with('author:id,name,display_name,avatar_url')
            ->withCount('comments')
            ->orderByDesc('pinned')
            ->orderByDesc('created_at')
            ->get();

        return view('walks.index', compact('topics'));
    }

    public function show(ForumTopic $topic): View
    {
        $topic->load(['author:id,name,display_name,avatar_url',
            'comments' => fn ($q) => $q->orderBy('created_at'),
            'comments.author:id,name,display_name,avatar_url',
        ]);

        $tree = $this->buildTree($topic->comments);

        return view('walks.show', compact('topic', 'tree'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless(Auth::user()->isAdmin(), 403);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'body' => ['nullable', 'string', 'max:5000'],
        ]);
        ForumTopic::create(array_merge($data, ['author_id' => Auth::id()]));
        return back()->with('status', 'Téma vytvorená.');
    }

    public function destroy(ForumTopic $topic): RedirectResponse
    {
        abort_unless(Auth::user()->isAdmin(), 403);
        $topic->delete();
        return redirect()->route('walks.index')->with('status', 'Téma zmazaná.');
    }

    public function storeComment(Request $request, ForumTopic $topic): RedirectResponse
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
            'parent_id' => ['nullable', 'exists:forum_comments,id'],
        ]);
        ForumComment::create([
            'topic_id' => $topic->id,
            'author_id' => Auth::id(),
            'parent_id' => $data['parent_id'] ?? null,
            'body' => $data['body'],
        ]);
        return back();
    }

    public function deleteComment(ForumComment $comment): RedirectResponse
    {
        abort_unless($comment->author_id === Auth::id() || Auth::user()->isAdmin(), 403);
        $comment->delete();
        return back();
    }

    private function buildTree($comments, $parentId = null): array
    {
        $branch = [];
        foreach ($comments as $c) {
            if ($c->parent_id === $parentId) {
                $children = $this->buildTree($comments, $c->id);
                $branch[] = ['comment' => $c, 'children' => $children];
            }
        }
        return $branch;
    }
}
