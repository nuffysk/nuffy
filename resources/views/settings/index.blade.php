@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Nastavenia</h1>

        <div class="mt-4 space-y-3">
            <p class="text-sm text-muted-foreground">
                Prihlásený ako <span class="text-foreground">{{ auth()->user()->email }}</span>
            </p>

            @php
                $categories = [
                    ['route' => 'settings.email',       'label' => 'Zmena emailovej adresy',     'svg' => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>'],
                    ['route' => 'settings.password',    'label' => 'Zmena hesla',                'svg' => '<rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>'],
                    ['route' => 'settings.two-factor', 'label' => 'Dvojfaktorové overenie',      'svg' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>'],
                    ['route' => 'settings.account',     'label' => 'Účet',                       'svg' => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="10" r="3"/><path d="M7 20.7a8 8 0 0 1 10 0"/>'],
                    ['route' => 'settings.notifications','label' => 'Notifikácie',               'svg' => '<path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>'],
                    ['route' => 'settings.blocked',     'label' => 'Blokovaní používatelia',     'svg' => '<circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 14.14 14.14"/>'],
                ];
            @endphp

            <div class="overflow-hidden rounded-2xl border border-border bg-card">
                @foreach ($categories as $i => $c)
                    <a
                        href="{{ route($c['route']) }}"
                        @class([
                            'flex items-center justify-between gap-3 px-4 py-4 text-sm transition hover:bg-muted',
                            'border-b border-border' => $i !== count($categories) - 1,
                        ])
                    >
                        <span class="flex items-center gap-3">
                            <x-heart-icon size="sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $c['svg'] !!}</svg>
                            </x-heart-icon>
                            {{ $c['label'] }}
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                @endforeach
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl px-4 py-3 text-sm font-medium text-muted-foreground transition hover:bg-muted hover:text-foreground">
                    Odhlásiť sa
                </button>
            </form>
        </div>
    </div>
@endsection
