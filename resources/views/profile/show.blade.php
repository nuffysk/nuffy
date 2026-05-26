@extends('layouts.app')

@section('content')
    <div class="pt-6">
        @if (session('status'))
            <p class="mb-4 rounded-xl border border-border bg-card px-4 py-2 text-sm text-accent">{{ session('status') }}</p>
        @endif

        <div class="flex items-center gap-4">
            <div class="h-20 w-20 overflow-hidden rounded-full bg-card ring-1 ring-border">
                @if ($user->avatar_url)
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->display_name }}" class="h-full w-full object-cover">
                @else
                    <div class="flex h-full w-full items-center justify-center text-muted-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                @endif
            </div>
            <div>
                <h1 class="font-display text-2xl">{{ $user->display_name ?? $user->name }}</h1>
                @if ($user->city)<p class="text-sm text-muted-foreground">{{ $user->city }}</p>@endif
                @if ($user->instagram)
                    <a href="https://instagram.com/{{ ltrim($user->instagram, '@') }}" target="_blank" rel="noopener" class="mt-1 inline-flex items-center gap-1 text-xs text-accent hover:underline">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                        @{{ ltrim($user->instagram, '@') }}
                    </a>
                @endif
            </div>
        </div>

        <a href="{{ route('profile.edit') }}" class="mt-4 inline-flex items-center gap-1.5 rounded-full border border-border bg-card px-4 py-2 text-sm font-medium hover:bg-muted">
            Upraviť profil
        </a>

        @if ($user->bio)
            <section class="mt-6 rounded-2xl border border-border bg-card p-4">
                <p class="text-sm leading-relaxed">{{ $user->bio }}</p>
            </section>
        @endif

        <section class="mt-6">
            <h2 class="font-display text-lg">Môj psík</h2>
            @if ($dog)
                <a href="{{ route('dog.edit') }}" class="mt-3 flex gap-3 overflow-hidden rounded-2xl border border-border bg-card transition hover:shadow-[var(--shadow-soft)]">
                    <div class="h-24 w-28 shrink-0 bg-muted">
                        @if ($dog->photo_url)
                            <img src="{{ $dog->photo_url }}" alt="{{ $dog->name }}" class="h-full w-full object-cover">
                        @endif
                    </div>
                    <div class="flex flex-col justify-center py-3 pr-4">
                        <p class="font-display text-lg">{{ $dog->name }}</p>
                        @if ($dog->breed)<p class="text-xs text-muted-foreground">{{ $dog->breed }}</p>@endif
                    </div>
                </a>
            @else
                <a href="{{ route('dog.edit') }}" class="mt-3 block rounded-2xl border border-dashed border-border bg-card p-4 text-center text-sm text-muted-foreground hover:bg-muted">
                    + Pridať psíka
                </a>
            @endif
        </section>

        <section class="mt-6">
            <h2 class="font-display text-lg">Kamoši ({{ $friends->count() }})</h2>
            @if ($friends->isEmpty())
                <p class="mt-2 text-sm text-muted-foreground">Zatiaľ žiadni kamoši.</p>
            @else
                <div class="mt-3 grid grid-cols-3 gap-3">
                    @foreach ($friends as $f)
                        <a href="{{ route('users.show', $f) }}" class="flex flex-col items-center gap-2 rounded-2xl border border-border bg-card p-3 text-center">
                            <div class="h-12 w-12 overflow-hidden rounded-full bg-muted">
                                @if ($f->avatar_url)<img src="{{ $f->avatar_url }}" alt="" class="h-full w-full object-cover">@endif
                            </div>
                            <p class="font-display text-xs leading-tight line-clamp-2">{{ $f->display_name ?? $f->name }}</p>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
@endsection
