<x-emails.layout
    heading="Ňuf! Nový člen dorazil! 🐾"
    subject="Over si e-mailovú adresu na Nuffy.sk"
    preview="Zostáva posledný krok — over si svoj účet na Nuffy.sk."
    footerIntro="Registráciou súhlasíš s našimi pravidlami:"
    privacyLabel="Ochrana osobných údajov (GDPR)">

    <p style="margin:16px 0 0 0; font-family:Arial,Helvetica,sans-serif; font-size:16px; line-height:1.6; color:#44403C;">
        Ahoj a vitaj v Nuffy — na mieste, kde každý vie, že deň bez psa je len polovičný deň.
        Zostáva už len jeden krok — overiť tvoju e-mailovú adresu.
    </p>

    <div style="height:22px; line-height:22px;">&nbsp;</div>

    <x-emails.button :url="$url" variant="primary">✓&nbsp; Áno, som to ja — overiť účet</x-emails.button>

    <div style="height:8px; line-height:8px;">&nbsp;</div>

    <x-emails.note variant="info" icon="clock">
        Odkaz platí <strong>24 hodín</strong>. Ak nestihneš, vyžiadaj si nový priamo na stránke.
    </x-emails.note>

    <x-emails.note variant="info" icon="info">
        Tento e-mail si nevyžiadal/a? Pravdepodobne niekto zadal tvoju adresu omylom. Pokojne ho ignoruj —
        žiadny účet nebol vytvorený a tvoje údaje nebudeme ďalej spracúvať.
        Ak máš otázky, napíš nám na <a href="mailto:nuffy@nuffy.sk" style="color:#C4724A;">nuffy@nuffy.sk</a>.
    </x-emails.note>

</x-emails.layout>
