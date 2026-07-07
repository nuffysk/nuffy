@extends('layouts.app')

@section('content')
    <div class="pt-8" x-data="{ password: '', confirm: '', birthYear: '', agreeTerms: {{ old('agree_terms') ? 'true' : 'false' }}, agreePrivacy: {{ old('agree_privacy') ? 'true' : 'false' }}, minAge: 18, get age() { const y = parseInt(this.birthYear, 10); return Number.isFinite(y) ? new Date().getFullYear() - y : -1; }, get tooYoung() { return this.birthYear !== '' && Number.isFinite(parseInt(this.birthYear, 10)) && this.age < this.minAge; }, get canSubmit() { return this.agreeTerms && this.agreePrivacy && this.password.length >= 8 && this.password === this.confirm && this.birthYear !== '' && !this.tooYoung; } }">
        <h1 class="font-display text-4xl">
            Pridaj sa<span class="text-accent">.</span>
        </h1>
        <div class="mt-2 space-y-2 text-sm text-muted-foreground">
            <p>Dog-parenting je niekedy challenge. Preto je tu Ňuffy – tvoj safe space, kde nájdeš:</p>
            <ul class="space-y-1">
                <li class="flex items-start gap-2"><span class="text-accent">♥</span><span>Komunitu, chat a fórum.</span></li>
                <li class="flex items-start gap-2"><span class="text-accent">♥</span><span>Náučné videá, čo ťa posunú na iný level.</span></li>
                <li class="flex items-start gap-2"><span class="text-accent">♥</span><span>Hotely, škôlky a grooming na pár klikov.</span></li>
                <li class="flex items-start gap-2"><span class="text-accent">♥</span><span>Záchrannú linku pre psov.</span></li>
            </ul>
            <p>Be there or be square!</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-4">
            @csrf

            <div class="space-y-2">
                <label for="name" class="text-sm font-medium">Tvoje meno a priezvisko</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    placeholder="Mária Nováková"
                    required autofocus autocomplete="name"
                    class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base"
                >
                @error('name')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-2">
                <label for="email" class="text-sm font-medium">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required autocomplete="username"
                    class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base"
                >
                @error('email')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-2">
                <label for="birth_year" class="text-sm font-medium">Rok narodenia</label>
                <input
                    id="birth_year"
                    name="birth_year"
                    type="number"
                    inputmode="numeric"
                    min="1900"
                    max="{{ now()->year }}"
                    value="{{ old('birth_year') }}"
                    placeholder="napr. 1995"
                    required
                    x-model="birthYear"
                    class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base"
                >
                <p x-show="tooYoung" class="text-sm text-destructive" style="display: none;">
                    Aplikáciu môžu používať iba osoby od 18 rokov.
                </p>
                @error('birth_year')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-2">
                <label for="password" class="text-sm font-medium">Heslo</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required minlength="8" autocomplete="new-password"
                    x-model="password"
                    class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base"
                >
                <p x-show="password.length > 0 && password.length < 8" class="text-sm text-destructive" style="display: none;">
                    Heslo musí mať aspoň 8 znakov
                </p>
                @error('password')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-2">
                <label for="password_confirmation" class="text-sm font-medium">Potvrď heslo</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required minlength="8" autocomplete="new-password"
                    x-model="confirm"
                    class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base"
                >
                <template x-if="confirm.length > 0 && confirm === password">
                    <p class="flex items-center gap-1 text-sm text-[oklch(0.55_0.13_150)]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Heslá sa zhodujú
                    </p>
                </template>
                <template x-if="confirm.length > 0 && confirm !== password">
                    <p class="flex items-center gap-1 text-sm text-destructive">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        Heslá sa nezhodujú
                    </p>
                </template>
            </div>

            <div class="space-y-3 pt-2">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="checkbox" name="agree_terms" value="1" x-model="agreeTerms" class="mt-0.5 h-4 w-4 rounded-md border-border accent-[var(--accent)] focus:ring-accent">
                    <span class="text-sm text-foreground leading-snug">
                        Prečítal/a som si a súhlasím s
                        <a href="/terms" class="text-primary underline underline-offset-2">Podmienkami používania</a>
                    </span>
                </label>
                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="checkbox" name="agree_privacy" value="1" x-model="agreePrivacy" class="mt-0.5 h-4 w-4 rounded-md border-border accent-[var(--accent)] focus:ring-accent">
                    <span class="text-sm text-foreground leading-snug">
                        Súhlasím so spracovaním osobných údajov podľa
                        <a href="/privacy" class="text-primary underline underline-offset-2">Zásad ochrany osobných údajov</a>
                    </span>
                </label>
                @error('agree_terms')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
                @error('agree_privacy')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            <button type="submit" x-bind:disabled="!canSubmit" class="inline-flex w-full items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)] transition disabled:pointer-events-none disabled:opacity-50">
                Vytvoriť účet
            </button>
        </form>

        <div class="my-6 flex items-center gap-3">
            <div class="h-px flex-1 bg-border"></div>
            <span class="text-xs uppercase tracking-wider text-muted-foreground">alebo</span>
            <div class="h-px flex-1 bg-border"></div>
        </div>

        <a href="{{ route('auth.google.redirect') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-border bg-card px-6 py-3 text-base font-medium text-foreground transition hover:bg-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="#4285F4" d="M23.49 12.27c0-.79-.07-1.54-.19-2.27H12v4.51h6.44c-.27 1.4-1.09 2.6-2.34 3.4v2.85h3.78c2.21-2.04 3.49-5.05 3.49-8.49z"/><path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.78-2.85c-1.05.7-2.39 1.13-4.15 1.13-3.19 0-5.89-2.15-6.86-5.04H1.24v2.94C3.21 21.31 7.31 24 12 24z"/><path fill="#FBBC05" d="M5.14 14.32C4.91 13.62 4.78 12.83 4.78 12s.13-1.62.36-2.32V6.74H1.24C.45 8.32 0 10.1 0 12s.45 3.68 1.24 5.26l3.9-2.94z"/><path fill="#EA4335" d="M12 4.78c1.78 0 3.36.62 4.62 1.81l3.45-3.45C17.95 1.18 15.24 0 12 0 7.31 0 3.21 2.69 1.24 6.74l3.9 2.94C6.11 6.93 8.81 4.78 12 4.78z"/></svg>
            Pokračovať s Google
        </a>

        <a href="{{ route('login') }}" class="mt-6 block w-full text-center text-sm text-muted-foreground hover:text-foreground">
            Už máš účet? Prihlás sa
        </a>

        <div class="mt-6 flex flex-wrap justify-center gap-2">
            <a href="/privacy" class="rounded-full border border-border bg-card px-4 py-2 text-xs font-medium text-foreground shadow-[var(--shadow-card)] transition hover:bg-muted">
                Podmienky ochrany súkromia
            </a>
            <a href="/terms" class="rounded-full border border-border bg-card px-4 py-2 text-xs font-medium text-foreground shadow-[var(--shadow-card)] transition hover:bg-muted">
                Podmienky používania
            </a>
        </div>
    </div>
@endsection
