@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <a href="{{ route('settings') }}" class="inline-flex items-center gap-1 rounded-full border border-border bg-card px-3 py-1.5 text-sm hover:bg-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Späť
        </a>
        <h1 class="mt-4 font-display text-3xl">Zmena hesla</h1>
        @if (session('status'))<p class="mt-2 text-sm text-accent">{{ session('status') }}</p>@endif

        <p class="mt-4 text-sm text-muted-foreground">
            Link na zmenu hesla pošleme na <strong>{{ auth()->user()->email }}</strong>.
        </p>

        <form method="POST" action="{{ route('settings.password.send') }}" class="mt-6">
            @csrf
            <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)]">Poslať link na zmenu hesla</button>
        </form>
    </div>
@endsection
