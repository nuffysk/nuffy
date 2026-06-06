@extends('layouts.app')

@section('content')
    <div class="pt-8" x-data="{ password: '', confirm: '' }">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            Späť na prihlásenie
        </a>

        <h1 class="mt-4 font-display text-4xl">
            Nové heslo<span class="text-accent">.</span>
        </h1>

        <form method="POST" action="{{ route('password.store') }}" class="mt-8 space-y-4">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="space-y-2">
                <label for="email" class="text-sm font-medium">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', $request->email) }}"
                    required autofocus autocomplete="username"
                    class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-base"
                >
                @error('email')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-2">
                <label for="password" class="text-sm font-medium">Nové heslo</label>
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
                <label for="password_confirmation" class="text-sm font-medium">Potvrď nové heslo</label>
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
                @error('password_confirmation')<p class="text-sm text-destructive">{{ $message }}</p>@enderror
            </div>

            <button
                type="submit"
                x-bind:disabled="password.length < 8 || password !== confirm"
                class="inline-flex w-full items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)] transition disabled:pointer-events-none disabled:opacity-50"
            >
                Uložiť nové heslo
            </button>
        </form>
    </div>
@endsection
