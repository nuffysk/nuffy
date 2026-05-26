@extends('layouts.app')

@section('content')
    <div class="pt-6" x-data="{ confirm: false }">
        <a href="{{ route('settings') }}" class="inline-flex items-center gap-1 rounded-full border border-border bg-card px-3 py-1.5 text-sm hover:bg-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Späť
        </a>
        <h1 class="mt-4 font-display text-3xl">Účet</h1>

        @if (session('status'))<p class="mt-2 text-sm text-accent">{{ session('status') }}</p>@endif

        <div class="mt-6 space-y-3">
            <a href="{{ route('settings.export') }}" class="flex items-center justify-between rounded-2xl border border-border bg-card px-4 py-4 text-sm font-medium hover:bg-muted">
                Exportovať moje dáta
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center justify-between rounded-2xl border border-border bg-card px-4 py-4 text-sm font-medium hover:bg-muted">
                    Odhlásiť sa
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                </button>
            </form>

            <button @click="confirm = true" class="flex w-full items-center justify-between rounded-2xl border border-destructive bg-card px-4 py-4 text-sm font-medium text-destructive hover:bg-muted">
                Zmazať účet
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6 l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/></svg>
            </button>
        </div>

        <div x-show="confirm" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4" style="display: none;">
            <div class="w-full max-w-sm rounded-2xl bg-card p-5 shadow-2xl">
                <h2 class="font-display text-xl">Naozaj zmazať účet?</h2>
                <p class="mt-2 text-sm text-muted-foreground">Táto akcia je nezvratná. Všetky tvoje dáta budú odstránené.</p>
                <form method="POST" action="{{ route('settings.account.delete') }}" class="mt-4 space-y-3">
                    @csrf
                    @method('DELETE')
                    <input type="password" name="password" placeholder="Tvoje heslo" required class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm">
                    @error('password')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
                    <div class="flex gap-2">
                        <button type="button" @click="confirm = false" class="flex-1 rounded-xl border border-border bg-card px-4 py-2 text-sm">Zrušiť</button>
                        <button type="submit" class="flex-1 rounded-xl bg-destructive px-4 py-2 text-sm text-destructive-foreground">Zmazať</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
