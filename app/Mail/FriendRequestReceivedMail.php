<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FriendRequestReceivedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public string $actionUrl, public ?string $unsubscribeUrl = null) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Niekto ťa chce spoznať na Nuffy! 🐾');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.friend-received', with: [
            'actionUrl' => $this->actionUrl,
            'unsubscribeUrl' => $this->unsubscribeUrl,
        ]);
    }
}
