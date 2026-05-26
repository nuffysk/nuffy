<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Ňuffy') }}</title>

    {{-- PWA --}}
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <meta name="theme-color" content="#C4724A">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Ňuffy">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:400,500,600,600i,700|inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen pb-28" x-data="{ open: false }">
        {{-- Top bar --}}
        <header class="sticky top-0 z-30 border-b border-border/60 bg-background/70 backdrop-blur-xl">
            <div class="mx-auto flex h-14 max-w-md items-center justify-between px-4">
                <a href="/" class="flex items-center gap-2 font-display text-xl font-semibold">
                    <img src="{{ asset('img/nuffy-logo.png') }}" alt="Ňuffy" class="h-8 w-8 rounded-full object-cover ring-1 ring-border">
                    Ňuffy
                </a>
                @auth
                    <button
                        @click="open = true"
                        aria-label="Open menu"
                        class="rounded-full p-2 transition hover:bg-muted"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
                    </button>
                @endauth
            </div>
        </header>

        {{-- Page heading --}}
        @if (! empty($pageTitle) || ! empty($pageSubtitle))
            <div @class([
                'mx-auto max-w-md px-4',
                'pt-4' => ! empty($compact),
                'pt-6 pb-2' => empty($compact),
            ])>
                @if (! empty($pageTitle))<h1 class="font-display text-3xl">{{ $pageTitle }}</h1>@endif
                @if (! empty($pageSubtitle))<p class="mt-1 text-sm text-muted-foreground">{{ $pageSubtitle }}</p>@endif
            </div>
        @endif

        <main class="mx-auto max-w-md px-4 pb-10">
            {{ $slot ?? '' }}
            @yield('content')
        </main>

        @auth
            <x-heart-tab-bar />
        @endauth

        {{-- Drawer menu --}}
        @auth
            <div
                x-show="open"
                x-transition.opacity
                class="fixed inset-0 z-50 flex"
                style="display: none;"
            >
                <button
                    aria-label="Close menu"
                    class="absolute inset-0 bg-black/40 backdrop-blur-sm"
                    @click="open = false"
                ></button>
                <aside class="relative ml-auto flex h-full w-[85%] max-w-xs flex-col bg-card shadow-2xl">
                    <div class="flex items-center justify-between border-b border-border px-5 py-4">
                        <p class="font-display text-xl">Menu</p>
                        <button @click="open = false" class="rounded-full p-2 hover:bg-muted">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        </button>
                    </div>
                    <nav class="flex-1 overflow-y-auto p-3">
                        @php
                            $tiles = [
                                ['to' => '/profile',  'label' => 'Tvoj profil',        'svg' => '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>'],
                                ['to' => '/sos',      'label' => 'SOS linka',          'svg' => '<path d="M7 18v-6a5 5 0 1 1 10 0v6"/><path d="M5 21a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1z"/>'],
                                ['to' => '/learn',    'label' => 'Zavoditko',          'svg' => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>'],
                                ['to' => '/friends',  'label' => 'Kamoši',             'svg' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>'],
                                ['to' => '/places',   'label' => 'Hotel & škôlka',     'svg' => '<path d="M3 7v11a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7"/><path d="M22 11H2"/><path d="M5 7V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2"/>'],
                                ['to' => '/walks',    'label' => 'Fórum',              'svg' => '<path d="M14 9a2 2 0 0 1-2 2H6l-4 4V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2z"/><path d="M18 9h2a2 2 0 0 1 2 2v11l-4-4h-6a2 2 0 0 1-2-2v-1"/>'],
                                ['to' => '/novinky',  'label' => 'Novinky',            'svg' => '<path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8z"/>'],
                                ['to' => '/support',  'label' => 'Podpora a kontakty', 'svg' => '<path d="M18.5 3a2.5 2.5 0 0 0-2.45 3H6a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3V9a3 3 0 0 0-1.27-2.46A2.5 2.5 0 0 0 18.5 3z"/><circle cx="12" cy="13" r="3"/>'],
                                ['to' => '/settings', 'label' => 'Nastavenia',         'svg' => '<path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/>'],
                            ];
                            $secondary = [
                                ['to' => '/search',  'label' => 'Hľadať',                      'svg' => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>'],
                                ['to' => '/privacy', 'label' => 'Podmienky ochrany súkromia',  'svg' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>'],
                                ['to' => '/terms',   'label' => 'Podmienky používania',        'svg' => '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"/><polyline points="14 2 14 8 20 8"/>'],
                                ['to' => '/cookies', 'label' => 'Cookies',                     'svg' => '<path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5"/><path d="M8.5 8.5v.01"/><path d="M16 15.5v.01"/><path d="M12 12v.01"/><path d="M11 17v.01"/><path d="M7 14v.01"/>'],
                            ];
                        @endphp
                        <div class="grid grid-cols-3 gap-3">
                            @foreach ($tiles as $item)
                                <a
                                    href="{{ $item['to'] }}"
                                    @click="open = false"
                                    class="flex aspect-square flex-col items-center justify-center gap-2 rounded-2xl border border-border bg-background p-2 text-center text-xs font-medium shadow-[var(--shadow-soft)] transition hover:border-accent hover:bg-[var(--heart-soft)] hover:text-accent"
                                >
                                    <x-heart-icon size="sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $item['svg'] !!}</svg>
                                    </x-heart-icon>
                                    <span class="leading-tight">{{ $item['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                        <div class="mt-4 space-y-1 border-t border-border pt-3">
                            @foreach ($secondary as $item)
                                <a
                                    href="{{ $item['to'] }}"
                                    @click="open = false"
                                    class="flex items-center gap-3 rounded-xl px-3 py-2 text-xs text-muted-foreground transition hover:bg-muted hover:text-foreground"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $item['svg'] !!}</svg>
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </nav>
                    <div class="border-t border-border p-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-sm text-muted-foreground transition hover:bg-muted hover:text-foreground"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                                Odhlásiť sa
                            </button>
                        </form>
                    </div>
                </aside>
            </div>
        @endauth
    </div>

    @auth
        {{-- Inactivity auto-logout: 30 min idle, 1 min warning --}}
        <div
            x-data="inactivityLogout()"
            x-init="start()"
            x-show="warning"
            x-transition.opacity
            class="fixed inset-0 z-[80] flex items-center justify-center bg-black/50 p-6"
            style="display:none;"
        >
            <div class="w-full max-w-sm rounded-2xl bg-card p-6 shadow-2xl">
                <h2 class="font-display text-xl">Si tam?</h2>
                <p class="mt-2 text-sm text-muted-foreground">
                    Pre tvoju bezpečnosť ťa o <span x-text="seconds"></span> s odhlásime.
                </p>
                <div class="mt-4 flex gap-2">
                    <button @click="stay()" class="flex-1 rounded-xl bg-primary px-4 py-2 text-sm text-primary-foreground">Som tu</button>
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full rounded-xl border border-border bg-card px-4 py-2 text-sm">Odhlásiť</button>
                    </form>
                </div>
            </div>
        </div>

        <form id="nuffy-logout-form" method="POST" action="{{ route('logout') }}" class="hidden">@csrf</form>

        <script>
            function inactivityLogout() {
                const IDLE_MS = 30 * 60 * 1000; // 30 min
                const WARN_MS = 60 * 1000;      // 1 min warning
                return {
                    warning: false,
                    seconds: 60,
                    timer: null,
                    countdown: null,
                    start() {
                        ['mousemove','keydown','touchstart','click','scroll'].forEach(ev =>
                            window.addEventListener(ev, () => this.reset(), { passive: true }));
                        this.reset();
                    },
                    reset() {
                        if (this.warning) return;
                        clearTimeout(this.timer);
                        this.timer = setTimeout(() => this.showWarning(), IDLE_MS - WARN_MS);
                    },
                    showWarning() {
                        this.warning = true;
                        this.seconds = WARN_MS / 1000;
                        this.countdown = setInterval(() => {
                            this.seconds--;
                            if (this.seconds <= 0) {
                                clearInterval(this.countdown);
                                document.getElementById('nuffy-logout-form').submit();
                            }
                        }, 1000);
                    },
                    stay() {
                        clearInterval(this.countdown);
                        this.warning = false;
                        this.reset();
                    },
                };
            }
        </script>
    @endauth
</body>
</html>
