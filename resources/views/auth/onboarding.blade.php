@extends('layouts.app')

@section('content')
    <div class="pt-8" x-data="{
        birthYear: '{{ old('birth_year') }}',
        agreeTerms: {{ old('agree_terms') ? 'true' : 'false' }},
        agreePrivacy: {{ old('agree_privacy') ? 'true' : 'false' }},
        minAge: 18,
        get age() { const y = parseInt(this.birthYear, 10); return Number.isFinite(y) ? new Date().getFullYear() - y : -1; },
        get tooYoung() { return this.birthYear !== '' && Number.isFinite(parseInt(this.birthYear, 10)) && this.age < this.minAge; },
        get canSubmit() { return this.agreeTerms && this.agreePrivacy && this.birthYear !== '' && !this.tooYoung; }
    }">
        <h1 class="font-display text-4xl">
            Ešte jeden krok<span class="text-accent">.</span>
        </h1>
        <p class="mt-2 text-sm text-muted-foreground">
            Prihlásil/a si sa cez Google. Pre dokončenie registrácie potrebujeme tvoj rok narodenia a súhlas s pravidlami.
        </p>

        <form method="POST" action="{{ route('onboarding.store') }}" class="mt-6 space-y-5">
            @csrf

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
                    required
                    x-model="birthYear"
                    placeholder="napr. 1995"
                    class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base"
                >
                <p x-show="tooYoung" class="text-sm text-destructive" style="display: none;">
                    Aplikáciu môžu používať iba osoby od 18 rokov.
                </p>
                @error('birth_year')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-3">
                <label class="flex items-start gap-2 text-sm">
                    <input type="checkbox" name="agree_terms" value="1" x-model="agreeTerms" class="mt-0.5 h-4 w-4 rounded border-input text-accent">
                    <span>Súhlasím s <a href="{{ route('terms') }}" target="_blank" class="text-accent underline">obchodnými podmienkami</a>.</span>
                </label>
                @error('agree_terms')<p class="text-sm text-destructive">{{ $message }}</p>@enderror

                <label class="flex items-start gap-2 text-sm">
                    <input type="checkbox" name="agree_privacy" value="1" x-model="agreePrivacy" class="mt-0.5 h-4 w-4 rounded border-input text-accent">
                    <span>Súhlasím so <a href="{{ route('privacy') }}" target="_blank" class="text-accent underline">spracovaním osobných údajov</a>.</span>
                </label>
                @error('agree_privacy')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            <button type="submit" :disabled="!canSubmit" :class="!canSubmit ? 'opacity-50 cursor-not-allowed' : ''"
                class="inline-flex w-full items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)]">
                Dokončiť registráciu
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="mt-3 text-center">
            @csrf
            <button type="submit" class="text-sm text-muted-foreground hover:text-foreground">Odhlásiť sa</button>
        </form>
    </div>
@endsection
