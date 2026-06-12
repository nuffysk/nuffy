@extends('layouts.app')

@section('content')
    <div class="pt-8">
        <h1 class="font-display text-3xl">
            Vymazať účet<span class="text-accent">?</span>
        </h1>

        <div class="mt-4 rounded-2xl border border-destructive/30 bg-destructive/10 p-4 text-sm text-foreground">
            <p>
                Po potvrdení budú <strong>natrvalo vymazané</strong> všetky tvoje údaje, príspevky a história aktivity.
                Tento krok je <strong>nevratný</strong>.
            </p>
        </div>

        <form method="POST" action="{{ request()->fullUrl() }}" class="mt-8 space-y-3">
            @csrf
            <button type="submit"
                class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-destructive px-6 py-3 text-base font-medium text-white shadow-[var(--shadow-heart)] transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                Áno, vymazať môj účet
            </button>

            <a href="{{ route('home') }}" class="block w-full text-center text-sm text-muted-foreground hover:text-foreground">
                Nie, ponechať účet
            </a>
        </form>
    </div>
@endsection
