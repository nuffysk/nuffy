@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Cookies</h1>

        <section class="mt-4 space-y-3 text-sm leading-relaxed text-muted-foreground">
            <p>
                Na Nuffy.sk používame nevyhnutné cookies pre fungovanie stránky a — po tvojom súhlase —
                aj ďalšie (napr. štatistické). Súhlas spravuje Cookiebot. Môžeš ho kedykoľvek zmeniť
                alebo odvolať nižšie.
            </p>
        </section>

        @if (config('services.cookiebot.cbid'))
            <div class="mt-6">
                <button type="button" onclick="if(window.Cookiebot){window.Cookiebot.renew();}"
                    class="rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-primary-foreground transition hover:bg-primary/90">
                    Zmeniť nastavenia cookies
                </button>
            </div>

            <section class="mt-6 rounded-2xl border border-border bg-card p-5">
                <h2 class="font-display text-lg font-semibold text-foreground">Zoznam cookies</h2>
                <div class="mt-3 text-sm text-muted-foreground">
                    {{-- Cookiebot automaticky vygeneruje a udržiava tento zoznam --}}
                    <script id="CookieDeclaration"
                        src="https://consent.cookiebot.com/{{ config('services.cookiebot.cbid') }}/cd.js"
                        type="text/javascript" async></script>
                </div>
            </section>
        @else
            <section class="mt-6 rounded-2xl border border-border bg-card p-5 text-sm text-muted-foreground">
                Správa cookies sa zobrazí po nastavení Cookiebotu (premenná <code>COOKIEBOT_CBID</code>).
            </section>
        @endif
    </div>
@endsection
