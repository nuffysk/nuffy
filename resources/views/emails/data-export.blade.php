<x-emails.layout
    heading="Tvoje dáta sú pripravené 🐾"
    subject="Tvoje dáta z Nuffy.sk sú pripravené na stiahnutie"
    preview="Exportovaný súbor s tvojimi údajmi je pripravený na stiahnutie.">

    <p style="margin:16px 0 0 0; font-family:Arial,Helvetica,sans-serif; font-size:16px; line-height:1.6; color:#44403C;">
        Prijali sme tvoju žiadosť o stiahnutie osobných údajov z
        <a href="{{ url('/') }}" style="color:#C4724A;">www.nuffy.sk</a>.
        Exportovaný súbor si môžeš stiahnuť kliknutím nižšie.
    </p>

    <x-emails.note variant="info" icon="info">
        Súbor obsahuje všetky osobné údaje viazané na tvoj účet — profil, aktivitu a históriu. Je vo formáte
        <strong>JSON</strong>. Stiahnutý súbor odporúčame uchovávať na bezpečnom mieste.
    </x-emails.note>

    <div style="height:14px; line-height:14px;">&nbsp;</div>

    <x-emails.button :url="$url" variant="primary">⬇&nbsp; Stiahnuť moje dáta</x-emails.button>

    <div style="height:8px; line-height:8px;">&nbsp;</div>

    <x-emails.note variant="info" icon="clock">
        Odkaz je platný <strong>24 hodín</strong>. Po uplynutí si môžeš vyžiadať nový export priamo v nastaveniach účtu.
    </x-emails.note>

    <p style="margin:18px 0 0 0; font-family:Arial,Helvetica,sans-serif; font-size:13.5px; line-height:1.6; color:#9A8F87; text-align:center;">
        Ak si o export údajov nežiadal, daj nám vedieť na
        <a href="mailto:nuffy@nuffy.sk" style="color:#9A8F87;">nuffy@nuffy.sk</a>. Odkaz funguje iba raz.
    </p>

</x-emails.layout>
