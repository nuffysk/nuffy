@extends('layouts.app')

@section('content')
    <div class="pt-6" x-data="{ confirm: false }">
        <h1 class="font-display text-3xl">Účet</h1>

        <a href="{{ route('settings') }}" class="mt-2 inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            Späť na nastavenia
        </a>

        @if (session('status'))<p class="mt-2 text-sm text-accent">{{ session('status') }}</p>@endif

        <div class="mt-6 space-y-3">
            <a href="{{ route('settings.export') }}" class="block w-full rounded-full border border-border bg-card px-5 py-3 text-center text-sm font-medium text-foreground transition hover:bg-muted">
                Stiahnuť moje dáta (GDPR)
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full rounded-full border border-border bg-card px-5 py-3 text-sm font-medium text-foreground transition hover:bg-muted">
                    Odhlásiť sa
                </button>
            </form>

            <button @click="confirm = true" class="w-full rounded-full border border-accent bg-accent px-5 py-3 text-sm font-medium text-accent-foreground transition hover:opacity-90">
                Vymazať účet
            </button>
        </div>

        <div x-show="confirm" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4" style="display: none;">
            <div class="w-full max-w-sm rounded-2xl bg-card p-5 shadow-2xl">
                <h2 class="font-display text-xl">Naozaj vymazať účet?</h2>
                <p class="mt-2 text-sm text-muted-foreground">Táto akcia je nezvratná. Všetky vaše údaje budú trvalo odstránené.</p>
                <form method="POST" action="{{ route('settings.account.delete') }}" class="mt-4 space-y-3">
                    @csrf
                    @method('DELETE')
                    <input type="password" name="password" placeholder="Tvoje heslo" required class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm">
                    @error('password')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
                    <div class="flex gap-2">
                        <button type="button" @click="confirm = false" class="flex-1 rounded-xl border border-border bg-card px-4 py-2 text-sm">Zrušiť</button>
                        <button type="submit" class="flex-1 rounded-xl bg-destructive px-4 py-2 text-sm text-destructive-foreground">Vymazať</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
