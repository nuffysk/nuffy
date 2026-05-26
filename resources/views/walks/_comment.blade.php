@php $c = $node['comment']; @endphp
<div class="rounded-2xl border border-border bg-card p-3" @if ($depth > 0) style="margin-left: {{ min($depth * 16, 48) }}px;" @endif x-data="{ reply: false, reportOpen: false }">
    <div class="flex items-start gap-2">
        <div class="h-8 w-8 shrink-0 overflow-hidden rounded-full bg-muted">
            @if ($c->author?->avatar_url)<img src="{{ $c->author->avatar_url }}" alt="" class="h-full w-full object-cover">@endif
        </div>
        <div class="min-w-0 flex-1">
            <p class="text-xs font-medium">{{ $c->author?->display_name ?? $c->author?->name }}
                <span class="text-muted-foreground">· {{ $c->created_at->diffForHumans() }}</span>
            </p>
            <p class="mt-1 text-sm">{{ $c->body }}</p>
            @auth
                <div class="mt-2 flex flex-wrap gap-3 text-xs text-muted-foreground">
                    @if ($depth < 4)
                        <button @click="reply = !reply" type="button" class="hover:text-foreground">Odpovedať</button>
                    @endif
                    @if ($c->author_id !== auth()->id())
                        <button @click="reportOpen = !reportOpen" type="button" class="hover:text-foreground">Nahlásiť</button>
                    @endif
                    @if ($c->author_id === auth()->id() || auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('walks.comments.delete', $c) }}" onsubmit="return confirm('Zmazať komentár?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-destructive hover:opacity-80">Zmazať</button>
                        </form>
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
                @if ($depth < 4)
                    <form x-show="reply" x-transition method="POST" action="{{ route('walks.comments.store', $c->topic_id) }}" class="mt-2 space-y-2" style="display:none;">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $c->id }}">
                        <textarea name="body" rows="2" maxlength="2000" placeholder="Odpoveď…" required class="block w-full rounded-xl border border-input bg-background px-3 py-2 text-sm"></textarea>
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-primary px-3 py-1.5 text-xs font-medium text-primary-foreground">Odoslať</button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</div>
@foreach ($node['children'] as $child)
    @include('walks._comment', ['node' => $child, 'depth' => $depth + 1])
@endforeach
