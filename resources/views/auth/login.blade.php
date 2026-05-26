@extends('layouts.app')

@section('content')
    <div class="pt-8">
        <h1 class="font-display text-4xl">
            Vitaj späť<span class="text-accent">.</span>
        </h1>
        <p class="mt-2 text-sm text-muted-foreground">
            Prihlás sa a plánuj venčenie so svojou svorkou.
        </p>

        @if (session('status'))
            <div class="mt-4 rounded-2xl border border-border bg-card px-4 py-3 text-sm text-foreground">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-4">
            @csrf

            <div class="space-y-2">
                <label for="email" class="text-sm font-medium">Email</label>
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

            <div class="space-y-2">
                <label for="password" class="text-sm font-medium">Heslo</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required autocomplete="current-password"
                    class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base"
                >
                @error('password')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            @if (Route::has('password.request'))
                <div class="-mt-2 flex justify-end">
                    <a href="{{ route('password.request') }}" class="text-xs text-muted-foreground hover:text-foreground">
                        Zabudli ste heslo?
                    </a>
                </div>
            @endif

            <input type="hidden" name="remember" value="1">

            <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)] transition">
                Prihlásiť
            </button>
        </form>

        <div class="my-6 flex items-center gap-3">
            <div class="h-px flex-1 bg-border"></div>
            <span class="text-xs uppercase tracking-wider text-muted-foreground">alebo</span>
            <div class="h-px flex-1 bg-border"></div>
        </div>

        <a href="{{ route('auth.google.redirect') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-border bg-card px-6 py-3 text-base font-medium text-foreground transition hover:bg-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M23.49 12.27c0-.79-.07-1.54-.19-2.27H12v4.51h6.44c-.27 1.4-1.09 2.6-2.34 3.4v2.85h3.78c2.21-2.04 3.49-5.05 3.49-8.49z"/><path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.78-2.85c-1.05.7-2.39 1.13-4.15 1.13-3.19 0-5.89-2.15-6.86-5.04H1.24v2.94C3.21 21.31 7.31 24 12 24z"/><path fill="#FBBC05" d="M5.14 14.32C4.91 13.62 4.78 12.83 4.78 12s.13-1.62.36-2.32V6.74H1.24C.45 8.32 0 10.1 0 12s.45 3.68 1.24 5.26l3.9-2.94z"/><path fill="#EA4335" d="M12 4.78c1.78 0 3.36.62 4.62 1.81l3.45-3.45C17.95 1.18 15.24 0 12 0 7.31 0 3.21 2.69 1.24 6.74l3.9 2.94C6.11 6.93 8.81 4.78 12 4.78z"/></svg>
            Pokračovať s Google
        </a>

        <a href="{{ route('register') }}" class="mt-6 block w-full text-center text-sm text-muted-foreground hover:text-foreground">
            Nemáš účet? Zaregistruj sa
        </a>

        <div class="mt-6 flex flex-wrap justify-center gap-2">
            <a href="/privacy" class="rounded-full border border-border bg-card px-4 py-2 text-xs font-medium text-foreground shadow-[var(--shadow-card)] transition hover:bg-muted">
                Podmienky ochrany súkromia
            </a>
            <a href="/terms" class="rounded-full border border-border bg-card px-4 py-2 text-xs font-medium text-foreground shadow-[var(--shadow-card)] transition hover:bg-muted">
                Podmienky používania
            </a>
        </div>
    </div>
@endsection
