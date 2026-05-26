@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <a href="{{ route('places.index') }}" class="inline-flex items-center gap-1 rounded-full border border-border bg-card px-3 py-1.5 text-sm hover:bg-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Späť
        </a>

        @if ($place->image_url)
            <div class="mt-4 aspect-[16/9] overflow-hidden rounded-3xl bg-muted">
                <img src="{{ $place->image_url }}" alt="{{ $place->name }}" class="h-full w-full object-cover">
            </div>
        @endif

        <div class="mt-4 flex items-center gap-2">
            <span class="rounded-full bg-[var(--heart-soft)] px-2 py-1 text-[10px] uppercase tracking-wider text-accent">{{ $place->category }}</span>
            @if ($place->city)<span class="text-xs text-muted-foreground">{{ $place->city }}</span>@endif
        </div>
        <h1 class="mt-2 font-display text-3xl">{{ $place->name }}</h1>

        @if ($place->address)
            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($place->address) }}" target="_blank" rel="noopener" class="mt-4 flex items-center gap-3 rounded-2xl border border-border bg-card p-4 hover:bg-muted">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 7-8 12-8 12s-8-5-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <span class="text-sm">{{ $place->address }}</span>
            </a>
        @endif

        @if ($place->description)
            <p class="mt-5 whitespace-pre-line text-sm leading-relaxed">{{ $place->description }}</p>
        @endif
    </div>
@endsection
