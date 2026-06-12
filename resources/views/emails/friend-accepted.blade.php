<x-emails.layout
    heading="Máš nového priateľa na Nuffy! 🐾"
    eyebrow="tvoja žiadosť o priateľstvo bola prijatá"
    subject="Tvoja žiadosť o priateľstvo bola prijatá"
    preview="Vaša svorka na Nuffy.sk sa rozrástla!">

    <p style="margin:16px 0 0 0; font-family:Arial,Helvetica,sans-serif; font-size:16px; line-height:1.6; color:#44403C;">
        Niekto prijal tvoju žiadosť o priateľstvo na
        <a href="{{ url('/') }}" style="color:#C4724A;">www.nuffy.sk</a>. Vaša svorka sa rozrástla!
    </p>

    <div style="height:20px; line-height:20px;">&nbsp;</div>

    <x-emails.button :url="$actionUrl" variant="primary">🐾&nbsp; Ísť na Nuffy.sk</x-emails.button>

    <x-emails.pref-footer reason="pre žiadosti o priateľstvo" />

</x-emails.layout>
