@props([
    'variant' => 'info', {{-- info | warning --}}
    'icon' => 'info',     {{-- info | clock | warning | check --}}
])
@php
    $bg = $variant === 'warning' ? '#FBE9E5' : '#FBEEE5';
    $iconColor = $variant === 'warning' ? '#B23B2E' : '#C4724A';
    $glyphs = ['info' => '&#9432;', 'clock' => '&#128336;', 'warning' => '&#9888;', 'check' => '&#10003;'];
    $glyph = $glyphs[$icon] ?? $glyphs['info'];
@endphp
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:{{ $bg }}; border-radius:14px; margin:6px 0;">
    <tr>
        <td valign="top" style="padding:16px 16px 16px 18px; width:26px;">
            <span style="font-family:Arial,Helvetica,sans-serif; font-size:18px; color:{{ $iconColor }};">{!! $glyph !!}</span>
        </td>
        <td valign="top" style="padding:16px 18px 16px 0; font-family:Arial,Helvetica,sans-serif; font-size:14px; line-height:1.55; color:#5A524C;">
            {{ $slot }}
        </td>
    </tr>
</table>
