@props(['reason', 'unsubscribeUrl' => null])
<p style="margin:20px 0 0 0; font-family:Arial,Helvetica,sans-serif; font-size:13.5px; line-height:1.6; color:#9A8F87; text-align:center;">
    Toto upozornenie dostávaš, pretože máš zapnuté notifikácie {{ $reason }}.
    @if ($unsubscribeUrl)
        <a href="{{ $unsubscribeUrl }}" style="color:#9A8F87; text-decoration:underline;">Odhlásiť sa z týchto e-mailov</a>
        alebo si uprav nastavenia v
        <a href="{{ route('settings.notifications') }}" style="color:#9A8F87; text-decoration:underline;">profile</a>.
    @else
        Chceš ich vypnúť? Uprav si nastavenia v
        <a href="{{ route('settings.notifications') }}" style="color:#9A8F87; text-decoration:underline;">profile</a>.
    @endif
</p>
