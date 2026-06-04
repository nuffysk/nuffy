@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Hotel, škôlka, grooming</h1>
        <p class="mt-2 text-sm leading-relaxed text-muted-foreground">
            Vyberáme pre vás služby, ktoré prešli naším výberom – na základe osobnej skúsenosti alebo výborných hodnotení od komunity majiteľov psov.
        </p>

        @if (session('status'))<p class="mt-3 text-sm text-accent">{{ session('status') }}</p>@endif

        @php
            $tabs = [
                'hotel'    => ['Hotel',    '<path d="M3 7v11a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7"/><path d="M22 11H2"/><path d="M5 7V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v2"/>'],
                'daycare'  => ['Škôlky',   '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>'],
                'grooming' => ['Grooming', '<path d="M6 2 4 4l8 8 8-8-2-2"/><path d="m4 4 16 16"/>'],
            ];
        @endphp

        <div class="mt-5 flex flex-wrap gap-2">
            @foreach ($tabs as $val => $cfg)
                <a href="{{ route('places.index', ['category' => $val]) }}" class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-sm font-medium {{ $category === $val ? 'bg-accent text-accent-foreground' : 'border border-border bg-card text-foreground hover:bg-muted' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $cfg[1] !!}</svg>
                    {{ $cfg[0] }}
                </a>
            @endforeach
        </div>

        @if ($cities->isNotEmpty())
            <div class="mt-3 flex flex-wrap gap-2 text-xs">
                <a href="{{ route('places.index', ['category' => $category]) }}" class="rounded-full px-3 py-1 {{ ! $city ? 'bg-foreground text-background' : 'border border-border bg-card text-muted-foreground' }}">Všetky</a>
                @foreach ($cities as $c)
                    <a href="{{ route('places.index', ['category' => $category, 'city' => $c]) }}" class="rounded-full px-3 py-1 {{ $city === $c ? 'bg-foreground text-background' : 'border border-border bg-card text-muted-foreground' }}">{{ $c }}</a>
                @endforeach
            </div>
        @endif

        <div class="mt-6 space-y-4">
            @forelse ($places as $p)
                <a href="{{ route('places.show', $p) }}" class="block overflow-hidden rounded-2xl border border-border bg-card transition hover:shadow-[var(--shadow-soft)]">
                    <div class="aspect-[16/9] bg-muted">
                        @if ($p->image_url)
                            <img src="{{ $p->image_url }}" alt="{{ $p->name }}" class="h-full w-full object-cover" loading="lazy">
                        @endif
                    </div>
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <p class="font-display text-lg">{{ $p->name }}</p>
                            @if ($p->city)<span class="text-xs text-muted-foreground">{{ $p->city }}</span>@endif
                        </div>
                        @if ($p->description)<p class="mt-1 line-clamp-2 text-sm text-muted-foreground">{{ $p->description }}</p>@endif
                    </div>
                </a>
            @empty
                <p class="text-sm text-muted-foreground">Žiadne miesta v tejto kategórii.</p>
            @endforelse
        </div>

        @if (in_array($category, ['grooming', 'hotel', 'daycare']))
            @php
                $suggestBody = "Ahoj Ňuffy tím,\n\nrád/rada by som vám odporučil/a toto miesto:\n\nNázov: \nKategória (salón / hotel / škôlka): \nMesto: \nOdkaz (web / Instagram / Facebook): \nPrečo ho odporúčam: \n\nĎakujem!";
                $suggestMailto = 'mailto:nuffy@nuffy.sk?subject='.rawurlencode('Odporúčanie salónu, hotela, škôlky pre psov').'&body='.rawurlencode($suggestBody);
            @endphp
            <div class="mt-8 rounded-2xl border border-border bg-gradient-to-br from-card to-card/60 p-5 text-center shadow-[0_4px_20px_-12px_rgba(0,0,0,0.25)] backdrop-blur-sm">
                <h3 class="font-display text-base">Chcete nám odporučiť dobrý salón, hotel či škôlku?</h3>
                <p class="mt-1 text-xs text-muted-foreground">Napíšte nám a my to preveríme.</p>
                <a href="{{ $suggestMailto }}" class="mt-4 inline-flex items-center gap-2 rounded-full bg-accent px-5 py-2 text-sm font-medium text-accent-foreground shadow-[var(--shadow-soft)] transition hover:opacity-90">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    Odporučiť miesto
                </a>
            </div>
        @endif
    </div>
@endsection
