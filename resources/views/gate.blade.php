<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Cookiebot — needed on the gate too, since it's the first page visitors (and the Cookiebot crawler) see during closed beta --}}
    @include('partials.cookiebot')

    <title>Ňuffy · Zatvorené testovanie</title>

    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <meta name="theme-color" content="#C4724A">
    <meta name="robots" content="noindex, nofollow">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:400,500,600,600i,700|inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="flex min-h-screen items-center justify-center px-4 py-10">
        <div class="w-full max-w-sm">
            <div class="rounded-3xl border border-border bg-card p-8 shadow-[var(--shadow-soft)]">
                <div class="flex flex-col items-center text-center">
                    <img src="{{ asset('img/nuffy-logo.png') }}" alt="Ňuffy"
                         class="h-16 w-16 rounded-full object-cover ring-1 ring-border">
                    <p class="mt-5 text-xs uppercase tracking-[0.22em] text-muted-foreground">Zatvorené testovanie</p>
                    <h1 class="mt-2 font-display text-3xl leading-tight">Vitaj v Ňuffy</h1>
                    <p class="mt-3 text-sm leading-relaxed text-muted-foreground">
                        Stránka je zatiaľ dostupná len pre pozvaných. Zadaj prístupové heslo a pokračuj ďalej.
                    </p>
                </div>

                <form method="POST" action="{{ route('gate.unlock') }}" class="mt-7 flex flex-col gap-3">
                    @csrf
                    <input
                        type="password"
                        name="password"
                        autofocus
                        required
                        placeholder="Prístupové heslo"
                        autocomplete="off"
                        class="w-full rounded-2xl border border-border bg-background px-4 py-3 text-base text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/30"
                    >

                    @error('password')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <button
                        type="submit"
                        class="mt-1 inline-flex items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)] transition hover:opacity-95"
                    >
                        Vstúpiť
                    </button>
                </form>
            </div>

            <p class="mt-6 text-center text-xs text-muted-foreground">© {{ date('Y') }} Ňuffy</p>
        </div>
    </div>
</body>
</html>
