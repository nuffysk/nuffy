<x-emails.layout
    heading="Žiadosť o vymazanie účtu 🐾"
    subject="Potvrď vymazanie účtu na Nuffy.sk"
    preview="Potvrď, že chceš natrvalo vymazať svoj účet na Nuffy.sk.">

    <p style="margin:16px 0 0 0; font-family:Arial,Helvetica,sans-serif; font-size:16px; line-height:1.6; color:#44403C;">
        Prijali sme žiadosť o vymazanie tvojho účtu na
        <a href="{{ url('/') }}" style="color:#C4724A;">www.nuffy.sk</a>.
        Ak si o vymazanie žiadal ty, potvrď to kliknutím nižšie.
    </p>

    <x-emails.note variant="warning" icon="warning">
        Po potvrdení budú <strong>natrvalo vymazané</strong> všetky tvoje údaje, príspevky a história aktivity.
        Tento krok je nevratný.
    </x-emails.note>

    <div style="height:14px; line-height:14px;">&nbsp;</div>

    <x-emails.button :url="$url" variant="danger">🗑&nbsp; Áno, vymazať môj účet</x-emails.button>

    <div style="height:8px; line-height:8px;">&nbsp;</div>

    <x-emails.note variant="info" icon="clock">
        Odkaz je platný <strong>24 hodín</strong>. Potom expiruje a žiadosť bude automaticky zrušená.
    </x-emails.note>

    <p style="margin:18px 0 0 0; font-family:Arial,Helvetica,sans-serif; font-size:13.5px; line-height:1.6; color:#9A8F87; text-align:center;">
        Ak si o vymazanie účtu nežiadal, tento e-mail ignoruj — nič sa nestane. Odkaz funguje iba raz.
    </p>

</x-emails.layout>
