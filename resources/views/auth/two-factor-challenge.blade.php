@extends('layouts.app')

@section('content')
    <div class="pt-8">
        <h1 class="font-display text-4xl">
            Overenie<span class="text-accent">.</span>
        </h1>
        <p class="mt-2 text-sm text-muted-foreground">
            Zadaj 6-ciferný kód z autentifikačnej aplikácie.
        </p>

        <form method="POST" action="{{ route('two-factor.login') }}" class="mt-8 space-y-4">
            @csrf

            <div class="space-y-2">
                <label for="code" class="text-sm font-medium">Overovací kód</label>
                <input
                    id="code"
                    name="code"
                    inputmode="numeric"
                    pattern="[0-9]*"
                    maxlength="6"
                    placeholder="123456"
                    required autofocus autocomplete="one-time-code"
                    class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-center text-lg tracking-[0.3em]"
                >
                @error('code')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)] transition">
                Overiť a prihlásiť
            </button>
        </form>

        <a href="{{ route('login') }}" class="mt-6 block w-full text-center text-sm text-muted-foreground hover:text-foreground">
            Späť na prihlásenie
        </a>
    </div>
@endsection
