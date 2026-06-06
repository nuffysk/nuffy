@extends('layouts.app')

@php
    $announcementText = 'OZ FARMA HAPPY: steniatko odobraté z osady. Vek 6 mesiacov. Prepustené z kliniky. Hľadá dočasný domov Kapušany a okolie.';
    $adminEmail = 'nuffy@nuffy.sk';
    $subject = 'Chcem pomôcť — OZ FARMA HAPPY (steniatko, Kapušany)';
    $body = "Ahoj Mária,\n\nrád/rada by som pomohol/pomohla s týmto oznamom:\n\n\"{$announcementText}\"\n\nMôj kontakt: \n\nĎakujem 💛";
    $mailto = 'mailto:'.$adminEmail.'?subject='.rawurlencode($subject).'&body='.rawurlencode($body);
@endphp

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Potrebujú pomoc</h1>
        <p class="text-sm text-muted-foreground">Psíkovia v núdzi 💛</p>

        <div class="mt-4">
            <a href="{{ route('sos.index') }}" class="inline-flex items-center gap-1 text-xs text-muted-foreground transition hover:text-foreground">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                Späť na záchrannú linku
            </a>
        </div>

        <article class="mt-6 rounded-3xl border border-[var(--heart-soft)] p-6 text-foreground shadow-[var(--shadow-soft)]"
                 style="background: linear-gradient(140deg, var(--heart-soft) 0%, var(--cream) 60%, var(--heart-soft) 100%);">
            <p class="font-display text-base leading-relaxed">{{ $announcementText }}</p>
            <p class="mt-2 font-display text-xs text-muted-foreground">Zverejnené 4. mája 2026</p>

            <div class="mt-5 grid aspect-[4/3] w-full place-items-center overflow-hidden rounded-2xl border border-[var(--heart-soft)]" style="background-color: var(--cream);">
                <img src="{{ asset('img/help-otik.jpg') }}" alt="Psík hľadá dočasný domov" class="h-full w-full object-cover" loading="lazy">
            </div>

            <a href="{{ $mailto }}" class="mt-4 flex w-full items-center justify-center rounded-2xl px-4 py-3 font-display text-base font-medium text-accent-foreground transition hover:opacity-90 active:scale-[0.98]" style="background-color: var(--heart-medium);">
                Chcem pomôcť
            </a>
        </article>
    </div>
@endsection
