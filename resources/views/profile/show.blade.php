@extends('layouts.app')

@section('content')
    @php
        $friendsCount = $friends->count();
        $friendsLabel = $friendsCount === 1 ? 'kamarát' : (($friendsCount >= 2 && $friendsCount <= 4) ? 'kamaráti' : 'kamarátov');
        $withDogPhotos = $user->with_dog_photos ?? [];
        $genderOptions = ['female' => 'Žena', 'male' => 'Muž', 'unspecified' => 'Nezáleží'];
    @endphp

    @if (session('status'))
        <p class="mt-4 rounded-xl border border-border bg-card px-4 py-2 text-sm text-accent">{{ session('status') }}</p>
    @endif

    {{-- Profil majiteľa --}}
    <section class="pt-6 flex items-start gap-6">
        <a href="{{ route('profile.edit') }}" aria-label="Zmeniť fotku" class="group relative h-28 w-28 shrink-0 overflow-hidden rounded-3xl bg-muted ring-1 ring-black/5 shadow-[0_18px_30px_-12px_rgba(120,80,50,0.35),0_4px_10px_-2px_rgba(120,80,50,0.18),inset_0_1px_0_rgba(255,255,255,0.6)] transition hover:-translate-y-0.5">
            @if ($user->avatar_url)
                <img src="{{ $user->avatar_url }}" alt="" class="h-full w-full object-cover">
            @else
                <div class="flex h-full w-full items-center justify-center text-muted-foreground">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>
                </div>
            @endif
            <div class="pointer-events-none absolute inset-0 rounded-3xl bg-gradient-to-b from-white/25 via-transparent to-black/10"></div>
            <div class="absolute inset-x-0 bottom-0 flex items-center justify-center gap-1 bg-black/45 py-1 text-[10px] font-medium text-white opacity-0 transition group-hover:opacity-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg> Zmeniť
            </div>
        </a>
        <div class="min-w-0 flex-1 pt-1">
            <h1 class="truncate font-display text-3xl leading-tight">{{ $user->display_name ?? $user->name }}</h1>
            <a href="{{ route('friends.index') }}" class="mt-3 inline-block text-xs text-muted-foreground hover:text-accent">
                {{ $friendsCount }} {{ $friendsLabel }}
            </a>
            <div class="mt-3 flex flex-wrap gap-2">
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-1.5 rounded-full bg-primary px-3 py-1.5 text-xs font-medium text-primary-foreground shadow-[var(--shadow-heart)] transition hover:bg-primary/90">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg> Upraviť profil
                </a>
                <a href="{{ route('search') }}" class="inline-flex items-center gap-1.5 rounded-full bg-[var(--heart-soft)] px-3 py-1.5 text-xs font-medium text-accent transition hover:bg-accent hover:text-accent-foreground">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg> Pridať kamošov
                </a>
            </div>
        </div>
    </section>

    {{-- O mne --}}
    <section class="mt-4 rounded-2xl border border-border bg-card p-4 shadow-[var(--shadow-soft)]">
        <p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">O mne</p>
        <p class="mt-2 whitespace-pre-line text-sm @if (! $user->bio) text-muted-foreground @endif">{{ $user->bio ?: 'Napíš pár slov o sebe — koníčky, čo máš rád/rada na venčení… 🐾' }}</p>
    </section>

    {{-- Pohlavie --}}
    <section class="mt-3 rounded-2xl border border-border bg-card p-4 shadow-[var(--shadow-soft)]">
        <p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">Pohlavie</p>
        <div class="mt-2 flex gap-2">
            @foreach ($genderOptions as $val => $label)
                @php $active = $user->gender === $val; @endphp
                <span @class([
                    'flex-1 rounded-full border px-3 py-2 text-center text-sm transition',
                    'border-accent bg-[var(--heart-soft)] text-accent font-medium' => $active,
                    'border-border bg-background text-muted-foreground' => ! $active,
                ])>{{ $label }}</span>
            @endforeach
        </div>
    </section>

    {{-- Mesto --}}
    <section class="mt-3 rounded-2xl border border-border bg-card p-4 shadow-[var(--shadow-soft)]">
        <p class="text-xs font-medium uppercase tracking-wide text-muted-foreground">Mesto</p>
        <p class="mt-2 text-sm @if (! $user->city) text-muted-foreground @endif">{{ $user->city ?: '.....' }}</p>
    </section>

    {{-- Instagram --}}
    <section class="mt-3 rounded-2xl border border-border bg-card p-4 shadow-[var(--shadow-soft)]">
        <p class="flex items-center gap-1.5 text-xs font-medium uppercase tracking-wide text-muted-foreground">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg> Môj Instagram
        </p>
        <div class="mt-2 flex items-center gap-1">
            <span class="text-sm text-muted-foreground">@</span>
            <span class="flex-1 text-sm @if (! $user->instagram) text-muted-foreground @endif">{{ $user->instagram ? ltrim($user->instagram, '@') : 'instagram_účet' }}</span>
        </div>
        <p class="mt-1 text-[11px] text-muted-foreground">
            Otvorí sa v Instagram aplikácii / prehliadači.
        </p>
    </section>

    {{-- Psíkovia --}}
    <section class="mt-4">
        <div class="mb-2 flex items-baseline justify-between">
            <h2 class="font-display text-xl">Pridaj psíka</h2>
        </div>
        @if ($dogs->isEmpty())
            <a href="{{ route('dog.create') }}" class="flex items-center justify-center gap-2 rounded-2xl border-2 border-dashed border-border bg-card/50 px-4 py-6 text-sm text-muted-foreground transition hover:border-accent hover:text-accent">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg> Vytvoriť profil psíka
            </a>
        @else
            <div class="space-y-2">
                @foreach ($dogs as $d)
                    @php $photo = $d->photos[0] ?? $d->photo_url ?? null; @endphp
                    <a href="{{ route('dog.edit', $d) }}" class="flex items-center justify-between gap-3 rounded-2xl border border-border bg-card px-4 py-3 shadow-[var(--shadow-soft)] transition hover:border-accent/60">
                        <span class="flex min-w-0 items-center gap-3">
                            <span class="h-12 w-12 shrink-0 overflow-hidden rounded-2xl bg-muted">
                                @if ($photo)
                                    <img src="{{ $photo }}" alt="" class="h-full w-full object-cover">
                                @else
                                    <span class="flex h-full w-full items-center justify-center text-muted-foreground">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11.25 16.25h1.5L12 17z"/><path d="M16 14v.5"/><path d="M4.42 11.247A13.152 13.152 0 0 0 4 14.556C4 18.728 7.582 21 12 21s8-2.272 8-6.444a11.702 11.702 0 0 0-.493-3.309"/><path d="M8 14v.5"/><path d="M8.5 8.5c-.384 1.05-1.083 2.028-2.344 2.5-1.931.722-3.576-.297-3.656-1-.113-.994 1.177-6.53 4-7 1.923-.321 3.651.845 3.651 2.235A7.497 7.497 0 0 1 14 5.277c0-1.39 1.844-2.598 3.767-2.277 2.823.47 4.113 6.006 4 7-.08.703-1.725 1.722-3.656 1-1.261-.472-1.855-1.45-2.239-2.5"/></svg>
                                    </span>
                                @endif
                            </span>
                            <span class="min-w-0">
                                <span class="block truncate text-sm font-semibold">{{ $d->name }}</span>
                                @if ($d->breed)<span class="block truncate text-xs text-muted-foreground">{{ $d->breed }}</span>@endif
                            </span>
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground shrink-0"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                @endforeach

                <a href="{{ route('dog.create') }}" class="flex items-center justify-center gap-2 rounded-2xl border-2 border-dashed border-border bg-card/50 px-4 py-4 text-sm text-muted-foreground transition hover:border-accent hover:text-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg> Pridať ďalšieho psíka
                </a>
            </div>
        @endif
    </section>

    {{-- Psia mama / tato --}}
    <section class="mt-3 rounded-2xl bg-accent p-4 text-accent-foreground shadow-[var(--shadow-soft)]">
        <p class="text-xs font-medium uppercase tracking-wide opacity-90">Psia mama / tato</p>
        <p class="mt-1 text-xs opacity-80">Pridaj fotky so svojím psíkom (max. 4)</p>
        <div class="mt-3 grid grid-cols-4 gap-2">
            @for ($i = 0; $i < 4; $i++)
                @php $url = $withDogPhotos[$i] ?? null; @endphp
                @if ($url)
                    <div class="group relative aspect-square overflow-hidden rounded-xl bg-accent-foreground/10">
                        <img src="{{ $url }}" alt="" class="h-full w-full object-cover" loading="lazy">
                        <form method="POST" action="{{ route('profile.with-dog-photo.remove') }}" class="absolute right-1 top-1">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="index" value="{{ $i }}">
                            <button type="submit" aria-label="Odstrániť fotku" class="flex h-6 w-6 items-center justify-center rounded-full bg-black/45 text-white transition hover:bg-black/65">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                            </button>
                        </form>
                    </div>
                @else
                    @php $isNext = $i === count($withDogPhotos); @endphp
                    @if ($isNext)
                        <form method="POST" action="{{ route('profile.with-dog-photo.add') }}" enctype="multipart/form-data" class="contents">
                            @csrf
                            <label aria-label="Pridať fotku" class="flex aspect-square cursor-pointer items-center justify-center rounded-xl border-2 border-dashed border-accent-foreground/40 transition hover:border-accent-foreground/80 hover:bg-accent-foreground/10">
                                <input type="file" name="photo" accept="image/*" class="hidden" onchange="this.form.submit()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            </label>
                        </form>
                    @else
                        <span class="flex aspect-square items-center justify-center rounded-xl border-2 border-dashed border-accent-foreground/40 opacity-40">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        </span>
                    @endif
                @endif
            @endfor
        </div>
        <p class="mt-3 text-[11px] leading-relaxed text-muted-foreground">
            Nahraním fotiek súhlasíš so spracovaním osobných údajov a zverejnením fotografií v rámci aplikácie.
        </p>
    </section>

    {{-- Moji kamoši --}}
    <section class="mt-8">
        <div class="flex items-baseline justify-between">
            <h2 class="font-display text-2xl">Moji kamoši</h2>
            <a href="{{ route('friends.index') }}" class="text-xs text-accent-foreground/80 underline-offset-4 hover:underline">Spravovať</a>
        </div>
        <div class="mt-3 rounded-2xl bg-accent p-4 text-accent-foreground shadow-[var(--shadow-soft)]">
            @if ($friends->isEmpty())
                <p class="text-sm opacity-90">
                    Zatiaľ tu nikto nie je. Nájdi kamošov v <a href="{{ route('search') }}" class="underline underline-offset-4">vyhľadávaní</a> a pošli im žiadosť — keď ju potvrdia, objavia sa tu. 🐾
                </p>
            @else
                <ul class="space-y-2">
                    @foreach ($friends as $f)
                        <li>
                            <a href="{{ route('users.show', $f) }}" class="flex items-center gap-3 rounded-xl bg-accent-foreground/10 p-2 transition hover:bg-accent-foreground/15">
                                <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full bg-accent-foreground/20">
                                    @if ($f->avatar_url)<img src="{{ $f->avatar_url }}" alt="" class="h-full w-full object-cover">@endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium">{{ $f->display_name ?? $f->name }}</p>
                                    @if ($f->city)<p class="truncate text-xs opacity-80">{{ $f->city }}</p>@endif
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </section>
@endsection
