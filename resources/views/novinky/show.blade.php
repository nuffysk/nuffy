@extends('layouts.app')

@section('content')
    <div class="mt-2">
        <a href="{{ route('novinky.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-muted-foreground hover:text-foreground">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Novinky
        </a>
    </div>

    <article class="mt-4 rounded-[20px] bg-card p-6 shadow-[0px_4px_14px_rgba(139,94,60,0.10)]">
        <h1 class="font-display text-2xl font-bold leading-tight text-foreground">{{ $item->title }}</h1>
        <p class="mt-2 text-xs text-muted-foreground">{{ $item->created_at->format('d. n. Y') }}</p>
        <div class="mt-5 whitespace-pre-wrap text-[15px] leading-relaxed text-foreground">{{ $item->content }}</div>
    </article>

    <div class="mt-6 flex justify-center">
        <a href="{{ route('novinky.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-border bg-card px-4 py-2 text-sm hover:bg-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Späť na novinky
        </a>
    </div>
@endsection
