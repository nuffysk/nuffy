<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FeedController extends Controller
{
    public function index(): View
    {
        $posts = Post::with(['author:id,name,display_name,city,avatar_url', 'dog:id,owner_id,name,breed'])
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();
        return view('feed.index', compact('posts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'image' => ['required', 'image', 'max:8192'],
            'caption' => ['nullable', 'string', 'max:500'],
        ]);

        $user = Auth::user();
        $path = $request->file('image')->store('post-photos/'.$user->id, 'public');
        $dog = $user->dogs()->first();

        Post::create([
            'author_id' => $user->id,
            'dog_id' => $dog?->id,
            'image_url' => Storage::url($path),
            'caption' => $data['caption'] ?? null,
        ]);

        return back()->with('status', 'Zdieľané ♥');
    }
}
