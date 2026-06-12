@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Podpora</h1>
        <p class="mt-1 text-sm text-muted-foreground">Ozvi sa — sme tu pre teba.</p>
        <div class="mt-4 rounded-2xl border border-border bg-card p-5">
            <p class="text-sm leading-relaxed">
                Našiel si chybu alebo máš nápad? Napíš nám a my sa ozveme.
            </p>
            <a href="mailto:nuffy@nuffy.sk?subject=Nuffy%20support" class="mt-4 inline-flex items-center gap-2 rounded-full bg-accent px-4 py-2 text-sm font-medium text-accent-foreground">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                nuffy@nuffy.sk
            </a>
        </div>

        <div class="mt-4 rounded-2xl border border-border bg-card p-5">
            <div class="flex items-center gap-2 mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
                <h2 class="font-display text-base">Kontaktné údaje</h2>
            </div>

            <div class="space-y-4">
                <div>
                    <p class="text-xs uppercase tracking-wider text-muted-foreground mb-0.5">Spoločnosť</p>
                    <p class="text-sm">cari s.r.o.</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-wider text-muted-foreground mb-0.5">IČO</p>
                        <p class="text-sm">56 427 565</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider text-muted-foreground mb-0.5">DIČ</p>
                        <p class="text-sm">2122312511</p>
                    </div>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-wider text-muted-foreground mb-0.5">IČ DPH</p>
                    <p class="text-sm">SK2122312511 — podľa §7a, registrácia od 22.10.2024</p>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-wider text-muted-foreground mb-0.5">Sídlo</p>
                    <p class="text-sm leading-relaxed">cari s. r. o.<br>Boženy Němcovej 962/26<br>990 01 Veľký Krtíš</p>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-wider text-muted-foreground mb-0.5">Email</p>
                    <a href="mailto:nuffy@nuffy.sk" class="text-sm text-accent">nuffy@nuffy.sk</a>
                </div>
            </div>
        </div>
    </div>
@endsection
