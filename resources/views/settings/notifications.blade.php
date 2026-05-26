@extends('layouts.app')

@section('content')
    <div class="pt-6" x-data="{ messages: true, friend_requests: true, friend_accepted: true, sos: true, videos: false }">
        <a href="{{ route('settings') }}" class="inline-flex items-center gap-1 rounded-full border border-border bg-card px-3 py-1.5 text-sm hover:bg-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Späť
        </a>
        <h1 class="mt-4 font-display text-3xl">Notifikácie</h1>

        @php
            $rows = [
                'messages' => 'Nové správy',
                'friend_requests' => 'Žiadosti o priateľstvo',
                'friend_accepted' => 'Prijaté priateľstvá',
                'sos' => 'SOS upozornenia',
                'videos' => 'Nové videá',
            ];
        @endphp

        <div class="mt-6 divide-y divide-border rounded-2xl border border-border bg-card">
            @foreach ($rows as $key => $label)
                <div class="flex items-center justify-between px-4 py-3">
                    <span class="text-sm font-medium">{{ $label }}</span>
                    <div class="flex gap-2">
                        <button @click="{{ $key }} = true" :class="{{ $key }} ? 'bg-accent text-accent-foreground' : 'bg-card border border-border text-muted-foreground'" class="rounded-full px-3 py-1 text-xs">Zapnúť</button>
                        <button @click="{{ $key }} = false" :class="!{{ $key }} ? 'bg-accent text-accent-foreground' : 'bg-card border border-border text-muted-foreground'" class="rounded-full px-3 py-1 text-xs">Vypnúť</button>
                    </div>
                </div>
            @endforeach
        </div>

        <p class="mt-4 text-xs text-muted-foreground">Notifikácie sú zatiaľ vo vývoji.</p>
    </div>
@endsection
