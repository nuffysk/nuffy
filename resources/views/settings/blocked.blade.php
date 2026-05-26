@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <a href="{{ route('settings') }}" class="inline-flex items-center gap-1 rounded-full border border-border bg-card px-3 py-1.5 text-sm hover:bg-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Späť
        </a>
        <h1 class="mt-4 font-display text-3xl">Blokovaní používatelia</h1>
        <div class="mt-6 rounded-2xl border border-border bg-card p-4 text-sm text-muted-foreground">
            Funkcia blokovania je vo vývoji.
        </div>
    </div>
@endsection
