@props([
    'heading',
    'eyebrow' => null,
    'subject' => null,
    'preview' => null,
    'footerIntro' => 'Viac o spracovaní tvojich údajov:',
    'privacyLabel' => 'GDPR',
])
<!DOCTYPE html>
<html lang="sk" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>{{ $subject ?? 'Nuffy.sk' }}</title>
    <!--[if mso]>
    <noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript>
    <![endif]-->
    <style>
        body { margin:0; padding:0; width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; }
        table { border-collapse:collapse; }
        img { border:0; line-height:100%; outline:none; text-decoration:none; -ms-interpolation-mode:bicubic; }
        a { color:#C4724A; }
        @media only screen and (max-width:620px) {
            .nf-container { width:100% !important; }
            .nf-pad { padding-left:22px !important; padding-right:22px !important; }
            .nf-btn a { display:block !important; }
        }
    </style>
</head>
<body style="margin:0; padding:0; background-color:#F3E7DD;">
    <span style="display:none; font-size:1px; color:#F3E7DD; line-height:1px; max-height:0; max-width:0; opacity:0; overflow:hidden;">{{ $preview ?? '' }}</span>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#F3E7DD;">
        <tr>
            <td align="center" style="padding:28px 12px;">
                <table role="presentation" class="nf-container" width="600" cellpadding="0" cellspacing="0" style="width:600px; max-width:600px; background-color:#FFFFFF; border-radius:18px; overflow:hidden; box-shadow:0 8px 30px rgba(120,72,42,0.10);">

                    {{-- Header bar --}}
                    <tr>
                        <td align="center" style="background-color:#C4724A; padding:20px 24px;">
                            <span style="font-family:Georgia,'Times New Roman',serif; font-size:22px; font-weight:700; letter-spacing:0.5px; color:#FFFFFF;">Nuffy.sk</span>
                            <span style="font-family:Arial,Helvetica,sans-serif; font-size:14px; color:rgba(255,255,255,0.82);">&nbsp;&nbsp;·&nbsp;&nbsp;komunita pre psičkárov</span>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td class="nf-pad" style="padding:34px 36px 28px 36px;">
                            <h1 style="margin:0; font-family:Georgia,'Times New Roman',serif; font-size:27px; line-height:1.2; font-weight:700; color:#2C2A28;">{{ $heading }}</h1>

                            @isset($eyebrow)
                                <p style="margin:8px 0 0 0; font-family:Arial,Helvetica,sans-serif; font-size:15px; font-weight:600; color:#C4724A;">{{ $eyebrow }}</p>
                            @endisset

                            {{ $slot }}
                        </td>
                    </tr>

                    {{-- Footer legal links --}}
                    <tr>
                        <td class="nf-pad" style="padding:0 36px 26px 36px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr><td style="border-top:1px solid #ECE3DB; font-size:0; line-height:0;">&nbsp;</td></tr>
                            </table>
                            <p style="margin:18px 0 0 0; font-family:Arial,Helvetica,sans-serif; font-size:13px; color:#8A817C;">
                                {{ $footerIntro ?? 'Viac o spracovaní tvojich údajov:' }}
                            </p>
                            <p style="margin:8px 0 0 0; font-family:Arial,Helvetica,sans-serif; font-size:13px; color:#C4724A;">
                                <a href="{{ route('terms') }}" style="color:#C4724A; text-decoration:none;">&#128196;&nbsp;Obchodné podmienky</a>
                                &nbsp;&nbsp;·&nbsp;&nbsp;
                                <a href="{{ route('privacy') }}" style="color:#C4724A; text-decoration:none;">&#128274;&nbsp;{{ $privacyLabel ?? 'GDPR' }}</a>
                                &nbsp;&nbsp;·&nbsp;&nbsp;
                                <a href="mailto:nuffy@nuffy.sk" style="color:#C4724A; text-decoration:none;">&#9993;&nbsp;nuffy@nuffy.sk</a>
                            </p>
                        </td>
                    </tr>

                    {{-- Bottom bar --}}
                    <tr>
                        <td style="background-color:#F7ECE4; padding:18px 36px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="left" style="font-family:Arial,Helvetica,sans-serif; font-size:13px; color:#9A8F87;">S láskou, tím Nuffy&nbsp; ·&nbsp; Cari s.r.o.</td>
                                    <td align="right" style="font-family:Arial,Helvetica,sans-serif; font-size:13px;"><a href="mailto:nuffy@nuffy.sk" style="color:#C4724A; text-decoration:none;">nuffy@nuffy.sk</a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
