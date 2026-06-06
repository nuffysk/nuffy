@extends('layouts.app')

@section('content')
    <div class="pt-6" x-data="{ newTopic: false }">
        <h1 class="font-display text-3xl">Fórum</h1>
        <p class="mt-1 text-sm text-muted-foreground">Diskutuj s komunitou Ňuffy.</p>

        @if (session('status'))<p class="mt-3 text-sm text-accent">{{ session('status') }}</p>@endif

        @auth
            @if (auth()->user()->isAdmin())
                <section class="mt-4">
                    <button type="button" x-show="!newTopic" @click="newTopic = true" class="inline-flex w-full items-center justify-center gap-1.5 rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                        Nová téma
                    </button>
                    <form x-show="newTopic" x-transition method="POST" action="{{ route('walks.store') }}" class="space-y-3 rounded-2xl border border-border bg-card p-4" style="display:none;">
                        @csrf
                        <input type="text" name="title" maxlength="200" placeholder="Názov témy" required class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm">
                        <textarea name="body" rows="3" maxlength="5000" placeholder="Popis (voliteľné)" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm"></textarea>
                        <div class="flex gap-2">
                            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-primary px-4 py-2 text-sm font-medium text-primary-foreground">Publikovať</button>
                            <button type="button" @click="newTopic = false" class="inline-flex items-center justify-center rounded-xl px-4 py-2 text-sm font-medium text-muted-foreground hover:bg-muted">Zrušiť</button>
                        </div>
                    </form>
                </section>
            @endif
        @endauth

        <section class="mt-6 space-y-3">
            @forelse ($topics as $t)
                <a href="{{ route('walks.show', $t) }}" class="block rounded-2xl border bg-card transition {{ $t->pinned ? 'border-accent/50' : 'border-border' }}">
                    <div class="p-4">
                        <div class="flex items-start gap-3">
                            <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full bg-gradient-to-br from-accent/30 to-primary/30">
                                @if ($t->author?->avatar_url)
                                    <img src="{{ $t->author->avatar_url }}" alt="" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-sm font-semibold text-muted-foreground">{{ mb_strtoupper(mb_substr($t->author?->display_name ?? $t->author?->name ?? '?', 0, 1)) }}</div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2">
                                    @if ($t->pinned)<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" class="shrink-0 text-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 17v5"/><path d="M9 10.76a2 2 0 0 1-1.11 1.79l-1.78.9A2 2 0 0 0 5 15.24V16a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-.76a2 2 0 0 0-1.11-1.79l-1.78-.9A2 2 0 0 1 15 10.76V7a1 1 0 0 1 1-1 2 2 0 0 0 0-4H8a2 2 0 0 0 0 4 1 1 0 0 1 1 1z"/></svg>@endif
                                    <h3 class="font-display text-base leading-tight">{{ $t->title }}</h3>
                                </div>
                                <p class="mt-0.5 text-xs text-muted-foreground">{{ $t->author?->display_name ?? $t->author?->name ?? 'Admin' }} · {{ $t->created_at->translatedFormat('j.n.Y') }}</p>
                                @if ($t->body)
                                    <p class="mt-2 line-clamp-2 text-sm text-foreground/80">{{ $t->body }}</p>
                                @endif
                                <div class="mt-3 flex items-center gap-3 text-xs text-muted-foreground">
                                    <span class="inline-flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                                        {{ $t->comments_count }}
                                    </span>
                                    <span class="text-accent">Diskusia</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="rounded-2xl border border-dashed border-border bg-card/50 p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" class="mx-auto mb-2 text-muted-foreground" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                    <p class="font-display text-lg">Zatiaľ žiadne témy</p>
                    <p class="mt-1 text-sm text-muted-foreground">
                        @auth
                            {{ auth()->user()->isAdmin() ? 'Pridaj prvú tému pre diskusiu.' : 'Čoskoro pribudnú prvé témy.' }}
                        @else
                            Čoskoro pribudnú prvé témy.
                        @endauth
                    </p>
                </div>
            @endforelse
        </section>
    </div>
@endsection
