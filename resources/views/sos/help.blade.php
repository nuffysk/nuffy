@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <a href="{{ route('sos.index') }}" class="inline-flex items-center gap-1 rounded-full border border-border bg-card px-3 py-1.5 text-sm hover:bg-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Späť
        </a>

        <article class="mt-4 overflow-hidden rounded-3xl border border-border bg-card">
            <div class="aspect-[16/9] bg-muted">
                <img src="{{ asset('img/help-otik.jpg') }}" alt="" class="h-full w-full object-cover">
            </div>
            <div class="p-5">
                <p class="text-xs uppercase tracking-wider text-muted-foreground">Potrebujú pomoc</p>
                <h1 class="mt-2 font-display text-2xl">Pomôž psíkom v núdzi</h1>
                <p class="mt-3 text-sm leading-relaxed">
                    V útulkoch a u dobrovoľníkov sú psy, ktoré potrebujú dočasku, jedlo, lieky alebo trvalý domov.
                    Ak chceš pomôcť (finančne, vecne, alebo ako dočaska), napíš nám.
                </p>
                <a href="mailto:nuffysk@gmail.com?subject=Chcem%20pomocť&body=Ahoj,%0A%0AChcel/a%20by%20som%20pomôcť..." class="mt-5 inline-flex items-center gap-2 rounded-full bg-accent px-4 py-2 text-sm font-medium text-accent-foreground">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.29 1.51 4.04 3 5.5l7 7Z"/></svg>
                    Chcem pomôcť
                </a>
            </div>
        </article>
    </div>
@endsection
