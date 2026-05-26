@extends('layouts.app')

@section('content')
    <div class="pt-6" x-data="{ tab: '{{ request('tab', 'friends') }}' }">
        <h1 class="font-display text-3xl">Kamoši</h1>
        <p class="mt-1 text-sm text-muted-foreground">Ľudia a psíky z tvojej komunity.</p>

        @if (session('status'))<p class="mt-3 text-sm text-accent">{{ session('status') }}</p>@endif

        <div class="mt-5 flex gap-2 rounded-full bg-card p-1 text-sm">
            <button type="button" @click="tab = 'friends'" :class="tab === 'friends' ? 'bg-accent text-accent-foreground' : 'text-muted-foreground'" class="flex-1 rounded-full px-4 py-2 transition">
                Kamoši ({{ $accepted->count() }})
            </button>
            <button type="button" @click="tab = 'requests'" :class="tab === 'requests' ? 'bg-accent text-accent-foreground' : 'text-muted-foreground'" class="flex-1 rounded-full px-4 py-2 transition">
                Žiadosti ({{ $incoming->count() }})
            </button>
        </div>

        <div x-show="tab === 'friends'" class="mt-6 space-y-3">
            @forelse ($accepted as $f)
                @php $other = $f->requester_id === $me->id ? $f->addressee : $f->requester; @endphp
                <div class="flex items-center justify-between gap-3 rounded-2xl border border-border bg-card p-3">
                    <a href="{{ route('users.show', $other) }}" class="flex items-center gap-3">
                        <div class="h-10 w-10 overflow-hidden rounded-full bg-muted">
                            @if ($other->avatar_url)<img src="{{ $other->avatar_url }}" alt="" class="h-full w-full object-cover">@endif
                        </div>
                        <div>
                            <p class="text-sm font-medium">{{ $other->display_name ?? $other->name }}</p>
                            @if ($other->city)<p class="text-xs text-muted-foreground">{{ $other->city }}</p>@endif
                        </div>
                    </a>
                    <a href="{{ route('inbox.show', $other) }}" class="rounded-full border border-border bg-card px-3 py-1.5 text-xs font-medium hover:bg-muted">Chat</a>
                </div>
            @empty
                <p class="text-sm text-muted-foreground">Zatiaľ žiadni kamoši.</p>
            @endforelse

            @if ($suggestions->isNotEmpty())
                <section class="mt-8">
                    <h2 class="font-display text-lg">Možno poznáš</h2>
                    <div class="mt-3 grid grid-cols-2 gap-3">
                        @foreach ($suggestions as $s)
                            <a href="{{ route('users.show', $s) }}" class="flex items-center gap-2 rounded-2xl border border-border bg-card p-3">
                                <div class="h-10 w-10 overflow-hidden rounded-full bg-muted">
                                    @if ($s->avatar_url)<img src="{{ $s->avatar_url }}" alt="" class="h-full w-full object-cover">@endif
                                </div>
                                <div class="min-w-0">
                                    <p class="truncate text-xs font-medium">{{ $s->display_name ?? $s->name }}</p>
                                    @if ($s->city)<p class="truncate text-[10px] text-muted-foreground">{{ $s->city }}</p>@endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>

        <div x-show="tab === 'requests'" class="mt-6 space-y-3" style="display: none;">
            @forelse ($incoming as $f)
                <div class="flex items-center justify-between gap-3 rounded-2xl border border-border bg-card p-3">
                    <a href="{{ route('users.show', $f->requester) }}" class="flex items-center gap-3">
                        <div class="h-10 w-10 overflow-hidden rounded-full bg-muted">
                            @if ($f->requester->avatar_url)<img src="{{ $f->requester->avatar_url }}" alt="" class="h-full w-full object-cover">@endif
                        </div>
                        <div>
                            <p class="text-sm font-medium">{{ $f->requester->display_name ?? $f->requester->name }}</p>
                            @if ($f->requester->city)<p class="text-xs text-muted-foreground">{{ $f->requester->city }}</p>@endif
                        </div>
                    </a>
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('friends.respond', ['friendship' => $f->id, 'action' => 'accept']) }}">
                            @csrf
                            <button type="submit" class="rounded-full bg-accent px-3 py-1.5 text-xs font-medium text-accent-foreground">Prijať</button>
                        </form>
                        <form method="POST" action="{{ route('friends.respond', ['friendship' => $f->id, 'action' => 'decline']) }}">
                            @csrf
                            <button type="submit" class="rounded-full border border-border bg-card px-3 py-1.5 text-xs">Odmietnuť</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-sm text-muted-foreground">Žiadne nové žiadosti.</p>
            @endforelse
        </div>
    </div>
@endsection
