@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Hľadať</h1>
        <p class="mt-1 text-sm text-muted-foreground">Ľudí, psíkov a miesta.</p>

        <form method="GET" action="{{ route('search') }}" class="mt-5">
            <input
                type="search"
                name="q"
                value="{{ $q }}"
                placeholder="Hľadaj meno alebo miesto…"
                autocomplete="off"
                class="block w-full rounded-2xl border border-input bg-background px-4 py-3 text-base"
            >
        </form>

        @if (strlen($q) >= 2)
            <section class="mt-6">
                <h2 class="font-display text-lg">Ľudia</h2>
                @if ($users->isEmpty())
                    <p class="mt-2 text-sm text-muted-foreground">Nič sa nenašlo.</p>
                @else
                    <div class="mt-3 space-y-2">
                        @foreach ($users as $u)
                            <a href="{{ route('users.show', $u) }}" class="flex items-center gap-3 rounded-2xl border border-border bg-card p-3">
                                <div class="h-10 w-10 overflow-hidden rounded-full bg-muted">
                                    @if ($u->avatar_url)<img src="{{ $u->avatar_url }}" alt="" class="h-full w-full object-cover">@endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium">{{ $u->display_name ?? $u->name }}</p>
                                    @if ($u->city)<p class="text-xs text-muted-foreground">{{ $u->city }}</p>@endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </section>

            <section class="mt-6">
                <h2 class="font-display text-lg">Miesta</h2>
                @if ($places->isEmpty())
                    <p class="mt-2 text-sm text-muted-foreground">Nič sa nenašlo.</p>
                @else
                    <div class="mt-3 space-y-2">
                        @foreach ($places as $p)
                            <a href="{{ route('places.show', $p) }}" class="flex items-center justify-between rounded-2xl border border-border bg-card p-3">
                                <div>
                                    <p class="text-sm font-medium">{{ $p->name }}</p>
                                    @if ($p->city)<p class="text-xs text-muted-foreground">{{ $p->city }}</p>@endif
                                </div>
                                <span class="rounded-full bg-[var(--heart-soft)] px-2 py-1 text-[10px] uppercase tracking-wider text-accent">{{ $p->category }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </section>
        @endif
    </div>
@endsection
