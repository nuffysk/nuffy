@extends('layouts.app')

@section('content')
    <div class="pt-6" x-data="{ showForm: false, editing: null, title: '', content: '' }">
        <h1 class="font-display text-3xl">Novinky</h1>
        <p class="mt-1 text-sm text-muted-foreground">Čo nové v Ňuffy.</p>

        @if (session('status'))<p class="mt-3 text-sm text-accent">{{ session('status') }}</p>@endif

        @auth
            @if (auth()->user()->isAdmin())
                <div class="mt-4" x-show="!showForm">
                    <button type="button" @click="editing = null; title = ''; content = ''; showForm = true" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        Pridať novinku
                    </button>
                </div>

                <form
                    x-show="showForm" x-transition style="display:none;"
                    :action="editing ? `/novinky/${editing}` : '{{ route('novinky.store') }}'"
                    method="POST"
                    class="mt-4 space-y-3 rounded-2xl border border-border bg-card p-4"
                >
                    @csrf
                    <template x-if="editing"><input type="hidden" name="_method" value="PATCH"></template>
                    <div class="flex items-center justify-between">
                        <h2 class="font-display text-base font-semibold" x-text="editing ? 'Upraviť novinku' : 'Nová novinka'"></h2>
                        <button type="button" @click="showForm = false" class="rounded-full p-1 text-muted-foreground hover:bg-muted" aria-label="Zavrieť">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        </button>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-muted-foreground">Názov</label>
                        <input name="title" x-model="title" maxlength="140" required placeholder="Napr. Ňuffy Dog Festival Bratislava" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-muted-foreground">Text článku</label>
                        <textarea name="content" x-model="content" rows="8" required placeholder="Celý text novinky…" class="block w-full rounded-xl border border-input bg-background px-4 py-3 text-sm"></textarea>
                    </div>
                    <div class="flex gap-2 pt-1">
                        <button type="submit" class="flex-1 rounded-xl bg-primary px-4 py-2 text-sm font-medium text-primary-foreground">Uložiť</button>
                        <button type="button" @click="showForm = false" class="rounded-xl border border-border bg-card px-4 py-2 text-sm">Zrušiť</button>
                    </div>
                </form>
            @endif
        @endauth

        <section class="mt-5 space-y-2.5">
            @forelse ($items as $n)
                <div class="relative">
                    <a href="{{ route('novinky.show', $n) }}" class="flex w-full items-center gap-3 rounded-2xl bg-card px-[18px] py-4 shadow-[0px_4px_14px_rgba(139,94,60,0.10)] transition-transform duration-150 ease-out active:scale-[0.98]">
                        <div class="min-w-0 flex-1">
                            <h3 class="truncate font-semibold leading-snug text-foreground" style="font-size: 15px;">{{ $n->title }}</h3>
                            <p class="mt-0.5 text-xs text-muted-foreground">{{ $n->created_at->format('j. n. Y') }}</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 text-muted-foreground"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>

                    @auth
                        @if (auth()->user()->isAdmin())
                            <div class="absolute right-12 top-1/2 -translate-y-1/2 flex items-center gap-1">
                                <button type="button" @click.prevent="editing = {{ $n->id }}; title = @js($n->title); content = @js($n->content); showForm = true" aria-label="Upraviť" class="rounded-full bg-background/90 p-1.5 text-muted-foreground shadow-sm hover:text-foreground">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                                </button>
                                <form method="POST" action="{{ route('novinky.destroy', $n) }}" onsubmit="return confirm('Zmazať novinku „{{ $n->title }}"?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" aria-label="Zmazať" class="rounded-full bg-background/90 p-1.5 text-destructive shadow-sm hover:bg-destructive hover:text-destructive-foreground">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            @empty
                <p class="rounded-2xl border border-dashed border-border bg-card/50 px-4 py-8 text-center text-sm text-muted-foreground">
                    Zatiaľ tu nie sú žiadne novinky.
                </p>
            @endforelse
        </section>
    </div>
@endsection
