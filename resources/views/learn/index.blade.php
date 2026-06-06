@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Zavoditko</h1>
        <p class="mt-2 text-sm leading-relaxed text-foreground">
            Napriamo o starostlivosti a výchove psíkov.
            <br>
            Sleduj, uč sa, bav sa.
        </p>
        <p class="mt-5 font-display text-lg">Kategórie:</p>
        <div class="mt-3 space-y-3">
            @foreach ($topics as $t)
                <a
                    href="{{ route('learn.show', ['topic' => $t->slug]) }}"
                    class="flex w-full gap-3 overflow-hidden rounded-2xl border border-border bg-card text-left transition hover:shadow-[var(--shadow-soft)]"
                >
                    <div class="h-24 w-28 shrink-0 bg-muted">
                        @if ($t->thumbnail_url)
                            <img src="{{ $t->thumbnail_url }}" alt="{{ $t->title }}" class="h-full w-full object-cover" loading="lazy">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-muted-foreground">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-col justify-center py-3 pr-4">
                        <p class="font-display text-lg">{{ $t->title }}</p>
                        @if ($t->summary)
                            <p class="line-clamp-2 text-xs text-muted-foreground">{{ $t->summary }}</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
