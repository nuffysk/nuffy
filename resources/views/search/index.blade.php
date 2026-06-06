@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Hľadať</h1>
        <p class="mt-1 text-sm text-muted-foreground">Ľudí, psíkov a miesta.</p>

        <form method="GET" action="{{ route('search') }}" class="relative mt-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input
                type="search"
                name="q"
                value="{{ $q }}"
                placeholder="Meno, miesto…"
                autocomplete="off"
                class="block w-full rounded-md border border-input bg-background px-3 py-2 pl-9 text-sm"
            >
        </form>

        @if ($users->isNotEmpty())
            <section class="mt-6">
                <h2 class="font-display text-lg">Ľudia</h2>
                <ul class="mt-2 space-y-2">
                    @foreach ($users as $u)
                        <li>
                            <a href="{{ route('users.show', $u) }}" class="flex items-center gap-3 rounded-2xl border border-border bg-card p-3">
                                <div class="h-10 w-10 overflow-hidden rounded-full bg-muted">
                                    @if ($u->avatar_url)<img src="{{ $u->avatar_url }}" alt="" class="h-full w-full object-cover">@endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium">{{ $u->display_name ?? $u->name }}</p>
                                    @if ($u->city)<p class="text-xs text-muted-foreground">{{ $u->city }}</p>@endif
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        @if ($places->isNotEmpty())
            <section class="mt-6">
                <h2 class="font-display text-lg">Miesta</h2>
                <ul class="mt-2 space-y-2">
                    @foreach ($places as $p)
                        <li>
                            <a href="{{ route('places.show', $p) }}" class="flex items-center justify-between rounded-2xl border border-border bg-card p-3">
                                <div>
                                    <p class="text-sm font-medium">{{ $p->name }}</p>
                                    <p class="text-xs text-muted-foreground">{{ $p->category }}@if ($p->city) · {{ $p->city }}@endif</p>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        @if (strlen($q) >= 2 && $users->isEmpty() && $places->isEmpty())
            <p class="mt-8 text-center text-sm text-muted-foreground">Nič sa nenašlo.</p>
        @endif
    </div>
@endsection
