@extends('layouts.app')

@section('content')
    @php
        $catMeta = [
            'hotel'    => ['Hotel',    '<path d="M10 22v-6.57"/><path d="M12 11h.01"/><path d="M12 7h.01"/><path d="M14 15.43V22"/><path d="M15 16a5 5 0 0 0-6 0"/><path d="M16 11h.01"/><path d="M16 7h.01"/><path d="M8 11h.01"/><path d="M8 7h.01"/><rect x="4" y="2" width="16" height="20" rx="2"/>'],
            'daycare'  => ['Škôlka',   '<path d="M14 21v-3a2 2 0 0 0-4 0v3"/><path d="M18 5v16"/><path d="m4 6 7.106-3.79a2 2 0 0 1 1.788 0L20 6"/><path d="m6 11-3.52 2.147a1 1 0 0 0-.48.854V19a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a1 1 0 0 0-.48-.853L18 11"/><path d="M6 5v16"/><circle cx="12" cy="9" r="2"/>'],
            'grooming' => ['Grooming', '<path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"/><path d="M20 2v4"/><path d="M22 4h-4"/><circle cx="4" cy="20" r="2"/>'],
        ];
        $mapPinIcon = '<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/>';
        $meta = $catMeta[$place->category] ?? [$place->category, $mapPinIcon];
    @endphp

    <a href="{{ route('places.index') }}" class="mt-4 inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg> Späť
    </a>

    @if ($place->image_url)
        <div class="mt-3 aspect-[16/10] overflow-hidden rounded-3xl bg-muted">
            <img src="{{ $place->image_url }}" alt="{{ $place->name }}" class="h-full w-full object-cover">
        </div>
    @endif

    <div class="mt-5">
        <p class="inline-flex items-center gap-1 text-[10px] uppercase tracking-[0.18em] text-accent">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $meta[1] !!}</svg> {{ $meta[0] }}@if ($place->city) · {{ $place->city }}@endif
        </p>
        <h1 class="mt-1 font-display text-3xl">{{ $place->name }}</h1>

        @if ($place->address)
            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($place->address) }}" target="_blank" rel="noreferrer" class="mt-3 flex items-start gap-2 rounded-2xl border border-border bg-card p-3 text-sm transition hover:shadow-[var(--shadow-soft)]">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 shrink-0 text-accent">{!! $mapPinIcon !!}</svg>
                <span>
                    <span class="block text-[10px] uppercase tracking-wider text-muted-foreground">Adresa</span>
                    <span class="block">{{ $place->address }}</span>
                </span>
            </a>
        @endif

        @if ($place->description)
            <p class="mt-5 whitespace-pre-wrap text-sm leading-relaxed">{{ $place->description }}</p>
        @endif
    </div>
@endsection
