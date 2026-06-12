@props([
    'url',
    'variant' => 'primary', {{-- primary | danger --}}
])
@php
    $bg = $variant === 'danger' ? '#B23B2E' : '#C4724A';
@endphp
<table role="presentation" class="nf-btn" cellpadding="0" cellspacing="0" style="margin:4px 0;">
    <tr>
        <td align="center" bgcolor="{{ $bg }}" style="border-radius:999px;">
            <a href="{{ $url }}" target="_blank"
               style="display:inline-block; padding:15px 30px; font-family:Arial,Helvetica,sans-serif; font-size:16px; font-weight:700; color:#FFFFFF; text-decoration:none; border-radius:999px;">
                {{ $slot }}
            </a>
        </td>
    </tr>
</table>
