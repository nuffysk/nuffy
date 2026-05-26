<?php

namespace App\Http\Controllers;

use App\Models\Novinka;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NovinkyController extends Controller
{
    public function index(): View
    {
        $items = Novinka::orderByDesc('created_at')->get(['id', 'slug', 'title', 'content', 'created_at', 'author_id']);
        return view('novinky.index', compact('items'));
    }

    public function show(Novinka $novinka): View
    {
        return view('novinky.show', ['item' => $novinka]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless(Auth::user()->isAdmin(), 403);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:140'],
            'content' => ['required', 'string'],
        ]);

        $slug = Str::slug($data['title']) ?: 'n-'.time();
        if (Novinka::where('slug', $slug)->exists()) {
            $slug .= '-'.base_convert(time(), 10, 36);
        }

        Novinka::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'slug' => $slug,
            'author_id' => Auth::id(),
        ]);

        return redirect()->route('novinky.index')->with('status', 'Novinka uložená.');
    }

    public function update(Request $request, Novinka $novinka): RedirectResponse
    {
        abort_unless(Auth::user()->isAdmin(), 403);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:140'],
            'content' => ['required', 'string'],
        ]);
        $novinka->update($data);
        return redirect()->route('novinky.show', $novinka)->with('status', 'Novinka upravená.');
    }

    public function destroy(Novinka $novinka): RedirectResponse
    {
        abort_unless(Auth::user()->isAdmin(), 403);
        $novinka->delete();
        return redirect()->route('novinky.index')->with('status', 'Zmazané.');
    }
}
