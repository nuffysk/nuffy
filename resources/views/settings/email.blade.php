@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Zmena emailovej adresy</h1>

        <a href="{{ route('settings') }}" class="mt-2 inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            Späť na nastavenia
        </a>

        @if (session('status'))<p class="mt-2 text-sm text-accent">{{ session('status') }}</p>@endif

        <form method="POST" action="{{ route('settings.email.update') }}" class="mt-6 space-y-4">
            @csrf
            @method('PATCH')
            <label class="block">
                <span class="mb-2 block text-sm font-medium">Email</span>
                <input id="email" name="email" type="email" required value="{{ old('email') }}" placeholder="vas@email.sk" autocomplete="email" class="w-full rounded-full border border-border bg-accent/20 px-5 py-3 text-sm text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-accent">
                <p class="mt-2 px-2 text-xs text-muted-foreground">
                    Zadaj svoju novú emailovú adresu. Pošleme ti overovací odkaz — kliknutím naň zmenu potvrdíš.
                </p>
                @error('email')<p class="mt-2 px-2 text-xs text-destructive">{{ $message }}</p>@enderror
            </label>
            <div class="space-y-2">
                <label for="password" class="text-sm font-medium">Heslo (potvrď zmenu)</label>
                <input id="password" name="password" type="password" required autocomplete="current-password" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">
                @error('password')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
                <p class="text-[11px] text-muted-foreground">
                    Prihlásil/a si sa cez Google a heslo nemáš? Najprv si ho nastav cez
                    <a href="{{ route('settings.password') }}" class="text-accent underline">Zmenu hesla</a>.
                </p>
            </div>
            <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)]">Poslať overovací odkaz</button>
        </form>
    </div>
@endsection
