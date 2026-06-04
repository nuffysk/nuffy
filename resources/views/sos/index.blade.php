@extends('layouts.app')

@section('content')
    <div class="pt-6" x-data="{ formOpen: false, info: false }">
        <h1 class="font-display text-3xl">Záchranná linka</h1>
        <p class="mt-1 text-sm text-muted-foreground">Stratené a nájdené psy.</p>

        @if (session('status'))<p class="mt-3 text-sm text-accent">{{ session('status') }}</p>@endif

        <button type="button" @click="info = !info" class="mt-4 flex w-full items-center justify-between rounded-2xl border border-border bg-card px-4 py-3 text-sm font-medium">
            <span>Čo robiť, keď nájdeš psa?</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" :class="info ? 'rotate-180' : ''" class="transition" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div x-show="info" x-transition class="mt-2 rounded-2xl border border-border bg-card p-4 text-sm leading-relaxed text-muted-foreground" style="display:none;">
            <ol class="list-decimal space-y-1 pl-5">
                <li>Skontroluj, či má psík obojok s kontaktom.</li>
                <li>Ak má čip, najbližší veterinár ho vie načítať.</li>
                <li>Daj fotku a popis tu na linku — komunita pomôže.</li>
                <li>V naliehavom prípade kontaktuj políciu (158) alebo útulok.</li>
            </ol>
        </div>

        <a href="{{ route('sos.help') }}" class="mt-3 block rounded-2xl border border-accent bg-[var(--heart-soft)] p-4">
            <p class="font-display text-lg">Potrebujú pomoc ♥</p>
            <p class="mt-1 text-sm text-muted-foreground">Psy v núdzi, ktoré hľadajú dočasku, jedlo či domov.</p>
        </a>

        <div class="mt-5 flex gap-2 rounded-full bg-card p-1 text-sm">
            <a href="{{ route('sos.index', ['kind' => 'found']) }}" class="flex-1 rounded-full px-4 py-2 text-center transition {{ $kind === 'found' ? 'bg-accent text-accent-foreground' : 'text-muted-foreground' }}">
                Nahlásiť nález
            </a>
            <a href="{{ route('sos.index', ['kind' => 'lost']) }}" class="flex-1 rounded-full px-4 py-2 text-center transition {{ $kind === 'lost' ? 'bg-accent text-accent-foreground' : 'text-muted-foreground' }}">
                Stratený / hľadám
            </a>
        </div>

        @auth
            <button type="button" @click="formOpen = !formOpen" class="mt-5 inline-flex w-full items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)]">
                <span x-show="!formOpen">+ {{ $kind === 'found' ? 'Nahlásiť nález' : 'Nahlásiť stratu' }}</span>
                <span x-show="formOpen" style="display:none;">Zatvoriť</span>
            </button>

            <form x-show="formOpen" x-transition method="POST" action="{{ route('sos.store') }}" enctype="multipart/form-data" class="mt-4 space-y-3 rounded-2xl border border-border bg-card p-4" style="display:none;">
                @csrf
                <input type="hidden" name="kind" value="{{ $kind }}">
                <div class="space-y-1">
                    <label class="text-sm font-medium">Meno psa</label>
                    <input type="text" name="dog_name" maxlength="40" placeholder="{{ $kind === 'found' ? 'napr. Bella (ak nevieš, nechaj prázdne)' : 'napr. Bella' }}" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm">
                    @if ($kind === 'found')
                        <p class="text-[11px] text-muted-foreground">Ak meno nevieš, automaticky uvedieme „nepoznáme“.</p>
                    @endif
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-medium">Popis</label>
                    <textarea name="description" rows="4" minlength="5" maxlength="1000" placeholder="Napr. nájdený malý hnedý psík bez obojka pri parku…" required class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm"></textarea>
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-medium">Mesto / lokalita</label>
                    <input type="text" name="city" maxlength="60" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm">
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-medium">Telefón</label>
                    <input type="tel" name="phone" maxlength="40" placeholder="+421…" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm">
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-medium">Instagram (voliteľné)</label>
                    <input type="text" name="instagram" maxlength="60" placeholder="@nuffy.sk" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm">
                </div>
                <div class="space-y-1">
                    <label class="text-sm font-medium">Fotka</label>
                    <input type="file" name="photo" accept="image/*" class="block w-full text-sm">
                </div>
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-accent px-4 py-2 text-sm font-medium text-accent-foreground">Odoslať</button>
            </form>
        @else
            <div class="mt-5 rounded-2xl border border-border bg-card p-4 text-sm text-muted-foreground">
                <a href="{{ route('login') }}" class="text-accent underline">Prihlás sa</a>, aby si mohol nahlásiť psíka.
            </div>
        @endauth

        @if ($cities->isNotEmpty())
            <div class="mt-5 flex flex-wrap gap-2 text-xs">
                <a href="{{ route('sos.index', ['kind' => $kind]) }}" class="rounded-full px-3 py-1 {{ ! $city ? 'bg-foreground text-background' : 'border border-border bg-card text-muted-foreground' }}">Všetky</a>
                @foreach ($cities as $c)
                    <a href="{{ route('sos.index', ['kind' => $kind, 'city' => $c]) }}" class="rounded-full px-3 py-1 {{ $city === $c ? 'bg-foreground text-background' : 'border border-border bg-card text-muted-foreground' }}">{{ $c }}</a>
                @endforeach
            </div>
        @endif

        <div class="mt-5 space-y-3">
            @forelse ($reports as $r)
                <article class="overflow-hidden rounded-2xl border border-border bg-card">
                    @if ($r->photo_url)
                        <img src="{{ $r->photo_url }}" alt="" class="block aspect-[16/9] w-full object-cover">
                    @endif
                    <div class="p-4">
                        <div class="flex items-center gap-2">
                            <span class="rounded-full bg-[var(--heart-soft)] px-2 py-0.5 text-[10px] uppercase tracking-wider text-accent">{{ $r->kind === 'lost' ? 'Stratený' : 'Nájdený' }}</span>
                            @if ($r->city)<span class="text-xs text-muted-foreground">{{ $r->city }}</span>@endif
                            <span class="ml-auto text-xs text-muted-foreground">{{ $r->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="mt-2 whitespace-pre-line text-sm">{{ $r->description }}</p>
                        @if ($r->phone || $r->instagram || $r->contact)
                            <div class="mt-2 flex flex-wrap gap-3 text-xs text-muted-foreground">
                                @if ($r->phone)<a href="tel:{{ $r->phone }}" class="inline-flex items-center gap-1 text-foreground hover:text-accent">📞 {{ $r->phone }}</a>@endif
                                @if ($r->instagram)<a href="https://instagram.com/{{ ltrim($r->instagram, '@') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-foreground hover:text-accent">📷 @{{ ltrim($r->instagram, '@') }}</a>@endif
                                @if ($r->contact)<span class="text-foreground">{{ $r->contact }}</span>@endif
                            </div>
                        @endif
                        @auth
                            @if ($r->reporter && $r->reporter_id !== auth()->id())
                                <a href="{{ route('inbox.show', $r->reporter) }}" class="mt-3 inline-flex items-center gap-1.5 rounded-full border border-border bg-card px-3 py-1.5 text-xs font-medium hover:bg-muted">
                                    💬 Napísať {{ $r->reporter->display_name ?? $r->reporter->name }}
                                </a>
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
    </div>
@endsection
