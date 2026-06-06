@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Blokovaní používatelia</h1>

        <a href="{{ route('settings') }}" class="mt-2 inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            Späť na nastavenia
        </a>

        <div class="mt-4 rounded-2xl border border-border bg-card p-4 text-sm text-muted-foreground">
            Tu sa zobrazia blokovaní používatelia.
        </div>
    </div>
@endsection
