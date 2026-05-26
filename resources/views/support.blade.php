@extends('layouts.app')

@section('content')
    <div class="pt-6">
        <h1 class="font-display text-3xl">Podpora</h1>
        <p class="mt-1 text-sm text-muted-foreground">Ozvi sa — sme tu pre teba.</p>
        <div class="mt-4 rounded-2xl border border-border bg-card p-5">
            <p class="text-sm leading-relaxed">
                Našiel si chybu alebo máš nápad? Napíš nám a my sa ozveme.
            </p>
            <a href="mailto:nuffysk@gmail.com?subject=Nuffy%20support" class="mt-4 inline-flex items-center gap-2 rounded-full bg-accent px-4 py-2 text-sm font-medium text-accent-foreground">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                nuffysk@gmail.com
            </a>
        </div>
    </div>
@endsection
