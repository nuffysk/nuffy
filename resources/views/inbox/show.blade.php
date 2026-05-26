@extends('layouts.app')

@section('content')
    <div class="pt-6"
         x-data="{
            messages: {{ Js::from($messages->map(fn ($m) => ['id' => $m->id, 'sender_id' => $m->sender_id, 'body' => $m->body, 'created_at' => $m->created_at->toIso8601String()])) }},
            me: {{ auth()->id() }},
            lastId() { return this.messages.length ? this.messages[this.messages.length - 1].id : 0; },
            async poll() {
                try {
                    const res = await fetch(`{{ route('inbox.poll', $partner) }}?after=${this.lastId()}`, { headers: { Accept: 'application/json' } });
                    if (!res.ok) return;
                    const data = await res.json();
                    if (data.messages && data.messages.length) {
                        this.messages.push(...data.messages);
                        this.$nextTick(() => this.scrollDown());
                    }
                } catch (e) {}
            },
            scrollDown() { this.$refs.thread.scrollTop = this.$refs.thread.scrollHeight; },
         }"
         x-init="scrollDown(); setInterval(() => poll(), 5000);">
        <a href="{{ route('inbox.index') }}" class="inline-flex items-center gap-1 rounded-full border border-border bg-card px-3 py-1.5 text-sm hover:bg-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Späť
        </a>

        <div class="mt-4 flex items-center gap-3">
            <a href="{{ route('users.show', $partner) }}" class="h-10 w-10 overflow-hidden rounded-full bg-muted">
                @if ($partner->avatar_url)<img src="{{ $partner->avatar_url }}" alt="" class="h-full w-full object-cover">@endif
            </a>
            <p class="font-display text-xl">{{ $partner->display_name ?? $partner->name }}</p>
        </div>

        <div x-ref="thread" class="mt-4 h-[calc(100vh-380px)] min-h-[300px] space-y-2 overflow-y-auto rounded-2xl border border-border bg-card p-3">
            <template x-for="m in messages" :key="m.id">
                <div :class="m.sender_id === me ? 'ml-auto bg-accent text-accent-foreground' : 'bg-background'" class="max-w-[80%] rounded-2xl border border-border px-3 py-2 text-sm">
                    <p x-text="m.body" class="whitespace-pre-wrap"></p>
                </div>
            </template>
            <p x-show="!messages.length" class="text-center text-sm text-muted-foreground" style="display:none;">Začni konverzáciu ♥</p>
        </div>

        <form method="POST" action="{{ route('inbox.send', $partner) }}" class="mt-3 flex gap-2">
            @csrf
            <input type="text" name="body" maxlength="2000" placeholder="Napíš správu…" required class="flex-1 rounded-xl border border-input bg-background px-4 py-3 text-sm">
            <button type="submit" class="rounded-xl bg-primary px-4 py-2 text-sm font-medium text-primary-foreground">Poslať</button>
        </form>
    </div>
@endsection
