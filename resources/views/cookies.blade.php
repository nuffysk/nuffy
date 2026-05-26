@extends('layouts.app')

@section('content')
    <div class="pt-6" x-data="cookieConsent()">
        <h1 class="font-display text-3xl">Cookies</h1>

        <section class="mt-4 space-y-3 text-sm leading-relaxed text-muted-foreground">
            <p>
                Tu bude doplnený text o cookies. (Obsah doplní prevádzkovateľ.)
            </p>
        </section>

        <section class="mt-6 rounded-2xl border border-border bg-card p-5">
            <h2 class="font-display text-lg font-semibold text-foreground">Tvoje aktuálne nastavenie</h2>
            <p class="mt-1 text-sm text-muted-foreground">
                Stav: <span class="font-medium text-foreground" x-text="label"></span>
            </p>

            <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                <button type="button" @click="update('accepted')" :class="consent === 'accepted' ? 'bg-primary text-primary-foreground' : 'border border-border bg-card'" class="flex-1 rounded-xl px-4 py-2 text-sm">
                    Súhlasím
                </button>
                <button type="button" @click="update('declined')" :class="consent === 'declined' ? 'bg-primary text-primary-foreground' : 'border border-border bg-card'" class="flex-1 rounded-xl px-4 py-2 text-sm">
                    Nesúhlasím
                </button>
            </div>

            <button type="button" @click="revoke()" :disabled="consent === null" :class="consent === null ? 'opacity-50 cursor-not-allowed' : ''" class="mt-3 w-full rounded-xl bg-transparent px-4 py-2 text-sm text-muted-foreground hover:bg-muted">
                Odvolať súhlas
            </button>

            <p class="mt-3 text-xs text-muted-foreground">
                Po odvolaní sa pri ďalšej návšteve znova zobrazí lišta s výberom.
            </p>
        </section>
    </div>

    <script>
        function cookieConsent() {
            const STORAGE_KEY = 'nuffy-cookie-consent';
            return {
                consent: null,
                get label() {
                    return this.consent === 'accepted' ? 'Súhlas udelený'
                        : this.consent === 'declined' ? 'Cookies odmietnuté'
                        : 'Bez rozhodnutia';
                },
                init() {
                    try { this.consent = localStorage.getItem(STORAGE_KEY); } catch (e) {}
                },
                update(v) {
                    try { localStorage.setItem(STORAGE_KEY, v); this.consent = v; } catch (e) {}
                },
                revoke() {
                    try { localStorage.removeItem(STORAGE_KEY); this.consent = null; } catch (e) {}
                },
            };
        }
    </script>
@endsection
