@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Dvojfaktorové overenie</h1>

        <a href="{{ route('settings') }}" class="mt-2 inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            Späť na nastavenia
        </a>

        <div class="mt-6 space-y-4">
            <div class="flex items-start gap-3 rounded-2xl border border-border bg-card p-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 text-accent"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>
                <div class="text-sm">
                    <p class="font-medium text-foreground">
                        {{ $status === 'on' ? 'Dvojfaktorové overenie je zapnuté' : 'Dvojfaktorové overenie je vypnuté' }}
                    </p>
                    <p class="mt-1 text-muted-foreground">
                        Po zapnutí budeš pri každom prihlásení okrem hesla zadávať aj 6-ciferný kód
                        z autentifikačnej aplikácie (napr. Google Authenticator, Authy, 1Password).
                    </p>
                </div>
            </div>

            @if (session('status'))
                <p class="text-sm text-accent">{{ session('status') }}</p>
            @endif

            @if ($status === 'off')
                <form method="POST" action="{{ route('settings.two-factor.enable') }}">
                    @csrf
                    <button type="submit" class="w-full rounded-full bg-primary px-5 py-3 text-sm font-medium text-primary-foreground transition hover:opacity-90">
                        Zapnúť dvojfaktorové overenie
                    </button>
                </form>
            @endif

            @if ($status === 'on')
                <form method="POST" action="{{ route('settings.two-factor.disable') }}" onsubmit="return confirm('Naozaj chceš vypnúť dvojfaktorové overenie?')">
                    @csrf
                    <button type="submit" class="w-full rounded-full border border-border bg-card px-5 py-3 text-sm font-medium text-foreground transition hover:bg-muted">
                        Vypnúť dvojfaktorové overenie
                    </button>
                </form>
            @endif

            @if ($status === 'enrolling')
                <div class="space-y-4 rounded-2xl border border-border bg-card p-4">
                    <div>
                        <p class="text-sm font-medium text-foreground">Krok 1 — Naskenuj QR kód</p>
                        <p class="mt-1 text-xs text-muted-foreground">
                            Otvor svoju autentifikačnú aplikáciu (Google Authenticator, Authy,
                            1Password, Microsoft Authenticator…) a naskenuj kód nižšie.
                        </p>
                    </div>

                    @if ($qr)
                        <div class="flex justify-center rounded-xl bg-white p-4">
                            <img src="{{ $qr }}" alt="QR kód" class="h-48 w-48">
                        </div>
                    @endif

                    @if ($secret)
                        <div class="text-xs">
                            <p class="text-muted-foreground">Nemôžeš naskenovať? Zadaj tento kľúč ručne:</p>
                            <code class="mt-1 block break-all rounded bg-muted px-2 py-1 font-mono text-foreground">{{ $secret }}</code>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('settings.two-factor.confirm') }}" class="space-y-2">
                        @csrf
                        <label for="otp" class="text-sm font-medium">Krok 2 — Zadaj 6-ciferný kód z aplikácie</label>
                        <input
                            id="otp"
                            name="code"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            maxlength="6"
                            placeholder="123456"
                            required
                            autocomplete="one-time-code"
                            class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm"
                        >
                        @error('code')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
                        <div class="flex gap-2 pt-2">
                            <button type="submit" class="flex-1 rounded-full bg-primary px-5 py-3 text-sm font-medium text-primary-foreground transition hover:opacity-90">
                                Potvrdiť a zapnúť
                            </button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('settings.two-factor.disable') }}">
                        @csrf
                        <button type="submit" class="w-full rounded-full border border-border bg-card px-5 py-2 text-sm font-medium text-foreground transition hover:bg-muted">
                            Zrušiť
                        </button>
                    </form>
                </div>
            @endif

            <p class="px-1 text-xs text-muted-foreground">
                Tip: ulož si bezpečné miesto, kde máš prístup k autentifikačnej aplikácii.
                Bez prístupu k nej sa nebudeš môcť prihlásiť.
            </p>
        </div>
    </div>
@endsection
