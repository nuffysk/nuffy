{{-- Cookie consent banner — mirrors paw CookieBanner.tsx (localStorage: nuffy-cookie-consent) --}}
<div
    x-data="{
        visible: false,
        init() { this.visible = ! window.localStorage.getItem('nuffy-cookie-consent'); },
        decide(value) {
            try { window.localStorage.setItem('nuffy-cookie-consent', value); } catch (e) {}
            this.visible = false;
        }
    }"
    x-show="visible"
    role="dialog"
    aria-live="polite"
    aria-label="Cookies"
    class="fixed inset-x-0 bottom-0 z-[60] px-4 pb-4 sm:px-6 sm:pb-6"
    style="display:none;"
>
    <div class="mx-auto max-w-md rounded-2xl border border-border bg-card p-5 shadow-2xl">
        <h2 class="font-display text-lg font-semibold">Cookies</h2>
        <p class="mt-2 text-sm text-muted-foreground">
            Pre bezchybnú funkčnosť tejto stránky používame základné cookies súbory.
            Taktiež používame analytické cookies, ale bez spracovania akýchkoľvek osobných
            údajov. Súhlasom akceptujete ich používanie.
        </p>
        <a href="{{ route('privacy') }}" class="mt-2 inline-block text-sm font-medium text-accent underline underline-offset-2">
            Viac informácií
        </a>
        <div class="mt-4 flex items-center gap-2">
            <button type="button" @click="decide('accepted')" class="flex-1 rounded-full bg-accent px-4 py-2 text-sm font-semibold text-accent-foreground transition hover:bg-accent/90">
                Súhlasím
            </button>
            <button type="button" @click="decide('declined')" class="flex-1 rounded-full border border-border px-4 py-2 text-sm font-semibold text-foreground transition hover:bg-muted">
                Nesúhlasím
            </button>
        </div>
    </div>
</div>
