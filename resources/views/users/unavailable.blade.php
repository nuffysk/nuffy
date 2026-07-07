@extends('layouts.app')

@section('content')
    <div class="pt-10 text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-muted text-muted-foreground">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m4.9 4.9 14.2 14.2"/></svg>
        </div>
        <h1 class="mt-4 font-display text-2xl">Tento profil nie je dostupný</h1>

        @if ($iBlocked)
            <p class="mx-auto mt-2 max-w-sm text-sm text-muted-foreground">
                Tohto používateľa máš zablokovaného. Blokovanie môžeš zrušiť v nastaveniach.
            </p>
            <div class="mt-6 flex flex-col items-center gap-3">
                <form method="POST" action="{{ route('users.unblock', $user) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-2xl border border-border bg-card px-5 py-2.5 text-sm font-medium transition hover:bg-muted">
                        Odblokovať používateľa
                    </button>
                </form>
                <a href="{{ route('settings.blocked') }}" class="text-sm text-muted-foreground hover:text-foreground">Spravovať blokovania</a>
            </div>
        @else
            <p class="mx-auto mt-2 max-w-sm text-sm text-muted-foreground">
                Profil si nemôžeš pozrieť.
            </p>
            <a href="{{ route('home') }}" class="mt-6 inline-block text-sm text-accent hover:underline">Späť na Nuffy</a>
        @endif
    </div>
@endsection
