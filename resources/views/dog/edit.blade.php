@extends('layouts.app')

@section('content')
    @php
        $months = ['Január', 'Február', 'Marec', 'Apríl', 'Máj', 'Jún', 'Júl', 'August', 'September', 'Október', 'November', 'December'];
        $currentYear = (int) date('Y');
        $birth = old('birth_date', optional($dog->birth_date)->format('Y-m-d'));
        [$by, $bm, $bd] = $birth ? array_map('intval', explode('-', $birth)) : [null, null, null];
        $existingPhotos = $dog->photos ?? [];
    @endphp

    <div class="pt-4" x-data="{
        vaccinated: {{ old('vaccinated', $dog->vaccinated ? 1 : 0) }},
        d: {{ $bd ?: 'null' }},
        m: {{ $bm ?: 'null' }},
        y: {{ $by ?: 'null' }},
        get birthDate() {
            if (!this.d || !this.m || !this.y) return '';
            return this.y + '-' + String(this.m).padStart(2, '0') + '-' + String(this.d).padStart(2, '0');
        },
        get age() {
            if (!this.birthDate) return null;
            const b = new Date(this.birthDate);
            if (isNaN(b.getTime())) return null;
            const now = new Date();
            let years = now.getFullYear() - b.getFullYear();
            let months = now.getMonth() - b.getMonth();
            if (now.getDate() < b.getDate()) months--;
            if (months < 0) { years--; months += 12; }
            if (years < 0) return null;
            if (years === 0) return months + ' mes.';
            return years + ' r.';
        }
    }">
        <h1 class="font-display text-3xl">Profil ňuffka</h1>

        @if (session('status'))
            <p class="mt-2 text-sm text-accent">{{ session('status') }}</p>
        @endif

        @if ($errors->any())
            <div class="mt-3 rounded-xl border border-destructive/40 bg-destructive/10 p-3 text-sm text-destructive">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ $dog->exists ? route('dog.update', $dog) : route('dog.store') }}" enctype="multipart/form-data" class="mt-4 space-y-5">
            @csrf
            @if ($dog->exists) @method('PATCH') @endif
            <input type="hidden" name="birth_date" :value="birthDate">

            {{-- Meno psíka --}}
            <section class="rounded-2xl border border-border bg-card p-4 shadow-[var(--shadow-soft)]">
                <label for="name" class="text-xs uppercase tracking-wider text-muted-foreground">Meno psíka</label>
                <input id="name" name="name" type="text" maxlength="40" required value="{{ old('name', $dog->name) }}" placeholder="napr. Ňuffko" class="mt-2 block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">
                @error('name')<p class="mt-1 text-sm text-destructive">{{ $message }}</p>@enderror
            </section>

            {{-- Tvoj psík je --}}
            <section class="rounded-2xl border border-border bg-card p-4 shadow-[var(--shadow-soft)]">
                <span class="text-xs uppercase tracking-wider text-muted-foreground">Tvoj psík je</span>
                <div class="mt-2 grid grid-cols-2 gap-2">
                    @foreach (['male' => 'Chlapček', 'female' => 'Dievčatko'] as $val => $label)
                        <label @class([
                            'flex cursor-pointer items-center justify-center rounded-xl border px-3 py-3 text-sm font-medium transition',
                            'has-[:checked]:border-accent has-[:checked]:bg-[var(--heart-soft)] has-[:checked]:text-accent',
                            'border-border bg-background text-foreground',
                        ])>
                            <input type="radio" name="gender" value="{{ $val }}" {{ old('gender', $dog->gender) === $val ? 'checked' : '' }} class="sr-only">
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
            </section>

            {{-- Fotky --}}
            <section class="rounded-2xl border border-border bg-[var(--heart-medium)] p-4 shadow-[var(--shadow-soft)]" x-data="{
                previews: [],
                tooBig: false,
                pick(e) {
                    this.previews = [];
                    this.tooBig = false;
                    for (const f of e.target.files) {
                        if (f.size > 5 * 1024 * 1024) this.tooBig = true;
                        this.previews.push(URL.createObjectURL(f));
                    }
                }
            }">
                <span class="text-xs uppercase tracking-wider text-muted-foreground">Fotky</span>
                <div class="mt-2 grid grid-cols-4 gap-2">
                    @foreach ($existingPhotos as $i => $photo)
                        <div class="relative aspect-square overflow-hidden rounded-xl bg-muted">
                            <img src="{{ $photo }}" alt="" class="h-full w-full object-cover">
                            @if ($dog->exists)
                                <button type="submit" form="dog-photo-del-{{ $i }}" aria-label="Odstrániť fotku"
                                    onclick="return confirm('Odstrániť túto fotku?');"
                                    class="absolute right-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-black/50 text-white transition hover:bg-black/70">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                </button>
                            @endif
                        </div>
                    @endforeach
                    <template x-for="src in previews" :key="src">
                        <div class="relative aspect-square overflow-hidden rounded-xl bg-muted ring-2 ring-accent">
                            <img :src="src" alt="Náhľad" class="h-full w-full object-cover">
                        </div>
                    </template>
                    @if (count($existingPhotos) < 4)
                        <label class="flex aspect-square cursor-pointer items-center justify-center rounded-xl border-2 border-dashed border-border text-muted-foreground transition hover:border-accent hover:text-accent">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            <input type="file" name="photos[]" accept="image/*" multiple class="hidden" x-on:change="pick($event)">
                        </label>
                    @endif
                </div>
                <p x-show="tooBig" class="mt-1 text-sm text-destructive" style="display:none;">Niektorá fotka je väčšia ako 5 MB — vyber menšiu.</p>
                @error('photos.*')<p class="mt-1 text-sm text-destructive">{{ $message }}</p>@enderror
                <p class="mt-3 text-[11px] leading-relaxed text-muted-foreground">
                    Max 4 fotky, každá do 5 MB. Nahraním fotiek súhlasíš so spracovaním osobných údajov a zverejnením fotografií v rámci aplikácie.
                </p>
            </section>

            {{-- Narodeniny psíka --}}
            <section class="rounded-2xl border border-border bg-card p-4 shadow-[var(--shadow-soft)]">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xs uppercase tracking-wider text-muted-foreground">Narodeniny psíka</span>
                    <template x-if="age">
                        <span class="inline-flex items-center rounded-full bg-[var(--heart-soft)] px-2.5 py-0.5 text-xs font-medium text-accent" x-text="age"></span>
                    </template>
                </div>
                <div class="mt-2 grid grid-cols-3 gap-2">
                    <select x-model.number="d" class="w-full rounded-xl border border-border bg-background px-2 py-2 text-sm focus:border-accent focus:outline-none">
                        <option value="">Deň</option>
                        @for ($n = 1; $n <= 31; $n++)<option value="{{ $n }}">{{ $n }}</option>@endfor
                    </select>
                    <select x-model.number="m" class="w-full rounded-xl border border-border bg-background px-2 py-2 text-sm focus:border-accent focus:outline-none">
                        <option value="">Mesiac</option>
                        @foreach ($months as $i => $name)<option value="{{ $i + 1 }}">{{ $name }}</option>@endforeach
                    </select>
                    <select x-model.number="y" class="w-full rounded-xl border border-border bg-background px-2 py-2 text-sm focus:border-accent focus:outline-none">
                        <option value="">Rok</option>
                        @for ($n = $currentYear; $n >= 1990; $n--)<option value="{{ $n }}">{{ $n }}</option>@endfor
                    </select>
                </div>
            </section>

            {{-- Plemeno --}}
            <section class="rounded-2xl border border-border bg-card p-4 shadow-[var(--shadow-soft)]">
                <label for="breed" class="text-xs uppercase tracking-wider text-muted-foreground">Plemeno</label>
                <input id="breed" name="breed" type="text" maxlength="60" value="{{ old('breed', $dog->breed) }}" placeholder="napr. kríženec" class="mt-2 block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">
            </section>

            {{-- Veľkosť --}}
            <section class="rounded-2xl border border-border bg-card p-4 shadow-[var(--shadow-soft)]">
                <span class="text-xs uppercase tracking-wider text-muted-foreground">Veľkosť</span>
                <div class="mt-2 grid grid-cols-3 gap-2">
                    @foreach (['small' => ['Malá', 'pod 14 kg'], 'medium' => ['Stredná', '14–30 kg'], 'large' => ['Veľká', 'nad 30 kg']] as $val => $labelPair)
                        <label @class([
                            'flex cursor-pointer flex-col items-center rounded-2xl border p-3 text-center transition',
                            'has-[:checked]:border-accent has-[:checked]:bg-[var(--heart-soft)]',
                            'border-border bg-background',
                        ])>
                            <input type="radio" name="size" value="{{ $val }}" {{ old('size', $dog->size) === $val ? 'checked' : '' }} class="sr-only">
                            <span class="text-sm font-medium">{{ $labelPair[0] }}</span>
                            <span class="text-xs text-muted-foreground">{{ $labelPair[1] }}</span>
                        </label>
                    @endforeach
                </div>
            </section>

            {{-- Psík je kastrovaný? --}}
            <section class="rounded-2xl border border-border bg-card p-4 shadow-[var(--shadow-soft)]">
                <span class="text-xs uppercase tracking-wider text-muted-foreground">Psík je kastrovaný?</span>
                <div class="mt-2 grid grid-cols-2 gap-2">
                    @foreach ([1 => 'Áno', 0 => 'Nie'] as $val => $label)
                        <label @class([
                            'flex cursor-pointer items-center justify-center rounded-xl border px-3 py-3 text-sm font-medium transition',
                            'has-[:checked]:border-accent has-[:checked]:bg-[var(--heart-soft)] has-[:checked]:text-accent',
                            'border-border bg-background text-foreground',
                        ])>
                            <input type="radio" name="neutered" value="{{ $val }}" {{ (string) old('neutered', $dog->neutered ? 1 : 0) === (string) $val ? 'checked' : '' }} class="sr-only">
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
            </section>

            {{-- Psík je očkovaný? --}}
            <section class="rounded-2xl border border-border bg-card p-4 shadow-[var(--shadow-soft)]">
                <span class="text-xs uppercase tracking-wider text-muted-foreground">Psík je očkovaný?</span>
                <div class="mt-2 grid grid-cols-2 gap-2">
                    @foreach ([1 => 'Áno', 0 => 'Nie'] as $val => $label)
                        <label @class([
                            'flex cursor-pointer items-center justify-center rounded-xl border px-3 py-3 text-sm font-medium transition',
                            'has-[:checked]:border-accent has-[:checked]:bg-[var(--heart-soft)] has-[:checked]:text-accent',
                            'border-border bg-background text-foreground',
                        ])>
                            <input type="radio" name="vaccinated" value="{{ $val }}" {{ (string) old('vaccinated', $dog->vaccinated ? 1 : 0) === (string) $val ? 'checked' : '' }} x-model.number="vaccinated" class="sr-only">
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
            </section>

            {{-- Očkovania --}}
            <section x-show="vaccinated === 1" class="rounded-2xl border border-border bg-card p-4 shadow-[var(--shadow-soft)]" style="display: none;">
                <span class="text-xs uppercase tracking-wider text-muted-foreground">Očkovania</span>
                <div class="mt-2 flex flex-col gap-2">
                    @foreach (['Infekčné ochorenia', 'Besnota', 'Kotercový kašeľ'] as $vacc)
                        <label @class([
                            'flex cursor-pointer items-center rounded-xl border px-3 py-3 text-left text-sm font-medium transition',
                            'has-[:checked]:border-accent has-[:checked]:bg-[var(--heart-soft)] has-[:checked]:text-accent',
                            'border-border bg-background text-foreground',
                        ])>
                            <input type="checkbox" name="vaccinations[]" value="{{ $vacc }}" {{ in_array($vacc, old('vaccinations', $dog->vaccinations ?? [])) ? 'checked' : '' }} class="sr-only">
                            {{ $vacc }}
                        </label>
                    @endforeach
                </div>
            </section>

            {{-- Má pes mikročip? --}}
            <section class="rounded-2xl border border-border bg-card p-4 shadow-[var(--shadow-soft)]">
                <span class="text-xs uppercase tracking-wider text-muted-foreground">Má pes mikročip?</span>
                <div class="mt-2 grid grid-cols-2 gap-2">
                    @foreach ([1 => 'Áno', 0 => 'Nie'] as $val => $label)
                        <label @class([
                            'flex cursor-pointer items-center justify-center rounded-xl border px-3 py-3 text-sm font-medium transition',
                            'has-[:checked]:border-accent has-[:checked]:bg-[var(--heart-soft)] has-[:checked]:text-accent',
                            'border-border bg-background text-foreground',
                        ])>
                            <input type="radio" name="microchipped" value="{{ $val }}" {{ (string) old('microchipped', $dog->microchipped ? 1 : 0) === (string) $val ? 'checked' : '' }} class="sr-only">
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
            </section>

            {{-- Náš veterinár --}}
            <section class="rounded-2xl border border-border bg-card p-4 shadow-[var(--shadow-soft)]">
                <label for="vet" class="text-xs uppercase tracking-wider text-muted-foreground">Náš veterinár</label>
                <input id="vet" name="vet" type="text" maxlength="120" value="{{ old('vet', $dog->vet) }}" placeholder="meno alebo klinika" class="mt-2 block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">
            </section>

            {{-- Bio psa --}}
            <section class="rounded-2xl border border-border bg-[var(--heart-medium)] p-4 shadow-[var(--shadow-soft)]">
                <label for="personality" class="text-xs uppercase tracking-wider text-muted-foreground">Bio psa</label>
                <textarea id="personality" name="personality" rows="4" maxlength="300" placeholder="Opíš akú má povahu, ako sa rád hrá…" class="mt-2 block w-full rounded-xl border border-input bg-background px-4 py-3 text-base">{{ old('personality', $dog->personality) }}</textarea>
            </section>

            <div class="flex gap-3">
                <button type="submit" class="inline-flex flex-1 items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)]">Uložiť</button>
                <a href="{{ route('profile.show') }}" class="inline-flex items-center justify-center rounded-2xl px-6 py-3 text-base font-medium text-muted-foreground transition hover:bg-muted hover:text-foreground">Späť</a>
            </div>
        </form>

        {{-- Mazacie formuláre pre jednotlivé fotky (mimo hlavného formulára, aby sa formuláre nevnárali) --}}
        @if ($dog->exists)
            @foreach ($existingPhotos as $i => $photo)
                <form id="dog-photo-del-{{ $i }}" method="POST" action="{{ route('dog.photo.destroy', $dog) }}" class="hidden">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="index" value="{{ $i }}">
                </form>
            @endforeach
        @endif

        @if ($dog->exists)
            <form method="POST" action="{{ route('dog.destroy', $dog) }}" class="mt-3" onsubmit="return confirm('Naozaj odstrániť psíka?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl px-6 py-3 text-base font-medium text-destructive transition hover:bg-muted">Odstrániť psíka</button>
            </form>
        @endif
    </div>
@endsection
