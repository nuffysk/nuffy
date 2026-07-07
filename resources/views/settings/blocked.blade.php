@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Blokovaní používatelia</h1>

        <a href="{{ route('settings') }}" class="mt-2 inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            Späť na nastavenia
        </a>

        @if (session('status'))
            <p class="mt-3 rounded-xl border border-border bg-card px-4 py-2 text-sm text-accent">{{ session('status') }}</p>
        @endif

        @if ($blocks->isEmpty())
            <div class="mt-4 rounded-2xl border border-border bg-card p-4 text-sm text-muted-foreground">
                Nikoho nemáš zablokovaného. Používateľa môžeš zablokovať na jeho profile — potom si navzájom neuvidíte profily a nebude ti môcť posielať žiadosti o priateľstvo.
            </div>
        @else
            <ul class="mt-4 space-y-2">
                @foreach ($blocks as $b)
                    <li class="flex items-center gap-3 rounded-2xl border border-border bg-card p-3">
                        <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full bg-muted">
                            @if ($b->blocked?->avatar_url)
                                <img src="{{ $b->blocked->avatar_url }}" alt="" class="h-full w-full object-cover">
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium">{{ $b->blocked?->display_name ?? $b->blocked?->name ?? 'Používateľ' }}</p>
                            <p class="truncate text-xs text-muted-foreground">
                                @if ($b->blocked?->city){{ $b->blocked->city }} · @endif
                                zablokované {{ $b->created_at->format('d.m.Y') }}
                            </p>
                        </div>
                        @if ($b->blocked)
                            <form method="POST" action="{{ route('users.unblock', $b->blocked) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-full border border-border px-3 py-1.5 text-xs font-medium transition hover:bg-muted">
                                    Odblokovať
                                </button>
                            </form>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
