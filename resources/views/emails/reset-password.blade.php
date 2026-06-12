<x-emails.layout
    heading="Zabudnuté heslo? Stáva sa. 🐾"
    subject="Reset hesla na Nuffy.sk"
    preview="Nastav si nové heslo na Nuffy.sk."
    footerIntro="Môžeš si kedykoľvek prečítať naše pravidlá:">

    <p style="margin:16px 0 0 0; font-family:Arial,Helvetica,sans-serif; font-size:16px; line-height:1.6; color:#44403C;">
        Bolo požiadané o resetovanie hesla na <a href="{{ url('/') }}" style="color:#C4724A;">www.nuffy.sk</a>.
        Ak si o zmenu žiadal ty — klikni a nastav si nové.
    </p>

    <div style="height:22px; line-height:22px;">&nbsp;</div>

    <x-emails.button :url="$url" variant="primary">🔒&nbsp; Nastaviť nové heslo</x-emails.button>

    <div style="height:8px; line-height:8px;">&nbsp;</div>

    <x-emails.note variant="info" icon="clock">
        Odkaz je platný <strong>24 hodín</strong>. Potom expiruje a budeš si musieť vyžiadať nový.
    </x-emails.note>

    <p style="margin:18px 0 0 0; font-family:Arial,Helvetica,sans-serif; font-size:13.5px; line-height:1.6; color:#9A8F87; text-align:center;">
        Ak si o reset hesla nežiadal, tento e-mail ignoruj. Odkaz funguje iba raz.
    </p>

</x-emails.layout>
