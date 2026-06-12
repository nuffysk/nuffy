@props(['reason'])
<p style="margin:20px 0 0 0; font-family:Arial,Helvetica,sans-serif; font-size:13.5px; line-height:1.6; color:#9A8F87; text-align:center;">
    Toto upozornenie dostávaš, pretože máš zapnuté notifikácie {{ $reason }}.
    Chceš ich vypnúť? Uprav si nastavenia v
    <a href="{{ route('settings.notifications') }}" style="color:#9A8F87; text-decoration:underline;">profile</a>.
</p>
