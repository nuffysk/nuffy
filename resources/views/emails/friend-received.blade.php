<x-emails.layout
    heading="Niekto ťa chce spoznať! 🐾"
    eyebrow="žiadosť o priateľstvo na Nuffy.sk"
    subject="Niekto ťa požiadal o priateľstvo na Nuffy.sk"
    preview="Na Nuffy.sk ťa niekto požiadal o priateľstvo.">

    <p style="margin:16px 0 0 0; font-family:Arial,Helvetica,sans-serif; font-size:16px; line-height:1.6; color:#44403C;">
        Na <a href="{{ url('/') }}" style="color:#C4724A;">www.nuffy.sk</a> ťa niekto požiadal o priateľstvo.
        Príď sa pozrieť kto to je!
    </p>

    <div style="height:20px; line-height:20px;">&nbsp;</div>

    <x-emails.button :url="$actionUrl" variant="primary">🐾&nbsp; Ísť na Nuffy.sk</x-emails.button>

    <x-emails.pref-footer reason="pre žiadosti o priateľstvo" :unsubscribeUrl="$unsubscribeUrl ?? null" />

</x-emails.layout>
