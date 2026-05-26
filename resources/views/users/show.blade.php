@extends('layouts.app')

@section('content')
    @php
        $sizeLabel = ['small' => 'Malá', 'medium' => 'Stredná', 'large' => 'Veľká'];
    @endphp
    <div class="pt-6">
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-1 rounded-full border border-border bg-card px-3 py-1.5 text-sm hover:bg-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Späť
        </a>

        @if (session('status'))<p class="mt-3 text-sm text-accent">{{ session('status') }}</p>@endif

        <div class="mt-4 flex items-start gap-6">
            <div class="h-28 w-28 shrink-0 overflow-hidden rounded-3xl bg-muted ring-1 ring-black/5 shadow-[var(--shadow-soft)]">
                @if ($user->avatar_url)<img src="{{ $user->avatar_url }}" alt="" class="h-full w-full object-cover">@endif
            </div>
            <div class="min-w-0 flex-1 pt-1">
                <h1 class="truncate font-display text-3xl leading-tight">{{ $user->display_name ?? $user->name }}</h1>
                @if ($user->city)<p class="mt-1 text-xs text-muted-foreground">{{ $user->city }}</p>@endif
            </div>
        </div>

        @if ($user->bio)
            <p class="mt-4 whitespace-pre-line text-sm leading-relaxed">{{ $user->bio }}</p>
        @endif

        @if ($user->instagram)
            <a href="https://instagram.com/{{ ltrim($user->instagram, '@') }}" target="_blank" rel="noopener" class="mt-3 inline-flex items-center gap-2 rounded-full bg-gradient-to-tr from-[#feda75] via-[#fa7e1e] to-[#d62976] px-4 py-2 text-sm font-medium text-white shadow-[var(--shadow-soft)]">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                @{{ ltrim($user->instagram, '@') }}
            </a>
        @endif

        <div class="mt-5 flex flex-wrap gap-2">
            @if (! $friendship)
                <form method="POST" action="{{ route('users.friend', $user) }}">
                    @csrf
                    <button type="submit" class="rounded-full bg-primary px-4 py-2 text-sm font-medium text-primary-foreground">Pridať kamoša</button>
                </form>
            @elseif ($friendship->status === 'pending')
                <span class="rounded-full border border-border bg-card px-4 py-2 text-sm text-muted-foreground">Žiadosť čaká</span>
            @elseif ($friendship->status === 'accepted')
                <span class="inline-flex items-center gap-1 rounded-full bg-[var(--heart-soft)] px-4 py-2 text-sm text-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Kamoši
                </span>
            @endif
        </div>

        @if ($dogs->isNotEmpty())
            <section class="mt-8">
                <h2 class="font-display text-2xl">Psíci</h2>
                <div class="mt-3 space-y-4">
                    @foreach ($dogs as $d)
                        @php
                            $age = $d->birth_year ? (now()->year - (int) $d->birth_year) : null;
                            $metaParts = array_filter([
                                $d->breed,
                                $d->size ? ($sizeLabel[$d->size] ?? null) : null,
                                $age ? $age.' r.' : null,
                            ]);
                        @endphp
                        <div class="overflow-hidden rounded-2xl border border-border bg-card">
                            @if ($d->photo_url)
                                @if ($isFriend)
                                    @php $photos = ! empty($d->photos) ? $d->photos : [$d->photo_url]; @endphp
                                    @if (count($photos) > 1)
                                        <div class="flex gap-2 overflow-x-auto bg-muted p-2">
                                            @foreach ($photos as $url)
                                                <img src="{{ $url }}" alt="" class="aspect-square h-40 w-40 shrink-0 rounded-xl object-cover">
                                            @endforeach
                                        </div>
                                    @else
                                        <img src="{{ $d->photo_url }}" alt="{{ $d->name }}" class="block aspect-[16/9] w-full object-cover">
                                    @endif
                                @else
                                    <div class="relative aspect-[16/9] bg-muted">
                                        <div class="flex h-full w-full flex-col items-center justify-center gap-2 text-muted-foreground">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                            <p class="text-xs">Fotky uvidíš keď si potvrdí žiadosť o kamošstvo</p>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            <div class="p-4">
                                <p class="font-display text-lg">{{ $d->name }}</p>
                                @if (! empty($metaParts))
                                    <p class="text-xs text-muted-foreground">{{ implode(' · ', $metaParts) }}</p>
                                @endif
                                @if ($isFriend && $d->personality)
                                    <p class="mt-2 text-sm">{{ $d->personality }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($isFriend)
                    <a href="{{ route('feed.index') }}" class="mt-4 block text-center text-sm text-accent hover:underline">Pozri najnovšie fotky vo feedu →</a>
                @endif
            </section>
        @endif
    </div>
@endsection
