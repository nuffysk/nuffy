{{-- Add-to-home-screen prompt — mirrors paw InstallPrompt.tsx --}}
<div
    x-data="nuffyInstallPrompt()"
    x-init="init()"
    x-show="show"
    class="fixed inset-x-0 bottom-24 z-[60] mx-auto max-w-md px-4"
    style="display:none;"
>
    <div class="flex items-start gap-3 rounded-2xl border border-border bg-card p-4 shadow-2xl">
        <img src="{{ asset('icon-192.png') }}" alt="" class="h-10 w-10 rounded-xl">
        <div class="flex-1">
            <p class="font-display text-base">Pridaj Ňuffy na plochu</p>
            <template x-if="isIOS">
                <p class="mt-1 text-xs text-muted-foreground">
                    V Safari klikni na <span class="font-medium">Zdieľať</span> a vyber
                    <span class="font-medium">„Pridať na plochu"</span>.
                </p>
            </template>
            <template x-if="! isIOS">
                <p class="mt-1 text-xs text-muted-foreground">
                    Otvor appku z plochy ako natívnu aplikáciu — bez prehliadača.
                </p>
            </template>
            <template x-if="! isIOS && deferred">
                <button @click="install()" class="mt-3 inline-flex items-center gap-2 rounded-full bg-primary px-4 py-2 text-xs font-medium text-primary-foreground">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                    Inštalovať
                </button>
            </template>
        </div>
        <button @click="dismiss()" aria-label="Zavrieť" class="rounded-full p-1 text-muted-foreground hover:bg-muted">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
    </div>
</div>

<script>
    function nuffyInstallPrompt() {
        const VISITS_KEY = 'nuffy_visits';
        const DISMISSED_KEY = 'nuffy_install_dismissed';
        const MIN_VISITS = 3;
        return {
            deferred: null,
            show: false,
            isIOS: false,
            init() {
                if (typeof window === 'undefined') return;
                const inIframe = window.self !== window.top;
                const standalone =
                    (window.matchMedia && window.matchMedia('(display-mode: standalone)').matches) ||
                    window.navigator.standalone === true;
                if (inIframe || standalone) return;
                if (localStorage.getItem(DISMISSED_KEY) === '1') return;

                if (!sessionStorage.getItem('nuffy_visit_counted')) {
                    const n = Number(localStorage.getItem(VISITS_KEY) ?? '0') + 1;
                    localStorage.setItem(VISITS_KEY, String(n));
                    sessionStorage.setItem('nuffy_visit_counted', '1');
                }
                const visits = Number(localStorage.getItem(VISITS_KEY) ?? '0');

                const ua = window.navigator.userAgent;
                const ios = /iPad|iPhone|iPod/.test(ua) && !/CriOS|FxiOS/.test(ua);
                this.isIOS = ios;

                window.addEventListener('beforeinstallprompt', (e) => {
                    e.preventDefault();
                    this.deferred = e;
                    if (visits >= MIN_VISITS) this.show = true;
                });

                if (ios && visits >= MIN_VISITS) this.show = true;
            },
            dismiss() {
                localStorage.setItem(DISMISSED_KEY, '1');
                this.show = false;
            },
            async install() {
                if (!this.deferred) return;
                await this.deferred.prompt();
                await this.deferred.userChoice;
                this.deferred = null;
                this.dismiss();
            },
        };
    }
</script>
