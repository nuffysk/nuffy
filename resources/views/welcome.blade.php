@extends('layouts.app')

@section('content')
    @guest
        <section class="pt-6">
            <p class="mb-3 text-xs uppercase tracking-[0.22em] text-muted-foreground">Pre ľudí a ich psíkov</p>
            <h1 class="font-display text-5xl leading-[1.02]">
                Nájdi psíkovi
                <br>
                <span class="italic text-accent">nových kamošov.</span>
            </h1>
            <p class="mt-5 text-base leading-relaxed text-muted-foreground">
                Upgrade-ni život svojmu psovi s Ňuffy! Venčenie na pár klikov. Kamoši bez námahy. Záchranná linka, či užitočné videá z projektu Zavoditko. Toto všetko + starostlivosť na jednom mieste. Salóny, škôlky pre psov, či hotely. Spoznaj Ňuffy ešte dnes!
            </p>
            <div class="mt-8 overflow-hidden rounded-3xl border border-border shadow-[var(--shadow-soft)]">
                <img src="{{ asset('img/nuffy-bubble.jpg') }}" alt="Ňuffy logo" class="block w-full aspect-[16/9] object-cover">
            </div>
            <div class="mt-8 flex flex-col gap-3">
                <a
                    href="{{ route('register') }}"
                    role="button"
                    class="inline-flex items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)] transition"
                >
                    Vytvoriť profil
                </a>
                <a
                    href="{{ route('login') }}"
                    role="button"
                    class="inline-flex items-center justify-center rounded-2xl border border-border bg-card px-6 py-3 text-base font-medium text-foreground transition hover:bg-muted"
                >
                    Prihlásiť sa
                </a>
            </div>
            <div class="mt-6 flex flex-wrap justify-center gap-2">
                <a href="/privacy" class="rounded-full border border-border bg-card px-4 py-2 text-xs font-medium text-foreground shadow-[var(--shadow-card)] transition hover:bg-muted">
                    Podmienky ochrany súkromia
                </a>
                <a href="/terms" class="rounded-full border border-border bg-card px-4 py-2 text-xs font-medium text-foreground shadow-[var(--shadow-card)] transition hover:bg-muted">
                    Podmienky používania
                </a>
            </div>
        </section>
    @endguest

    @auth
        <section class="pt-4 animate-float-in">
            <p class="text-sm text-muted-foreground">Ahoj {{ auth()->user()->display_name ?? auth()->user()->name ?? 'priateľu' }} 👋</p>
            <h1 class="mt-1 font-display text-4xl">
                Čo dnes <span class="italic text-accent">podnikneme?</span>
            </h1>
        </section>

        <section class="mt-5 overflow-hidden rounded-3xl border border-border shadow-[var(--shadow-soft)]">
            <img src="{{ asset('img/nuffy-bubble.jpg') }}" alt="Ňuffy" class="block w-full aspect-[16/9] object-cover" width="1024" height="1024">
        </section>

        <section class="mt-6 grid grid-cols-3 gap-3">
            @php
                $tiles = [
                    ['to' => '/profile',  'label' => 'Tvoj profil',         'accent' => true,  'svg' => '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>'],
                    ['to' => '/sos',      'label' => 'SOS linka',                              'svg' => '<path d="M7 18v-6a5 5 0 1 1 10 0v6"/><path d="M5 21a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1z"/>'],
                    ['to' => '/learn',    'label' => 'Zavoditko',                              'svg' => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>'],
                    ['to' => '/friends',  'label' => 'Kamoši',                                 'svg' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>'],
                    ['to' => '/places',   'label' => 'Hotel & škôlka',                         'svg' => '<path d="M3 7v11a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7"/><path d="M22 11H2"/><path d="M5 7V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2"/>'],
                    ['to' => '/walks',    'label' => 'Fórum',               'accent' => true,  'svg' => '<path d="M4 16.5 12 21l8-4.5"/><path d="M4 12l8 4.5L20 12"/><path d="M4 7.5 12 12l8-4.5L12 3z"/>'],
                    ['to' => '/novinky',  'label' => 'Novinky',                                'svg' => '<path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8z"/>'],
                    ['to' => '/support',  'label' => 'Podpora a kontakty',                     'svg' => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4"/><line x1="4.93" x2="9.17" y1="4.93" y2="9.17"/><line x1="14.83" x2="19.07" y1="14.83" y2="19.07"/><line x1="14.83" x2="19.07" y1="9.17" y2="4.93"/><line x1="4.93" x2="9.17" y1="19.07" y2="14.83"/>'],
                    ['to' => '/settings', 'label' => 'Nastavenia',                             'svg' => '<path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/>'],
                ];
            @endphp
            @foreach ($tiles as $tile)
                <a
                    href="{{ $tile['to'] }}"
                    class="flex flex-col items-center justify-center gap-2 rounded-2xl border border-border p-3 text-center shadow-[var(--shadow-card)] transition hover:-translate-y-0.5 hover:shadow-[var(--shadow-soft)] {{ ! empty($tile['accent']) ? 'bg-[var(--heart-soft)]' : 'bg-card' }}"
                    style="aspect-ratio: 1 / 1;"
                >
                    <x-heart-icon :active="! empty($tile['accent'])" size="md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $tile['svg'] !!}</svg>
                    </x-heart-icon>
                    <p class="font-display text-sm leading-tight line-clamp-2">{{ $tile['label'] }}</p>
                </a>
            @endforeach
        </section>
    @endauth
@endsection
