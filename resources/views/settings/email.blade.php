@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <a href="{{ route('settings') }}" class="inline-flex items-center gap-1 rounded-full border border-border bg-card px-3 py-1.5 text-sm hover:bg-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Späť
        </a>
        <h1 class="mt-4 font-display text-3xl">Zmena emailovej adresy</h1>
        @if (session('status'))<p class="mt-2 text-sm text-accent">{{ session('status') }}</p>@endif

        <form method="POST" action="{{ route('settings.email.update') }}" class="mt-6 space-y-4">
            @csrf
            @method('PATCH')
            <div class="space-y-2">
                <label for="email" class="text-sm font-medium">Nový email</label>
                <input id="email" name="email" type="email" required value="{{ old('email', auth()->user()->email) }}" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">
                @error('email')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>
            <div class="space-y-2">
                <label for="password" class="text-sm font-medium">Heslo (potvrď zmenu)</label>
                <input id="password" name="password" type="password" required autocomplete="current-password" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">
                @error('password')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)]">Zmeniť email</button>
        </form>
    </div>
@endsection
