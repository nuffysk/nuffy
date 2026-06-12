<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public string $url) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Zabudnuté heslo? Resetuj si ho na Nuffy.sk');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.reset-password', with: ['url' => $this->url]);
    }
}
