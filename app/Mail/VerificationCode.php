<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationCode extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $code,
        public string $email
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Código de verificación - Atlas',
            from: config('mail.from.address'),
            replyTo: [config('mail.from.address')],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verification-code',
            with: [
                'code' => $this->code,
                'email' => $this->email,
                'appName' => config('app.name', 'Atlas'),
            ]
        );
    }

    /**
     * Get the tags that should be assigned to the message.
     *
     * @return array<int, string>
     */
    public function tags(): array
    {
        return ['verification', '2fa'];
    }
}
