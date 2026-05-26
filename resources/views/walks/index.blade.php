@extends('layouts.app')

@section('content')
    <div class="pt-6" x-data="{ newTopic: false }">
        <h1 class="font-display text-3xl">Fórum</h1>
        <p class="mt-1 text-sm text-muted-foreground">Diskutuj s komunitou Ňuffy.</p>

        @if (session('status'))<p class="mt-3 text-sm text-accent">{{ session('status') }}</p>@endif

        @auth
            @if (auth()->user()->isAdmin())
                <button type="button" @click="newTopic = !newTopic" class="mt-5 inline-flex w-full items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)]">
                    <span x-show="!newTopic">+ Nová téma</span>
                    <span x-show="newTopic" style="display:none;">Zatvoriť</span>
                </button>
                <form x-show="newTopic" x-transition method="POST" action="{{ route('walks.store') }}" class="mt-4 space-y-3 rounded-2xl border border-border bg-card p-4" style="display:none;">
                    @csrf
                    <input type="text" name="title" maxlength="200" placeholder="Názov témy" required class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm">
                    <textarea name="body" rows="4" maxlength="5000" placeholder="Krátky úvod (voliteľné)" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm"></textarea>
                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-accent px-4 py-2 text-sm font-medium text-accent-foreground">Vytvoriť tému</button>
                </form>
            @endif
        @endauth

        <div class="mt-6 space-y-3">
            @forelse ($topics as $t)
                <a href="{{ route('walks.show', $t) }}" class="block rounded-2xl border border-border bg-card p-4 transition hover:shadow-[var(--shadow-soft)]">
                    <div class="flex items-start gap-3">
                        <div class="h-8 w-8 overflow-hidden rounded-full bg-muted">
                            @if ($t->author?->avatar_url)<img src="{{ $t->author->avatar_url }}" alt="" class="h-full w-full object-cover">@endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                @if ($t->pinned)<span class="rounded-full bg-[var(--heart-soft)] px-2 py-0.5 text-[10px] text-accent">PIN</span>@endif
                                <p class="font-display text-lg">{{ $t->title }}</p>
                            </div>
                            @if ($t->body)<p class="mt-1 line-clamp-2 text-sm text-muted-foreground">{{ $t->body }}</p>@endif
                            <div class="mt-2 flex items-center gap-3 text-xs text-muted-foreground">
                                <span>{{ $t->author?->display_name ?? $t->author?->name }}</span>
                                <span>·</span>
                                <span>{{ $t->created_at->diffForHumans() }}</span>
                                <span>·</span>
                                <span>💬 {{ $t->comments_count }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <p class="text-sm text-muted-foreground">Zatiaľ žiadne témy.</p>
            @endforelse
        </div>
    </div>
@endsection
