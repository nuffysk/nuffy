<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SectionActivityMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @param  string  $kind     'post' or 'video'
     * @param  string  $section  Human-readable section name, e.g. "SOS linka" or "Závoditko"
     */
    public function __construct(
        public string $kind,
        public string $section,
        public string $actionUrl,
    ) {}

    public function envelope(): Envelope
    {
        $what = $this->kind === 'video' ? 'Nové video' : 'Nový príspevok';

        return new Envelope(subject: $what.' v sekcii '.$this->section.' na Nuffy.sk');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.section-activity', with: [
            'kind' => $this->kind,
            'section' => $this->section,
            'actionUrl' => $this->actionUrl,
        ]);
    }
}
