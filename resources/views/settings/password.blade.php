@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Zmena hesla</h1>

        <a href="{{ route('settings') }}" class="mt-2 inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            Späť na nastavenia
        </a>

        @if (session('status'))<p class="mt-2 text-sm text-accent">{{ session('status') }}</p>@endif

        <form method="POST" action="{{ route('settings.password.send') }}" class="mt-6 space-y-4">
            @csrf
            <label class="block">
                <span class="mb-2 block text-sm font-medium">Email</span>
                <input type="email" value="{{ auth()->user()->email }}" readonly class="w-full rounded-full border border-border bg-accent/20 px-5 py-3 text-sm text-foreground focus:outline-none">
                <p class="mt-2 px-2 text-xs text-muted-foreground">
                    Na tvoju registrovanú emailovú adresu pošleme odkaz na obnovu hesla. Po kliknutí naň si nastavíš nové heslo. Odkaz platí 24 hodín.
                </p>
            </label>

            <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)]">Poslať odkaz na obnovu hesla</button>
        </form>
    </div>
@endsection
