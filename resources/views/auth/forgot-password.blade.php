@extends('layouts.app')

@section('content')
    <div class="pt-8">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            Späť na prihlásenie
        </a>

        <h1 class="mt-4 font-display text-4xl">
            Obnova hesla<span class="text-accent">.</span>
        </h1>

        @if (session('status'))
            <div class="mt-8 space-y-4">
                <div class="rounded-lg border border-border bg-card p-4 text-sm text-foreground">
                    Odkaz na obnovenie hesla bol odoslaný na tvoj email. Skontroluj aj priečinok spam.
                </div>
                <a href="{{ route('login') }}" class="inline-flex w-full items-center justify-center rounded-2xl border border-border bg-card px-6 py-3 text-base font-medium text-foreground transition hover:bg-muted">
                    Späť na prihlásenie
                </a>
            </div>
        @else
            <form method="POST" action="{{ route('password.email') }}" class="mt-8 space-y-4">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium">Zadaj svoj email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required autofocus autocomplete="username"
                        class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base"
                    >
                    @error('email')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)] transition">
                    Odoslať odkaz na obnovenie hesla
                </button>
            </form>
        @endif
    </div>
@endsection
