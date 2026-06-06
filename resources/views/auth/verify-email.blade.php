@extends('layouts.app')

@section('content')
    <div class="pt-8">
        <h1 class="font-display text-4xl">
            Over si email<span class="text-accent">.</span>
        </h1>
        <p class="mt-4 text-sm text-foreground">
            Skontroluj svoj email. Poslali sme ti potvrdzovací odkaz na
            <span class="font-semibold">{{ auth()->user()->email }}</span>. Klikni naň pre dokončenie registrácie.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mt-4 rounded-lg border border-border bg-card p-4 text-sm text-foreground">
                Email bol opätovne odoslaný
            </div>
        @endif

        <div class="mt-8 space-y-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)] transition">
                    Odoslať znova
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-center text-sm text-muted-foreground hover:text-foreground">
                    Späť na prihlásenie
                </button>
            </form>
        </div>
    </div>
@endsection
