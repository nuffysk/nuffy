@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Feed</h1>
        <p class="mt-1 text-sm text-muted-foreground">Čo sa deje v susedstve.</p>

        @if (session('status'))
            <p class="mt-3 text-sm text-accent">{{ session('status') }}</p>
        @endif

        <form method="POST" action="{{ route('feed.store') }}" enctype="multipart/form-data" class="mt-4 space-y-3 rounded-2xl border border-border bg-card p-4">
            @csrf
            <textarea
                name="caption"
                placeholder="Napíš niečo o dnešnom venčení…"
                maxlength="500"
                rows="2"
                class="block w-full border-0 bg-transparent p-0 text-base shadow-none focus-visible:ring-0 focus:outline-none resize-none"
            ></textarea>
            <div class="flex items-center justify-between border-t border-border pt-3">
                <input
                    id="post-file"
                    type="file"
                    name="image"
                    accept="image/*"
                    required
                    class="text-xs text-muted-foreground file:mr-3 file:rounded-md file:border-0 file:bg-muted file:px-3 file:py-1.5 file:text-xs file:font-medium"
                >
                <button type="submit" class="inline-flex items-center justify-center rounded-md bg-primary px-3 py-1.5 text-sm font-medium text-primary-foreground">Zdieľať</button>
            </div>
            @error('image')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            <p class="text-[11px] leading-relaxed text-muted-foreground">
                Odoslaním formulára súhlasíš so spracovaním osobných údajov a zverejnením fotografií v rámci aplikácie.
            </p>
        </form>

        <section class="mt-6 space-y-6">
            @forelse ($posts as $post)
                <article class="overflow-hidden rounded-2xl border border-border bg-card">
                    <header class="flex items-center justify-between px-4 py-3">
                        <a href="{{ route('users.show', $post->author) }}" class="flex items-center gap-3">
                            <div class="h-9 w-9 overflow-hidden rounded-full bg-muted">
                                @if ($post->author?->avatar_url)<img src="{{ $post->author->avatar_url }}" alt="" class="h-full w-full object-cover">@endif
                            </div>
                            <div>
                                <p class="text-sm font-medium">{{ $post->author?->display_name ?? $post->author?->name ?? 'Niekto' }}</p>
                                <p class="text-xs text-muted-foreground">{{ $post->dog?->name ? 's '.$post->dog->name : ($post->author?->city ?? '') }}</p>
                            </div>
                        </a>
                        <time class="text-xs text-muted-foreground">{{ $post->created_at->format('d.m.Y') }}</time>
                    </header>
                    <img src="{{ $post->image_url }}" alt="{{ $post->caption ?? 'Fotka psíka' }}" class="w-full" loading="lazy">
                    <div class="flex items-center gap-3 px-4 py-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.29 1.51 4.04 3 5.5l7 7Z"/></svg>
                        @if ($post->caption)<p class="text-sm">{{ $post->caption }}</p>@endif
                    </div>
                </article>
            @empty
                <p class="text-sm text-muted-foreground">Zatiaľ nič — buď prvý a zdieľaj fotku s psíkom.</p>
            @endforelse
        </section>
    </div>
@endsection
