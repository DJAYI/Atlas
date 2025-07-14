<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuccessfulLogin extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $username,
        public string $email,
        public string $ipAddress,
        public string $userAgent,
        public string $loginTime
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Inicio de Sesión Exitoso - Wonderlust',
            from: config('mail.from.address'),
            replyTo: [config('mail.from.address')],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.successful-login',
            with: [
                'username' => $this->username,
                'email' => $this->email,
                'ipAddress' => $this->ipAddress,
                'userAgent' => $this->userAgent,
                'loginTime' => $this->loginTime,
                'appName' => config('app.name', 'Wonderlust'),
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
        return ['security', 'login', 'notification'];
    }
}
