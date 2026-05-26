@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <a href="{{ route('walks.index') }}" class="inline-flex items-center gap-1 rounded-full border border-border bg-card px-3 py-1.5 text-sm hover:bg-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Späť
        </a>

        <article class="mt-4 rounded-2xl border border-border bg-card p-4">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 overflow-hidden rounded-full bg-muted">
                    @if ($topic->author?->avatar_url)<img src="{{ $topic->author->avatar_url }}" alt="" class="h-full w-full object-cover">@endif
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium">{{ $topic->author?->display_name ?? $topic->author?->name }}</p>
                    <p class="text-xs text-muted-foreground">{{ $topic->created_at->diffForHumans() }}</p>
                </div>
                @auth
                    @if (auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('walks.destroy', $topic) }}" onsubmit="return confirm('Zmazať tému?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-full border border-destructive bg-card px-3 py-1.5 text-xs text-destructive">Zmazať</button>
                        </form>
                    @endif
                @endauth
            </div>
            <h1 class="mt-3 font-display text-2xl">{{ $topic->title }}</h1>
            @if ($topic->body)
                <p class="mt-3 whitespace-pre-line text-sm leading-relaxed">{{ $topic->body }}</p>
            @endif
        </article>

        @auth
            <form method="POST" action="{{ route('walks.comments.store', $topic) }}" class="mt-6 space-y-2">
                @csrf
                <textarea name="body" rows="3" maxlength="2000" placeholder="Napíš komentár…" required class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm"></textarea>
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-primary px-4 py-2 text-sm font-medium text-primary-foreground">Pridať komentár</button>
            </form>
        @endauth

        <section class="mt-6 space-y-3">
            @forelse ($tree as $node)
                @include('walks._comment', ['node' => $node, 'depth' => 0])
            @empty
                <p class="text-sm text-muted-foreground">Zatiaľ žiadne komentáre.</p>
            @endforelse
        </section>
    </div>
@endsection
