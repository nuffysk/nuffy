<?php

namespace App\Console\Commands;

use App\Mail\SectionActivityMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MailTest extends Command
{
    protected $signature = 'nuffy:mail-test {email : Kam poslať testovací e-mail}';

    protected $description = 'Pošle testovací Nuffy e-mail (overenie SMTP nastavenia)';

    public function handle(): int
    {
        $email = $this->argument('email');
        $mailer = config('mail.default');

        $this->info("Posielam testovací e-mail na {$email} cez mailer [{$mailer}]...");

        // Odoslať synchrónne, aby sme hneď videli prípadnú SMTP chybu
        // (mailable je ShouldQueue, ->sendNow obíde frontu).
        try {
            Mail::to($email)->sendNow(
                new SectionActivityMail('post', 'Test', route('home'))
            );
        } catch (\Throwable $e) {
            $this->error('Odoslanie zlyhalo: '.$e->getMessage());

            return self::FAILURE;
        }

        $this->info($mailer === 'log'
            ? 'Hotovo — mailer je "log", pozri storage/logs/laravel.log.'
            : 'Hotovo — skontroluj doručenú poštu (aj spam).');

        return self::SUCCESS;
    }
}
