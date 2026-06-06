@extends('layouts.app')

@section('content')
    <div class="pt-6" x-data="{ tab: '{{ request('tab', 'friends') }}', showAll: false }">
        <h1 class="font-display text-3xl">Kamoši</h1>
        <p class="mt-1 text-sm text-muted-foreground">Ľudia a psíky z tvojej komunity.</p>

        @if (session('status'))<p class="mt-3 text-sm text-accent">{{ session('status') }}</p>@endif

        <div class="mt-4 flex gap-2">
            <button
                type="button"
                @click="tab = 'friends'"
                :class="tab === 'friends' ? 'border-accent bg-accent text-accent-foreground' : 'border-border bg-card text-muted-foreground'"
                class="flex-1 rounded-full border px-3 py-2 text-xs transition"
            >
                Kamoši ({{ $accepted->count() }})
            </button>
            <button
                type="button"
                @click="tab = 'requests'"
                :class="tab === 'requests' ? 'border-accent bg-accent text-accent-foreground' : 'border-border bg-card text-muted-foreground'"
                class="flex-1 rounded-full border px-3 py-2 text-xs transition"
            >
                Requesty ({{ $incoming->count() }})
            </button>
        </div>

        <ul x-show="tab === 'friends'" class="mt-5 space-y-3">
            @forelse ($accepted as $f)
                @php $other = $f->requester_id === $me->id ? $f->addressee : $f->requester; @endphp
                <li class="flex items-center gap-3 rounded-2xl border border-border bg-card p-3">
                    <a href="{{ route('users.show', $other) }}" class="flex flex-1 items-center gap-3">
                        <div class="h-12 w-12 overflow-hidden rounded-full bg-muted">
                            @if ($other->avatar_url)<img src="{{ $other->avatar_url }}" alt="" class="h-full w-full object-cover">@endif
                        </div>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium">{{ $other->display_name ?? $other->name ?? 'Niekto' }}</p>
                            @if ($other->city)<p class="truncate text-xs text-muted-foreground">{{ $other->city }}</p>@endif
                        </div>
                    </a>
                </li>
            @empty
                <p class="text-sm text-muted-foreground">Nič tu zatiaľ nie je.</p>
            @endforelse
        </ul>

        <ul x-show="tab === 'requests'" class="mt-5 space-y-3" style="display: none;">
            @forelse ($incoming as $f)
                <li class="flex items-center gap-3 rounded-2xl border border-border bg-card p-3">
                    <a href="{{ route('users.show', $f->requester) }}" class="flex flex-1 items-center gap-3">
                        <div class="h-12 w-12 overflow-hidden rounded-full bg-muted">
                            @if ($f->requester->avatar_url)<img src="{{ $f->requester->avatar_url }}" alt="" class="h-full w-full object-cover">@endif
                        </div>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium">{{ $f->requester->display_name ?? $f->requester->name ?? 'Niekto' }}</p>
                            @if ($f->requester->city)<p class="truncate text-xs text-muted-foreground">{{ $f->requester->city }}</p>@endif
                        </div>
                    </a>
                    <div class="flex gap-1">
                        <form method="POST" action="{{ route('friends.respond', ['friendship' => $f->id, 'action' => 'accept']) }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center justify-center rounded-md bg-primary px-3 py-1.5 text-sm font-medium text-primary-foreground">Prijať</button>
                        </form>
                        <form method="POST" action="{{ route('friends.respond', ['friendship' => $f->id, 'action' => 'decline']) }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center justify-center rounded-md px-3 py-1.5 text-sm font-medium text-foreground hover:bg-muted">Odmietnuť</button>
                        </form>
                    </div>
                </li>
            @empty
                <p class="text-sm text-muted-foreground">Nič tu zatiaľ nie je.</p>
            @endforelse
        </ul>

        @if ($suggestions->isNotEmpty())
            <section x-show="tab === 'friends'" class="mt-8">
                <h2 class="mb-3 text-sm font-semibold text-muted-foreground">Spoznaj nových ľudí</h2>
                <ul class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                    @foreach ($suggestions as $i => $s)
                        <li @if ($i >= 6) x-show="showAll" style="display: none;" @endif class="rounded-2xl border border-border bg-card p-3 text-center">
                            <a href="{{ route('users.show', $s) }}" class="flex flex-col items-center gap-2">
                                <div class="h-14 w-14 overflow-hidden rounded-full bg-muted">
                                    @if ($s->avatar_url)<img src="{{ $s->avatar_url }}" alt="" class="h-full w-full object-cover">@endif
                                </div>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-medium">{{ $s->display_name ?? $s->name }}</p>
                                    @if ($s->city)<p class="truncate text-xs text-muted-foreground">{{ $s->city }}</p>@endif
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
                @if ($suggestions->count() > 6)
                    <div x-show="!showAll" class="mt-4 flex justify-center">
                        <button type="button" @click="showAll = true" class="inline-flex items-center justify-center rounded-md border border-border bg-card px-3 py-1.5 text-sm font-medium hover:bg-muted">
                            Pozrieť všetkých
                        </button>
                    </div>
                @endif
            </section>
        @endif
    </div>
@endsection
