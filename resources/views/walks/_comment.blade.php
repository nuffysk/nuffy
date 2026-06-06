@php $c = $node['comment']; @endphp
<div class="{{ $depth > 0 ? 'mt-2 border-l-2 border-border/60 pl-3' : '' }}" x-data="{ reply: false, reportOpen: false }">
    <div class="flex items-start gap-2">
        <div class="h-8 w-8 shrink-0 overflow-hidden rounded-full bg-gradient-to-br from-accent/30 to-primary/30">
            @if ($c->author?->avatar_url)
                <img src="{{ $c->author->avatar_url }}" alt="" class="h-full w-full object-cover">
            @else
                <div class="flex h-full w-full items-center justify-center text-xs font-semibold text-muted-foreground">{{ mb_strtoupper(mb_substr($c->author?->display_name ?? $c->author?->name ?? '?', 0, 1)) }}</div>
            @endif
        </div>
        <div class="min-w-0 flex-1 rounded-2xl border border-border bg-card px-3 py-2">
            <div class="flex items-center justify-between gap-2">
                <p class="text-xs font-medium">{{ $c->author?->display_name ?? $c->author?->name ?? 'Niekto' }}</p>
                <span class="text-[10px] text-muted-foreground">{{ $c->created_at->translatedFormat('j. M, H:i') }}</span>
            </div>
            <p class="mt-1 whitespace-pre-wrap break-words text-sm">{{ $c->body }}</p>
            @auth
                <div class="mt-1 flex items-center gap-3">
                    @if ($depth < 4)
                        <button @click="reply = !reply" type="button" class="inline-flex items-center gap-1 text-[11px] text-muted-foreground hover:text-accent">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 10 20 15 15 20"/><path d="M4 4v7a4 4 0 0 0 4 4h12"/></svg>
                            <span x-text="reply ? 'Zrušiť' : 'Odpovedať'">Odpovedať</span>
                        </button>
                    @endif
                    @if ($c->author_id === auth()->id() || auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('walks.comments.delete', $c) }}" onsubmit="return confirm('Zmazať komentár?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1 text-[11px] text-muted-foreground hover:text-destructive">
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                Zmazať
                            </button>
                        </form>
                    @endif
                    @if ($c->author_id !== auth()->id())
                        <button @click="reportOpen = !reportOpen" type="button" class="inline-flex items-center gap-1 text-[11px] text-muted-foreground hover:text-destructive">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" x2="4" y1="22" y2="15"/></svg>
                            Nahlásiť
                        </button>
                    @endif
                </div>
                <form x-show="reportOpen" x-transition method="POST" action="{{ route('walks.comments.report', $c) }}" class="mt-2 space-y-2" style="display:none;">
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
            @endauth
        </div>
    </div>

    @auth
        @if ($depth < 4)
            <form x-show="reply" x-transition method="POST" action="{{ route('walks.comments.store', $c->topic_id) }}" class="ml-10 mt-2 flex items-end gap-2" style="display:none;">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $c->id }}">
                <textarea name="body" rows="2" maxlength="2000" placeholder="Tvoja odpoveď…" required class="block min-h-0 w-full resize-none rounded-xl border border-input bg-background px-3 py-2 text-sm"></textarea>
                <button type="submit" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary text-primary-foreground">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/></svg>
                </button>
            </form>
        @endif
    @endauth
</div>
@if (count($node['children']))
    <div class="ml-10 mt-2">
        @foreach ($node['children'] as $child)
            @include('walks._comment', ['node' => $child, 'depth' => $depth + 1])
        @endforeach
    </div>
@endif
