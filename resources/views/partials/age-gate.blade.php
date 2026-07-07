{{-- Age gate notice — mirrors paw AgeGate overlay. Shown after underage sign-out. --}}
@if (session('underage'))
    <div
        x-data="{ open: true }"
        x-show="open"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-background/95 p-6"
    >
        <div class="max-w-sm space-y-4 text-center">
            <h1 class="font-display text-3xl">Mrzí nás to<span class="text-accent">.</span></h1>
            <p class="text-sm text-muted-foreground">
                Aplikáciu Ňuffy môžu používať iba osoby od 18 rokov.
            </p>
            <button @click="open = false; window.location.href = '/'" class="inline-flex w-full items-center justify-center rounded-2xl bg-primary px-6 py-3 text-base font-medium text-primary-foreground shadow-[var(--shadow-heart)] transition hover:opacity-95">
                Rozumiem
            </button>
        </div>
    </div>
@endif
