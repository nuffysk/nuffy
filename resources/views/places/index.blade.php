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

        @auth
            <section class="mt-8 rounded-2xl border border-dashed border-border bg-card p-4">
                <p class="font-display text-lg">Chcete nám odporučiť dobrý salón, hotel či škôlku?</p>
                <p class="mt-1 text-sm text-muted-foreground">Napíšte nám a my to preveríme.</p>
                <form method="POST" action="{{ route('places.suggest') }}" class="mt-3 flex gap-2">
                    @csrf
                    <input type="hidden" name="category" value="{{ $category }}">
                    <input type="hidden" name="name" value="(z formulára na /places)">
                    <textarea name="note" rows="2" maxlength="1000" placeholder="Názov, mesto, prečo to odporúčate…" required class="flex-1 rounded-xl border border-input bg-background px-4 py-3 text-sm"></textarea>
                    <button type="submit" aria-label="Poslať tip" class="inline-flex items-center justify-center rounded-xl bg-accent px-4 py-2 text-sm font-medium text-accent-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    </button>
                </form>
            </section>
        @endauth
    </div>
@endsection
