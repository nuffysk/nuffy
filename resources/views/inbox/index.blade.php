@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Správy</h1>

        <div class="mt-5 space-y-2">
            @forelse ($conversations as $c)
                @php $p = $partners[$c->partner_id] ?? null; @endphp
                @if ($p)
                    <a href="{{ route('inbox.show', $p) }}" class="flex items-center gap-3 rounded-2xl border border-border bg-card p-3 hover:bg-muted">
                        <div class="h-12 w-12 overflow-hidden rounded-full bg-muted">
                            @if ($p->avatar_url)<img src="{{ $p->avatar_url }}" alt="" class="h-full w-full object-cover">@endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium">{{ $p->display_name ?? $p->name }}</p>
                                @if ($c->last_message)
                                    <span class="text-xs text-muted-foreground">{{ $c->last_message->created_at->diffForHumans() }}</span>
                                @endif
                            </div>
                            @if ($c->last_message)
                                <p class="line-clamp-1 text-xs text-muted-foreground">
                                    @if ($c->last_message->sender_id === auth()->id())Ty: @endif{{ $c->last_message->body }}
                                </p>
                            @endif
                        </div>
                        @if ($c->unread > 0)
                            <span class="inline-flex h-6 min-w-6 items-center justify-center rounded-full bg-accent px-2 text-xs font-medium text-accent-foreground">{{ $c->unread }}</span>
                        @endif
                    </a>
                @endif
            @empty
                <p class="text-sm text-muted-foreground">Žiadne správy. Pošli prvú správu kamošovi.</p>
            @endforelse
        </div>
    </div>
@endsection
