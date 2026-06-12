<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmailMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public string $url) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Ňuf! Over si e-mailovú adresu na Nuffy.sk 🐾');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.verify', with: ['url' => $this->url]);
    }
}
