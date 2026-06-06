@extends('layouts.app')

@section('content')
    @php
        $youtubeMap = [
            'osiny' => 'https://www.youtube.com/watch?v=vt9Axfxjce4',
            'usi' => 'https://www.youtube.com/watch?v=amjdi4nvGxo',
            'intoxikacia-vodou' => 'https://www.youtube.com/watch?v=9zIeR7chWRI',
            'ortopedicke-problemy' => 'https://www.youtube.com/watch?v=k7FNpZyo3xE',
            'kliesste' => 'https://www.youtube.com/watch?v=f4nc_ie1fl0',
            'mnoziarne' => 'https://www.youtube.com/watch?v=LjkoJ0djlow',
            'cestovanie-so-psom' => 'https://www.youtube.com/watch?v=1aijtMzHV_8',
            'oblecenie-pre-psa' => 'https://www.youtube.com/watch?v=LgyEQ1bxRA8',
        ];
        $yt = $youtubeMap[$topic->slug] ?? null;
        $ytSlugs = array_keys($youtubeMap);
    @endphp

    <a href="{{ route('learn.index') }}" class="mt-4 inline-flex items-center gap-1 rounded-full border border-border bg-card px-3 py-1.5 text-sm text-foreground hover:bg-muted">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Späť
    </a>
    <h1 class="mt-4 font-display text-3xl">{{ $topic->title }}</h1>
    @if ($topic->summary)
        <p class="mt-1 text-sm text-muted-foreground">{{ $topic->summary }}</p>
    @endif

    @if ($yt && $topic->thumbnail_url)
        <a href="{{ $yt }}" target="_blank" rel="noopener noreferrer" class="group relative mt-5 block aspect-[16/9] overflow-hidden rounded-3xl bg-muted">
            <img src="{{ $topic->thumbnail_url }}" alt="{{ $topic->title }}" class="h-full w-full object-cover">
            <div class="absolute inset-0 flex items-center justify-center bg-black/20 transition group-hover:bg-black/30">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-white/90 shadow-lg transition group-hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="black" stroke="none" class="ml-1"><polygon points="6 3 20 12 6 21 6 3"/></svg>
                </div>
            </div>
        </a>
    @endif

    @if ($topic->thumbnail_url && ! in_array($topic->slug, $ytSlugs))
        <div class="mt-5 aspect-[16/9] overflow-hidden rounded-3xl bg-muted">
            <img src="{{ $topic->thumbnail_url }}" alt="{{ $topic->title }}" class="h-full w-full object-cover">
        </div>
    @endif

    @if ($topic->video_url && ! in_array($topic->slug, $ytSlugs))
        <div class="mt-4 aspect-video overflow-hidden rounded-2xl bg-black">
            <video src="{{ $topic->video_url }}" controls class="h-full w-full"></video>
        </div>
    @endif

    @if ($topic->body)
        <p class="mt-5 whitespace-pre-line text-sm leading-relaxed">{{ $topic->body }}</p>
    @endif

    @if (! empty($topic->photos))
        <div class="mt-5 grid grid-cols-2 gap-2">
            @foreach ($topic->photos as $i => $url)
                <div class="aspect-square overflow-hidden rounded-2xl bg-muted">
                    <img src="{{ $url }}" alt="{{ $topic->title }} {{ $i + 1 }}" class="h-full w-full object-cover" loading="lazy">
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-5 flex items-center gap-4">
        @auth
            <form method="POST" action="{{ route('learn.like', ['topic' => $topic->slug]) }}">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-sm transition {{ $liked ? 'border-accent bg-[var(--heart-soft)] text-accent' : 'border-border bg-card text-muted-foreground' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="{{ $liked ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.29 1.51 4.04 3 5.5l7 7Z"/></svg>
                    {{ $likes }}
                </button>
            </form>
        @else
            <span class="inline-flex items-center gap-1.5 rounded-full border border-border bg-card px-3 py-1.5 text-sm text-muted-foreground">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.29 1.51 4.04 3 5.5l7 7Z"/></svg>
                {{ $likes }}
            </span>
        @endauth
        <span class="inline-flex items-center gap-1.5 text-sm text-muted-foreground">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            {{ $comments->count() }}
        </span>
    </div>

    <section class="mt-8">
        <h2 class="font-display text-xl">Komentáre</h2>
        @auth
            <form method="POST" action="{{ route('learn.comments.store', ['topic' => $topic->slug]) }}" class="mt-3 flex gap-2">
                @csrf
                <textarea name="body" rows="2" maxlength="500" placeholder="Napíš komentár…" required class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm"></textarea>
                <button type="submit" class="rounded-xl bg-primary px-4 py-2 text-sm font-medium text-primary-foreground">Pridať</button>
            </form>
            @error('body')<p class="mt-2 text-sm text-destructive">{{ $message }}</p>@enderror
        @endauth
        <ul class="mt-4 space-y-3">
            @forelse ($comments as $c)
                <li class="rounded-2xl border border-border bg-card p-3">
                    <div class="flex items-center gap-2">
                        <div class="h-6 w-6 overflow-hidden rounded-full bg-muted">
                            @if ($c->author?->avatar_url)
                                <img src="{{ $c->author->avatar_url }}" alt="" class="h-full w-full object-cover">
                            @endif
                        </div>
                        <p class="text-xs font-medium">{{ $c->author?->display_name ?? $c->author?->name ?? 'Niekto' }}</p>
                        <span class="text-xs text-muted-foreground">· {{ $c->created_at->format('d.m.Y') }}</span>
                    </div>
                    <p class="mt-2 text-sm">{{ $c->body }}</p>
                </li>
            @empty
                <p class="text-sm text-muted-foreground">Zatiaľ žiadne komentáre.</p>
            @endforelse
        </ul>
    </section>

    @auth
        <section class="mt-10 rounded-2xl border border-dashed border-border bg-card p-4">
            <p class="font-display text-lg">Akú tému by si chcel ďalej?</p>
            @if (session('status'))
                <p class="mt-2 text-sm text-accent">{{ session('status') }}</p>
            @endif
            <form method="POST" action="{{ route('learn.suggest') }}" class="mt-3 flex gap-2">
                @csrf
                <input type="text" name="suggestion" maxlength="120" placeholder="Napr. starostlivosť o zuby" required class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm">
                <button type="submit" class="rounded-xl bg-primary px-4 py-2 text-sm font-medium text-primary-foreground">Poslať</button>
            </form>
        </section>
    @endauth
@endsection
