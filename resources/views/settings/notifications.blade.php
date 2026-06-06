@extends('layouts.app')

@section('content')
    <div class="pt-6" x-data="{ friend_requests: true, friend_accepted: true, sos: true, videos: true }">
        <h1 class="font-display text-3xl">Notifikácie</h1>

        <a href="{{ route('settings') }}" class="mt-2 inline-flex items-center gap-1 text-sm text-muted-foreground hover:text-foreground">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            Späť na nastavenia
        </a>

        @php
            $rows = [
                'friend_requests' => 'Žiadosti o priateľstvo',
                'friend_accepted' => 'Prijaté priateľstvo',
                'sos' => 'Nový SOS prípad',
                'videos' => 'Videá Zavoditko',
            ];
        @endphp

        <div class="mt-4 rounded-2xl border border-border bg-card p-4">
            <ul class="divide-y divide-border">
                @foreach ($rows as $key => $label)
                    <li class="flex items-center justify-between gap-3 py-3">
                        <span class="text-sm text-foreground">{{ $label }}</span>
                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                @click="{{ $key }} = true"
                                :aria-pressed="{{ $key }}"
                                class="flex h-12 w-12 items-center justify-center rounded-full text-[11px] font-bold transition-all"
                                :class="{{ $key }} ? 'bg-accent/40 text-accent-foreground ring-2 ring-accent shadow-md scale-105' : 'bg-accent/20 text-accent-foreground/70 hover:bg-accent/30'"
                            >Zapnúť</button>
                            <button
                                type="button"
                                @click="{{ $key }} = false"
                                :aria-pressed="!{{ $key }}"
                                class="flex h-12 w-12 items-center justify-center rounded-full text-[11px] font-bold text-white transition-all"
                                :class="!{{ $key }} ? 'bg-accent ring-2 ring-accent shadow-md scale-105' : 'bg-accent/60 hover:bg-accent/80'"
                            >Vypnúť</button>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
