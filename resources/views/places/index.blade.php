@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Hotel, škôlka, grooming</h1>
        <p class="mt-2 text-sm leading-relaxed text-muted-foreground">
            Vyberáme pre vás služby, ktoré prešli naším výberom – na základe osobnej skúsenosti alebo výborných hodnotení od komunity majiteľov psov.
        </p>

        @if (session('status'))<p class="mt-3 text-sm text-accent">{{ session('status') }}</p>@endif

        @php
            $catLabels = [
                'hotel'    => 'Hotel',
                'daycare'  => 'Škôlky',
                'grooming' => 'Grooming',
            ];
            $catIcons = [
                'hotel'    => '<path d="M10 22v-6.57"/><path d="M12 11h.01"/><path d="M12 7h.01"/><path d="M14 15.43V22"/><path d="M15 16a5 5 0 0 0-6 0"/><path d="M16 11h.01"/><path d="M16 7h.01"/><path d="M8 11h.01"/><path d="M8 7h.01"/><rect x="4" y="2" width="16" height="20" rx="2"/>',
                'daycare'  => '<path d="M14 21v-3a2 2 0 0 0-4 0v3"/><path d="M18 5v16"/><path d="m4 6 7.106-3.79a2 2 0 0 1 1.788 0L20 6"/><path d="m6 11-3.52 2.147a1 1 0 0 0-.48.854V19a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a1 1 0 0 0-.48-.853L18 11"/><path d="M6 5v16"/><circle cx="12" cy="9" r="2"/>',
                'grooming' => '<path d="M11.017 2.814a1 1 0 0 1 1.966 0l1.051 5.558a2 2 0 0 0 1.594 1.594l5.558 1.051a1 1 0 0 1 0 1.966l-5.558 1.051a2 2 0 0 0-1.594 1.594l-1.051 5.558a1 1 0 0 1-1.966 0l-1.051-5.558a2 2 0 0 0-1.594-1.594l-5.558-1.051a1 1 0 0 1 0-1.966l5.558-1.051a2 2 0 0 0 1.594-1.594z"/><path d="M20 2v4"/><path d="M22 4h-4"/><circle cx="4" cy="20" r="2"/>',
            ];
        @endphp

        <div class="mt-4 flex gap-2">
            @foreach ($catLabels as $val => $label)
                <a href="{{ route('places.index', ['category' => $val]) }}" class="flex flex-1 items-center justify-center gap-2 rounded-full border px-3 py-2 text-sm transition {{ $category === $val ? 'border-accent bg-accent text-accent-foreground' : 'border-border bg-card text-muted-foreground' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $catIcons[$val] !!}</svg>
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @if ($cities->isNotEmpty())
            <div class="mt-4 flex flex-wrap gap-2">
                <a href="{{ route('places.index', ['category' => $category]) }}" class="rounded-full border px-3 py-1 text-xs transition {{ ! $city ? 'border-accent bg-[var(--heart-soft)] text-accent' : 'border-border bg-card text-muted-foreground' }}">Všetky</a>
                @foreach ($cities as $c)
                    <a href="{{ route('places.index', ['category' => $category, 'city' => $c]) }}" class="rounded-full border px-3 py-1 text-xs transition {{ $city === $c ? 'border-accent bg-[var(--heart-soft)] text-accent' : 'border-border bg-card text-muted-foreground' }}">{{ $c }}</a>
                @endforeach
            </div>
        @endif

        <div class="mt-6 space-y-4">
            @forelse ($places as $p)
                <a href="{{ route('places.show', $p) }}" class="block w-full overflow-hidden rounded-2xl border border-border bg-card text-left transition hover:shadow-[var(--shadow-soft)]">
                    @if ($p->image_url)
                        <div class="aspect-[16/9] overflow-hidden bg-muted">
                            <img src="{{ $p->image_url }}" alt="{{ $p->name }}" class="h-full w-full object-cover transition duration-500 hover:scale-[1.03]" loading="lazy">
                        </div>
                    @endif
                    <div class="p-4">
                        <p class="text-[10px] uppercase tracking-[0.18em] text-accent">
                            {{ $catLabels[$p->category] ?? $p->category }}@if ($p->city) · {{ $p->city }}@endif
                        </p>
                        <h3 class="mt-1 font-display text-xl">{{ $p->name }}</h3>
                        @if ($p->description)<p class="mt-2 line-clamp-2 text-sm text-muted-foreground">{{ $p->description }}</p>@endif
                    </div>
                </a>
            @empty
                <p class="text-sm text-muted-foreground">V tejto kategórii zatiaľ nič nemáme.</p>
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/></svg>
                    Odporučiť miesto
                </a>
            </div>
        @endif
    </div>
@endsection
