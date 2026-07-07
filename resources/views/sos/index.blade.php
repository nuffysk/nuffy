@extends('layouts.app')

@section('content')
    <div class="pt-6" x-data="{ phoneConsent: false, contact: null }">
        <h1 class="font-display text-3xl">Záchranná linka</h1>
        <p class="mt-1 text-sm text-muted-foreground">Pomôžme strateným a nájdeným psíkom späť domov 🐾</p>

        @if (session('status'))<p class="mt-3 text-sm text-accent">{{ session('status') }}</p>@endif

        {{-- Tipy --}}
        <section class="mt-4 rounded-2xl border border-border bg-card p-4">
            <details class="group">
                <summary class="flex cursor-pointer list-none items-center justify-between gap-2 text-accent">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 18v-6a5 5 0 1 1 10 0v6"/><path d="M5 21a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1 1 1 0 0 0-1-1H6a1 1 0 0 0-1 1"/><path d="M21 12h1"/><path d="M18.5 4.5 18 5"/><path d="M2 12h1"/><path d="M12 2v1"/><path d="m4.929 4.929.707.707"/><path d="M12 12v6"/></svg>
                        <p class="font-display text-base">Čo robiť pri náleze</p>
                    </div>
                    <span class="grid h-6 w-6 place-items-center rounded-full bg-accent text-sm font-bold text-accent-foreground shadow-[var(--shadow-soft)] transition group-open:rotate-180">▾</span>
                </summary>
                <p class="mt-2 text-xs leading-relaxed text-muted-foreground">
                    Pri nájdení túlavého psa kontaktuj Mestskú políciu (159) alebo obecný úrad — zo zákona
                    sa o psa musí postarať obec.
                </p>
                <div class="mt-3 space-y-2 border-t border-border pt-3 text-xs leading-relaxed text-muted-foreground">
                    <p class="text-[11px] font-medium uppercase tracking-wide text-accent">Celé znenie</p>
                    <p>
                        Zákonný postup pri nájdení túlavého alebo zraneného psa je v Slovenskej republike
                        striktne definovaný zákonom č. 39/2007 Z. z. o veterinárnej starostlivosti.
                    </p>
                    <p>Tu sú presné zákonné fakty a postup:</p>
                    <p class="font-medium text-foreground">
                        1. Povinnosť obce (Zákon č. 39/2007 Z. z., § 22)
                    </p>
                    <p>
                        Podľa § 22 ods. 10 tohto zákona je obec povinná zabezpečiť odchyt túlavých zvierat na
                        svojom území a ich umiestnenie do karanténnej stanice alebo útulku pre zvieratá.
                    </p>
                    <p>
                        <span class="font-medium text-foreground">Kto vykonáva odchyt:</span> Odchyt môže
                        vykonávať len odborne spôsobilá osoba schválená Štátnou veterinárnou a potravinovou
                        správou SR.
                    </p>
                    <p>
                        <span class="font-medium text-foreground">Kam volať:</span> V praxi to znamená
                        kontaktovať Mestskú políciu (číslo 159) alebo obecný úrad. Obec má zákonnú povinnosť
                        postarať sa o psa bez ohľadu na to, či je pracovný deň, víkend alebo sviatok.
                    </p>
                </div>
            </details>
        </section>

        {{-- Odkaz na podstránku Potrebujú pomoc --}}
        <a href="{{ route('sos.help') }}" class="mt-3 flex items-center gap-3 rounded-2xl border border-border bg-gradient-to-br from-[var(--heart-soft)] to-card p-4 shadow-[var(--shadow-soft)] transition active:scale-[0.99]">
            <div class="grid h-11 w-11 place-items-center rounded-full bg-accent text-accent-foreground shadow-[var(--shadow-soft)]">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 14h2a2 2 0 0 1 0 4h-3c-.6 0-1.1.2-1.4.6L7 21"/><path d="m7 18 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9"/><path d="m2 15 6 6"/><path d="M19.5 8.5c.7-.7 1.5-1.6 1.5-2.7A2.73 2.73 0 0 0 16 4a2.78 2.78 0 0 0-5 1.8c0 1.2.8 2 1.5 2.8L16 12Z"/></svg>
            </div>
            <div class="min-w-0 flex-1">
                <p class="font-display text-base">Potrebujú pomoc</p>
                <p class="text-xs text-muted-foreground">Zranení, opustení alebo hľadajú nový domov 💛</p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="text-muted-foreground" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </a>

        {{-- Tabs --}}
        <div class="mt-6 grid grid-cols-2 gap-2 rounded-full bg-muted p-1">
            <a href="{{ route('sos.index', ['kind' => 'found']) }}" class="flex items-center justify-center gap-1.5 rounded-full px-3 py-2 text-sm font-medium transition {{ $kind === 'found' ? 'bg-card text-foreground shadow-[var(--shadow-soft)]' : 'text-muted-foreground' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="4" r="2"/><circle cx="18" cy="8" r="2"/><circle cx="20" cy="16" r="2"/><path d="M9 10a5 5 0 0 1 5 5v3.5a3.5 3.5 0 0 1-6.84 1.045Q6.52 17.48 4.46 16.84A3.5 3.5 0 0 1 5.5 10Z"/></svg>
                Nahlásiť nález
            </a>
            <a href="{{ route('sos.index', ['kind' => 'lost']) }}" class="flex items-center justify-center gap-1.5 rounded-full px-3 py-2 text-sm font-medium transition {{ $kind === 'lost' ? 'bg-card text-foreground shadow-[var(--shadow-soft)]' : 'text-muted-foreground' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg>
                Stratený / hľadám
            </a>
        </div>

        {{-- Formulár --}}
        @auth
            <form method="POST" action="{{ route('sos.store') }}" enctype="multipart/form-data" class="mt-4 space-y-4 rounded-3xl border border-border bg-card p-5 shadow-[var(--shadow-soft)]">
                @csrf
                <input type="hidden" name="kind" value="{{ $kind }}">

                @if ($errors->any())
                    <div class="rounded-xl border border-destructive/40 bg-destructive/10 p-3 text-sm text-destructive">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="flex items-center gap-2">
                    @if ($kind === 'found')
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="text-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="4" r="2"/><circle cx="18" cy="8" r="2"/><circle cx="20" cy="16" r="2"/><path d="M9 10a5 5 0 0 1 5 5v3.5a3.5 3.5 0 0 1-6.84 1.045Q6.52 17.48 4.46 16.84A3.5 3.5 0 0 1 5.5 10Z"/></svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="text-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg>
                    @endif
                    <h3 class="font-display text-lg">{{ $kind === 'found' ? 'Nahlásiť nález' : 'Nahlásiť stratu' }}</h3>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium">Meno psa</label>
                    <input type="text" name="dog_name" maxlength="40" value="{{ old('dog_name') }}" placeholder="{{ $kind === 'found' ? 'napr. Bella (ak nevieš, nechaj prázdne)' : 'napr. Bella' }}" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm">
                    @if ($kind === 'found')
                        <p class="text-[11px] text-muted-foreground">Ak meno nevieš, automaticky uvedieme „nepoznáme“.</p>
                    @endif
                </div>
                <div class="space-y-2" x-data="{ desc: @js(old('description', '')) }">
                    <label class="text-sm font-medium">Popis</label>
                    <textarea name="description" x-model="desc" rows="4" minlength="5" maxlength="1000" placeholder="{{ $kind === 'found' ? 'Pes, čierny, bez obojku, pri autobusovej zastávke…' : 'Naša Bella, hnedý kríženec, utiekla z dvora…' }}" required class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm">{{ old('description') }}</textarea>
                    <p class="text-[11px]" :class="desc.trim().length > 0 && desc.trim().length < 5 ? 'text-destructive' : 'text-muted-foreground'">
                        Popis musí mať aspoň 5 znakov (<span x-text="desc.trim().length"></span>/5).
                    </p>
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium">Mesto / lokalita</label>
                    <input type="text" name="city" maxlength="60" value="{{ old('city') }}" placeholder="Bratislava" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm">
                </div>
                <div class="space-y-2" x-data="{
                    preview: null,
                    tooBig: false,
                    pick(e) {
                        const f = e.target.files[0];
                        if (! f) { this.preview = null; this.tooBig = false; return; }
                        this.tooBig = f.size > 5 * 1024 * 1024;
                        this.preview = URL.createObjectURL(f);
                    }
                }">
                    <label class="text-sm font-medium">Fotka (voliteľné)</label>
                    <input id="sos-file" type="file" name="photo" accept="image/*" class="block w-full text-sm" x-on:change="pick($event)">
                    <template x-if="preview">
                        <img :src="preview" alt="Náhľad" class="mt-2 max-h-56 w-full rounded-xl object-cover">
                    </template>
                    <p x-show="tooBig" class="text-sm text-destructive" style="display:none;">Fotka je väčšia ako 5 MB — vyber menšiu.</p>
                    <p class="text-[11px] text-muted-foreground">Fotka môže mať najviac 5 MB (JPG, PNG).</p>
                    @error('photo')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
                </div>
                <div class="space-y-3 rounded-2xl border border-border bg-muted/30 p-4">
                    <label class="text-sm font-medium">Telefónne číslo (voliteľné)</label>
                    <label class="flex items-start gap-2 text-[12px] leading-relaxed text-muted-foreground">
                        <input type="checkbox" name="phone_consent" value="1" x-model="phoneConsent" class="mt-0.5 h-4 w-4 rounded border-input text-accent">
                        <span>
                            {{ $kind === 'lost'
                                ? 'Súhlasím so zverejnením môjho telefónneho čísla pre registrovaných používateľov nuffy.sk za účelom nájdenia môjho strateného psa. Beriem na vedomie, že telefónne číslo bude automaticky vymazané spolu s inzerátom po 30 dňoch od jeho zverejnenia. Súhlas môžem kedykoľvek odvolať kontaktovaním prevádzkovateľa na'
                                : 'Súhlasím so zverejnením môjho telefónneho čísla pre registrovaných používateľov nuffy.sk za účelom nájdenia majiteľa nájdeného psa. Beriem na vedomie, že telefónne číslo bude automaticky vymazané spolu s inzerátom po 30 dňoch od jeho zverejnenia. Súhlas môžem kedykoľvek odvolať kontaktovaním prevádzkovateľa na' }}
                            <a href="mailto:nuffy@nuffy.sk" class="text-accent underline">nuffy@nuffy.sk</a>.
                        </span>
                    </label>
                    <input type="tel" name="phone" maxlength="30" placeholder="+421 900 123 456" :disabled="!phoneConsent" :class="!phoneConsent ? 'opacity-60' : ''" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm">
                    <p x-show="!phoneConsent" class="text-[11px] text-muted-foreground">
                        Najprv prosím odsúhlas podmienky vyššie, potom môžeš zadať telefónne číslo.
                    </p>
                </div>
                <p class="text-[11px] leading-relaxed text-muted-foreground">
                    Odoslaním formulára súhlasíš so spracovaním osobných údajov a zverejnením fotografií v rámci aplikácie.
                </p>
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)]">
                    {{ $kind === 'found' ? 'Odoslať nález ❤️' : 'Zverejniť hľadanie 💛' }}
                </button>
            </form>
        @else
            <form method="POST" action="{{ route('sos.store') }}" enctype="multipart/form-data" class="mt-4 space-y-4 rounded-3xl border border-border bg-card p-5 shadow-[var(--shadow-soft)]" onsubmit="return false;">
                <div class="flex items-center gap-2">
                    @if ($kind === 'found')
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="text-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="4" r="2"/><circle cx="18" cy="8" r="2"/><circle cx="20" cy="16" r="2"/><path d="M9 10a5 5 0 0 1 5 5v3.5a3.5 3.5 0 0 1-6.84 1.045Q6.52 17.48 4.46 16.84A3.5 3.5 0 0 1 5.5 10Z"/></svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="text-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21 21-4.34-4.34"/><circle cx="11" cy="11" r="8"/></svg>
                    @endif
                    <h3 class="font-display text-lg">{{ $kind === 'found' ? 'Nahlásiť nález' : 'Nahlásiť stratu' }}</h3>
                </div>
                <p class="text-xs text-muted-foreground">
                    Pre odoslanie sa najprv <a href="{{ route('login') }}" class="text-accent underline">prihlás</a>.
                </p>
            </form>
        @endauth

        {{-- Filter podľa mesta --}}
        @if ($cities->isNotEmpty())
            <div class="mt-5 flex flex-wrap gap-2 text-xs">
                <a href="{{ route('sos.index', ['kind' => $kind]) }}" class="rounded-full px-3 py-1 {{ ! $city ? 'bg-foreground text-background' : 'border border-border bg-card text-muted-foreground' }}">Všetky</a>
                @foreach ($cities as $c)
                    <a href="{{ route('sos.index', ['kind' => $kind, 'city' => $c]) }}" class="rounded-full px-3 py-1 {{ $city === $c ? 'bg-foreground text-background' : 'border border-border bg-card text-muted-foreground' }}">{{ $c }}</a>
                @endforeach
            </div>
        @endif

        {{-- Feed hlásení --}}
        <div class="mt-5 space-y-3">
            @forelse ($reports as $r)
                <article class="overflow-hidden rounded-2xl border border-border bg-card">
                    @if ($r->photo_url)
                        <img src="{{ $r->photo_url }}" alt="" class="block aspect-[16/9] w-full object-cover">
                    @endif
                    <div class="p-4">
                        <div class="flex items-center gap-2">
                            <span class="rounded-full bg-[var(--heart-soft)] px-2 py-0.5 text-[10px] uppercase tracking-wider text-accent">{{ $r->kind === 'lost' ? 'Stratený' : 'Nájdený' }}</span>
                            @if ($r->city)
                                <span class="inline-flex items-center gap-1 text-xs text-muted-foreground">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                                    {{ $r->city }}
                                </span>
                            @endif
                            <span class="ml-auto text-xs text-muted-foreground">{{ $r->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="mt-2 whitespace-pre-line text-sm">{{ $r->description }}</p>
                        @if ($r->phone || $r->contact)
                            <div class="mt-2 flex flex-wrap gap-3 text-xs text-muted-foreground">
                                @if ($r->phone)<a href="tel:{{ $r->phone }}" class="inline-flex items-center gap-1 text-foreground hover:text-accent">📞 {{ $r->phone }}</a>@endif
                                @if ($r->contact)<span class="text-foreground">{{ $r->contact }}</span>@endif
                            </div>
                        @endif
                        @auth
                            @if ($r->reporter && $r->reporter_id !== auth()->id())
                                <button type="button"
                                    @click="contact = { id: {{ $r->reporter_id }}, name: @js($r->reporter->display_name ?? $r->reporter->name), kind: '{{ $r->kind }}', desc: @js($r->description) }"
                                    class="mt-3 inline-flex items-center gap-1.5 rounded-full border border-border bg-card px-3 py-1.5 text-xs font-medium hover:bg-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                                    {{ $r->kind === 'found' ? 'Kontaktovať nálezcu' : 'Kontaktovať majiteľa' }}
                                </button>
                            @endif
                        @endauth
                        @php
                            $typLabel = $r->kind === 'found' ? 'Nájdený pes' : 'Stratený pes';
                            $menoPsa = 'Neznámy';
                            if (preg_match('/^Meno:\s*(.+)$/mu', $r->description, $m)) {
                                $n = trim($m[1]);
                                if ($n !== '' && mb_strtolower($n) !== 'nepoznáme') {
                                    $menoPsa = $n;
                                }
                            }
                            $neaktBody = "🐾 Nový podnet od používateľa\n\n"
                                ."Niekto nahlásil inzerát na nuffy.sk ako neaktuálny. Tu sú podrobnosti:\n\n"
                                ."📋 Detaily inzerátu\n\n"
                                ."Typ: {$typLabel}\n"
                                ."Meno psa: {$menoPsa}\n"
                                ."Lokalita: ".($r->city ?: '—')."\n"
                                ."Dátum zverejnenia: ".$r->created_at->format('d.m.Y')."\n"
                                ."Dôvod nahlásenia: [doplň dôvod]\n\n"
                                ."👤 Nahlásil\n\n"
                                ."Používateľ: [doplň meno/email]\n"
                                ."Dátum nahlásenia: ".now()->format('d.m.Y, H:i:s')."\n\n"
                                ."—\nTento email bol automaticky vygenerovaný platformou nuffy.sk.";
                            $neaktMailto = 'mailto:nuffy@nuffy.sk?subject='.rawurlencode("Nový podnet – neaktuálny inzerát: {$menoPsa}").'&body='.rawurlencode($neaktBody);
                        @endphp
                        <div class="mt-5 flex flex-col items-center gap-1.5">
                            <a href="{{ $neaktMailto }}" class="inline-flex items-center gap-1.5 rounded-full bg-[#C4622D]/10 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-wide text-[#C4622D] shadow-[var(--shadow-soft)] transition hover:bg-[#C4622D]/15 active:scale-[0.98]">
                                NEAKTUÁLNE
                            </a>
                            <p class="text-[11px] text-muted-foreground">Neaktuálny prípad nahlás tu</p>
                        </div>
                    </div>
                </article>
            @empty
                <p class="text-sm text-muted-foreground">Žiadne hlásenia v tejto kategórii.</p>
            @endforelse
        </div>

        {{-- ContactDialog --}}
        @auth
            <div x-show="contact" @keydown.escape.window="contact = null" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none;">
                <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="contact = null"></div>
                <div class="relative w-full max-w-sm rounded-2xl border border-border bg-card p-5 shadow-2xl">
                    <h2 class="font-display text-lg" x-text="contact && contact.kind === 'found' ? 'Kontaktovať nálezcu' : 'Kontaktovať majiteľa'"></h2>
                    <template x-if="contact">
                        <form method="POST" :action="'{{ url('/inbox') }}/' + contact.id" class="mt-3 space-y-3">
                            @csrf
                            <div class="rounded-2xl border border-border bg-muted/40 p-3 text-xs text-muted-foreground">
                                <p class="line-clamp-3" x-text="contact.desc"></p>
                            </div>
                            <textarea name="body" rows="4" maxlength="1000" placeholder="Napíš správu…" required class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm"
                                x-init="$el.value = contact.kind === 'found' ? 'Ahoj, myslím, že je to môj psík. Vieš mi o ňom povedať viac?' : 'Ahoj, asi som videl/a vášho psíka. Mohli by sme sa skontaktovať?'"></textarea>
                            <div class="flex justify-end gap-2">
                                <button type="button" @click="contact = null" class="inline-flex items-center justify-center rounded-xl px-4 py-2 text-sm font-medium text-muted-foreground hover:bg-muted">Zrušiť</button>
                                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-primary px-4 py-2 text-sm font-medium text-primary-foreground">Odoslať 💌</button>
                            </div>
                        </form>
                    </template>
                </div>
            </div>
        @endauth
    </div>
@endsection
