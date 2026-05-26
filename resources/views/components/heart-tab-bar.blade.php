@php
    $path = '/' . trim(request()->path(), '/');
    $tabs = [
        ['to' => '/search',  'label' => 'Hľadať', 'icon' => 'search',  'match' => str_starts_with($path, '/search')],
        ['to' => '/profile', 'label' => 'Profil', 'icon' => 'user',    'match' => str_starts_with($path, '/profile')],
        ['to' => '/',        'label' => 'Domov',  'icon' => 'home',    'match' => $path === '/', 'center' => true],
        ['to' => '/sos',     'label' => 'SOS',    'icon' => 'siren',   'match' => str_starts_with($path, '/sos')],
        ['to' => '/walks',   'label' => 'Fórum',  'icon' => 'forum',   'match' => str_starts_with($path, '/walks')],
    ];
@endphp

<nav
    aria-label="Main"
    class="fixed inset-x-0 bottom-0 z-40 border-t border-border/60 bg-background/80 backdrop-blur-xl"
    style="padding-bottom: env(safe-area-inset-bottom);"
>
    <ul class="mx-auto flex max-w-md items-end justify-around px-4 pt-2 pb-3">
        @foreach ($tabs as $t)
            <li class="flex-1">
                <a
                    href="{{ $t['to'] }}"
                    @class([
                        'group flex flex-col items-center gap-1 focus:outline-none',
                        '-translate-y-3' => $t['center'] ?? false,
                    ])
                >
                    <x-heart-icon :active="$t['match']" :size="($t['center'] ?? false) ? 'lg' : 'md'">
                        @switch($t['icon'])
                            @case('search')
                                <svg xmlns="http://www.w3.org/2000/svg" width="{{ ($t['center'] ?? false) ? 24 : 18 }}" height="{{ ($t['center'] ?? false) ? 24 : 18 }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                                @break
                            @case('user')
                                <svg xmlns="http://www.w3.org/2000/svg" width="{{ ($t['center'] ?? false) ? 24 : 18 }}" height="{{ ($t['center'] ?? false) ? 24 : 18 }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                @break
                            @case('home')
                                <svg xmlns="http://www.w3.org/2000/svg" width="{{ ($t['center'] ?? false) ? 24 : 18 }}" height="{{ ($t['center'] ?? false) ? 24 : 18 }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                @break
                            @case('siren')
                                <svg xmlns="http://www.w3.org/2000/svg" width="{{ ($t['center'] ?? false) ? 24 : 18 }}" height="{{ ($t['center'] ?? false) ? 24 : 18 }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 18v-6a5 5 0 1 1 10 0v6"/><path d="M5 21a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1z"/><path d="M21 12h1"/><path d="M18.5 4.5 18 5"/><path d="M2 12h1"/><path d="M12 2v1"/><path d="m4.929 4.929.707.707"/><path d="M12 12v6"/></svg>
                                @break
                            @case('forum')
                                <svg xmlns="http://www.w3.org/2000/svg" width="{{ ($t['center'] ?? false) ? 24 : 18 }}" height="{{ ($t['center'] ?? false) ? 24 : 18 }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9a2 2 0 0 1-2 2H6l-4 4V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2z"/><path d="M18 9h2a2 2 0 0 1 2 2v11l-4-4h-6a2 2 0 0 1-2-2v-1"/></svg>
                                @break
                        @endswitch
                    </x-heart-icon>
                    <span @class([
                        'text-[10px] uppercase tracking-wider',
                        'text-accent' => $t['match'],
                        'text-muted-foreground' => ! $t['match'],
                    ])>{{ $t['label'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</nav>
