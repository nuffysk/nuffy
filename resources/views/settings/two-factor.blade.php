@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <a href="{{ route('settings') }}" class="inline-flex items-center gap-1 rounded-full border border-border bg-card px-3 py-1.5 text-sm hover:bg-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Späť
        </a>
        <h1 class="mt-4 font-display text-3xl">Dvojfaktorová autentifikácia</h1>

        <div class="mt-6 space-y-4 rounded-2xl border border-border bg-card p-5">
            <div class="flex items-start gap-3">
                <div class="rounded-full bg-[var(--heart-soft)] p-2 text-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div>
                    <h2 class="font-display text-lg">Pripravujeme</h2>
                    <p class="mt-1 text-sm text-muted-foreground">
                        2FA cez aplikácie ako Google Authenticator alebo Authy pridávame v najbližšej aktualizácii.
                        Účet zatiaľ chráň silným heslom (min. 8 znakov, kombinácia veľkých/malých písmen, čísel).
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-4 rounded-2xl border border-border bg-background p-4 text-xs text-muted-foreground">
            <p class="font-medium text-foreground">Tip na bezpečnosť:</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                <li>Používaj unikátne heslo, ktoré nepoužívaš nikde inde.</li>
                <li>Aktivuj automatické odhlásenie po nečinnosti (už zapnuté pre tvoj účet).</li>
                <li>Pravidelne kontroluj zariadenia, ktoré sú prihlásené.</li>
            </ul>
        </div>
    </div>
@endsection
