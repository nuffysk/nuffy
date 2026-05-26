@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Feed</h1>
        <p class="mt-1 text-sm text-muted-foreground">Čo sa deje v susedstve.</p>

        @if (session('status'))
            <p class="mt-3 text-sm text-accent">{{ session('status') }}</p>
        @endif

        <form method="POST" action="{{ route('feed.store') }}" enctype="multipart/form-data" class="mt-5 space-y-3 rounded-2xl border border-border bg-card p-4">
            @csrf
            <input type="file" name="image" accept="image/*" required class="block w-full text-sm">
            @error('image')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            <textarea name="caption" rows="3" maxlength="500" placeholder="Niečo k tomu napíš…" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm"></textarea>
            <p class="text-xs text-muted-foreground">Odoslaním formulára súhlasíš so spracovaním osobných údajov.</p>
            <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-primary px-4 py-2 text-sm font-medium text-primary-foreground">Zdieľať</button>
        </form>

        <div class="mt-6 space-y-5">
            @forelse ($posts as $post)
                <article class="overflow-hidden rounded-2xl border border-border bg-card">
                    <div class="flex items-center gap-3 p-4">
                        <a href="{{ route('users.show', $post->author) }}" class="h-10 w-10 overflow-hidden rounded-full bg-muted">
                            @if ($post->author?->avatar_url)<img src="{{ $post->author->avatar_url }}" alt="" class="h-full w-full object-cover">@endif
                        </a>
                        <div class="flex-1">
                            <p class="text-sm font-medium">
                                <a href="{{ route('users.show', $post->author) }}">{{ $post->author?->display_name ?? $post->author?->name }}</a>
                                @if ($post->dog) · <span class="text-muted-foreground">{{ $post->dog->name }}</span>@endif
                            </p>
                            <p class="text-xs text-muted-foreground">{{ $post->created_at->format('d.m.Y') }}@if ($post->author?->city) · {{ $post->author->city }}@endif</p>
                        </div>
                    </div>
                    <img src="{{ $post->image_url }}" alt="" class="block w-full aspect-square object-cover">
                    @if ($post->caption)
                        <div class="flex items-start gap-2 p-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 shrink-0 text-accent"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.29 1.51 4.04 3 5.5l7 7Z"/></svg>
                            <p class="text-sm leading-relaxed">{{ $post->caption }}</p>
                        </div>
                    @endif
                </article>
            @empty
                <p class="text-sm text-muted-foreground">Zatiaľ nič — buď prvý a zdieľaj fotku s psíkom.</p>
            @endforelse
        </div>
    </div>
@endsection
