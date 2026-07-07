@extends('layouts.app')

@section('content')
    <div class="pt-10 text-center">
        <h1 class="font-display text-3xl">Odhlásené <span class="text-accent">🐾</span></h1>
        <p class="mx-auto mt-4 max-w-sm text-sm text-muted-foreground">
            Už ti nebudeme posielať e-maily o kategórii <span class="font-medium text-foreground">{{ $label }}</span>.
            Nastavenia môžeš kedykoľvek zmeniť v profile.
        </p>

        <div class="mt-8 flex flex-col items-center gap-3">
            <a href="{{ route('settings.notifications') }}" class="inline-flex items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)]">
                Spravovať notifikácie
            </a>
            <a href="{{ route('home') }}" class="text-sm text-muted-foreground hover:text-foreground">Späť na Nuffy.sk</a>
        </div>
    </div>
@endsection
