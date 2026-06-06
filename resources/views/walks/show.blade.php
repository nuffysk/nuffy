@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <a href="{{ route('walks.index') }}" class="inline-flex items-center gap-1 rounded-full border border-border bg-card px-3 py-1.5 text-sm hover:bg-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Späť
        </a>

        @if (session('status'))<p class="mt-3 text-sm text-accent">{{ session('status') }}</p>@endif

        <article class="mt-4 rounded-2xl border bg-card p-4 {{ $topic->pinned ? 'border-accent/50' : 'border-border' }}">
            <div class="flex items-start gap-3">
                <div class="h-10 w-10 shrink-0 overflow-hidden rounded-full bg-gradient-to-br from-accent/30 to-primary/30">
                    @if ($topic->author?->avatar_url)
                        <img src="{{ $topic->author->avatar_url }}" alt="" class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full w-full items-center justify-center text-sm font-semibold text-muted-foreground">{{ mb_strtoupper(mb_substr($topic->author?->display_name ?? $topic->author?->name ?? '?', 0, 1)) }}</div>
                    @endif
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        @if ($topic->pinned)<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" class="shrink-0 text-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 17v5"/><path d="M9 10.76a2 2 0 0 1-1.11 1.79l-1.78.9A2 2 0 0 0 5 15.24V16a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-.76a2 2 0 0 0-1.11-1.79l-1.78-.9A2 2 0 0 1 15 10.76V7a1 1 0 0 1 1-1 2 2 0 0 0 0-4H8a2 2 0 0 0 0 4 1 1 0 0 1 1 1z"/></svg>@endif
                        <h1 class="font-display text-2xl leading-tight">{{ $topic->title }}</h1>
                    </div>
                    <p class="mt-0.5 text-xs text-muted-foreground">{{ $topic->author?->display_name ?? $topic->author?->name ?? 'Admin' }} · {{ $topic->created_at->translatedFormat('j.n.Y') }}</p>
                    @if ($topic->body)
                        <p class="mt-2 whitespace-pre-wrap break-words text-sm text-foreground/80">{{ $topic->body }}</p>
                    @endif
                </div>
            </div>
        </article>

        <section class="mt-6 space-y-3">
            @forelse ($tree as $node)
                @include('walks._comment', ['node' => $node, 'depth' => 0])
            @empty
                <p class="text-sm text-muted-foreground">Buď prvý kto napíše komentár 🐾</p>
            @endforelse

            @auth
                <form method="POST" action="{{ route('walks.comments.store', $topic) }}" class="flex items-end gap-2 border-t border-border/60 pt-2">
                    @csrf
                    <textarea name="body" rows="2" maxlength="2000" placeholder="Napíš komentár…" required class="block min-h-0 w-full resize-none rounded-xl border border-input bg-background px-4 py-3 text-sm"></textarea>
                    <button type="submit" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary text-primary-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/></svg>
                    </button>
                </form>

                <div class="flex items-center justify-between pt-1">
                    @if ($topic->author_id !== auth()->id())
                        <div x-data="{ reportOpen: false }">
                            <button type="button" @click="reportOpen = !reportOpen" class="inline-flex items-center gap-1 text-xs text-muted-foreground hover:text-destructive">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" x2="4" y1="22" y2="15"/></svg>
                                Nahlásiť tému
                            </button>
                            <form x-show="reportOpen" x-transition method="POST" action="{{ route('walks.topics.report', $topic) }}" class="mt-2 space-y-2" style="display:none;">
                                @csrf
                                <select name="reason" required class="block w-full rounded-xl border border-input bg-background px-3 py-2 text-xs">
                                    <option value="">— Dôvod —</option>
                                    <option value="spam">Spam / reklama</option>
                                    <option value="urazlivy">Urážlivý / vulgárny</option>
                                    <option value="tyranie">Týranie zvierat</option>
                                    <option value="iny">Iný dôvod</option>
                                </select>
                                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-destructive px-3 py-1.5 text-xs font-medium text-destructive-foreground">Nahlásiť</button>
                            </form>
                        </div>
                    @else
                        <span></span>
                    @endif
                    @if (auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('walks.destroy', $topic) }}" onsubmit="return confirm('Zmazať túto tému aj s diskusiou?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1 text-xs text-muted-foreground hover:text-destructive">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                Zmazať tému
                            </button>
                        </form>
                    @endif
                </div>
            @endauth
        </section>
    </div>
@endsection
