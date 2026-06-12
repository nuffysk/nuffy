@php
    $isVideo = ($kind ?? 'post') === 'video';
    $title = $isVideo ? 'Nové video na Nuffy.sk! 🏁🐾' : 'Nový príspevok na Nuffy.sk! 🐾';
    $subjectLine = ($isVideo ? 'Nové video' : 'Nový príspevok').' v sekcii '.$section.' na Nuffy.sk';
@endphp
<x-emails.layout
    :heading="$title"
    :eyebrow="'v sekcii '.$section"
    :subject="$subjectLine"
    :preview="$subjectLine">

    <p style="margin:16px 0 0 0; font-family:Arial,Helvetica,sans-serif; font-size:16px; line-height:1.6; color:#44403C;">
        Príď sa pozrieť na <a href="{{ url('/') }}" style="color:#C4724A;">www.nuffy.sk</a>
    </p>

    <div style="height:20px; line-height:20px;">&nbsp;</div>

    <x-emails.button :url="$actionUrl" variant="primary">🐾&nbsp; Ísť na Nuffy.sk</x-emails.button>

    <x-emails.pref-footer :reason="'pre sekciu '.$section" />

</x-emails.layout>
