@extends('layouts.app')

@section('content')
    @php
        $sizeLabel = ['small' => 'malý', 'medium' => 'stredný', 'large' => 'veľký'];
        $genderLabel = ['male' => 'Pes', 'female' => 'Sučka'];
        $boolLabel = fn ($v) => is_null($v) ? null : ($v ? 'Áno' : 'Nie');
        $instagram = $user->instagram ? ltrim($user->instagram, '@') : null;
        $canSeePhotos = $isFriend;
    @endphp

    @if (session('status'))<p class="mt-3 text-sm text-accent">{{ session('status') }}</p>@endif

    <section class="pt-6 flex items-start gap-4">
        <div class="h-24 w-24 shrink-0 overflow-hidden rounded-3xl bg-muted shadow-[var(--shadow-soft)]">
            @if ($user->avatar_url)<img src="{{ $user->avatar_url }}" alt="" class="h-full w-full object-cover">@endif
        </div>
        <div class="min-w-0 flex-1">
            <h1 class="truncate font-display text-3xl">{{ $user->display_name ?? $user->name }}</h1>
            <p class="text-sm text-muted-foreground">@if ($user->city){{ $user->city }}@else<span class="italic opacity-70">Mesto: neuvedené</span>@endif</p>
            <p class="mt-2 text-sm leading-relaxed">@if ($user->bio){{ $user->bio }}@else<span class="italic text-muted-foreground">Bio: neuvedené</span>@endif</p>
        </div>
    </section>

    <section class="mt-5 flex flex-wrap gap-2">
        @if ($instagram)
            <a href="https://instagram.com/{{ $instagram }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 rounded-full bg-gradient-to-tr from-[#f09433] via-[#e6683c] to-[#bc1888] px-3 py-1.5 text-xs font-medium text-white shadow-sm transition hover:opacity-90">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg> @{{ $instagram }}
            </a>
        @else
            <span class="inline-flex items-center gap-1.5 rounded-full border border-dashed border-border bg-muted/40 px-3 py-1.5 text-xs text-muted-foreground">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg> Instagram zatiaľ nezadaný
            </span>
        @endif

        @if (! $friendship)
            <form method="POST" action="{{ route('users.friend', $user) }}">
                @csrf
                <button type="submit" class="inline-flex items-center justify-center gap-1.5 rounded-2xl px-6 py-3 text-base font-medium text-foreground transition hover:bg-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg> Pridať kamoša
                </button>
            </form>
        @elseif ($friendship->status === 'pending')
            <span class="rounded-full bg-muted px-3 py-1.5 text-xs text-muted-foreground">Žiadosť čaká</span>
        @elseif ($friendship->status === 'accepted')
            <span class="inline-flex items-center gap-1 rounded-full bg-[var(--heart-soft)] px-3 py-1.5 text-xs text-accent">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Kamoši
            </span>
        @endif
    </section>

    <section class="mt-8">
        <h2 class="font-display text-2xl">Psíci</h2>
        <div class="mt-3 space-y-4">
            @foreach ($dogs as $d)
                @php
                    $photos = ! empty($d->photos) ? $d->photos : ($d->photo_url ? [$d->photo_url] : []);
                    $age = $d->birth_year ? (now()->year - (int) $d->birth_year) : null;
                    $dogFields = [
                        ['Plemeno', $d->breed],
                        ['Veľkosť', $d->size ? ($sizeLabel[$d->size] ?? null) : null],
                        ['Vek', $age ? $age.' r.' : null],
                        ['Pohlavie', ($d->gender && $d->gender !== 'unspecified') ? ($genderLabel[$d->gender] ?? null) : null],
                        ['Povaha', $d->personality],
                        ['Veterinár', $d->vet],
                        ['Zdravotné poznámky', $d->health_notes],
                        ['Očkovaný', $boolLabel($d->vaccinated)],
                        ['Čipovaný', $boolLabel($d->microchipped)],
                        ['Kastrovaný', $boolLabel($d->neutered)],
                    ];
                @endphp
                <div class="overflow-hidden rounded-2xl border border-border bg-card">
                    @if (count($photos) > 0)
                        @if ($canSeePhotos)
                            <div class="flex gap-1 overflow-x-auto">
                                @foreach ($photos as $url)
                                    <img src="{{ $url }}" alt="{{ $d->name }}" loading="lazy" class="h-48 w-full shrink-0 object-cover">
                                @endforeach
                            </div>
                        @else
                            <div class="flex h-48 flex-col items-center justify-center gap-2 bg-muted text-muted-foreground">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                <p class="px-4 text-center text-xs">Fotky uvidíš keď si potvrdí žiadosť o kamošstvo</p>
                            </div>
                        @endif
                    @endif
                    <div class="p-4 space-y-2">
                        <h3 class="font-display text-xl">{{ $d->name }}</h3>
                        @foreach ($dogFields as [$label, $value])
                            <p class="text-sm leading-relaxed">
                                <span class="text-xs uppercase tracking-wider text-muted-foreground">{{ $label }}: </span>@if ($value === null || $value === '')<span class="italic text-muted-foreground">neuvedené</span>@else{{ $value }}@endif
                            </p>
                        @endforeach
                    </div>
                </div>
            @endforeach
            @if ($dogs->isEmpty())
                <p class="text-sm text-muted-foreground">Zatiaľ žiadny psík.</p>
            @endif
        </div>
    </section>
    <div class="h-2" aria-hidden></div>
@endsection
