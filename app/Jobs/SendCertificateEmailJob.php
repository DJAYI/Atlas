<?php

namespace App\Jobs;

use App\Models\Person;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Resend\Laravel\Facades\Resend;

class SendCertificateEmailJob implements ShouldQueue
{
    use Queueable;

    protected $person;
    protected $fullname;

    /**
     * Crea una nueva instancia del job.
     *
     * @param  Person  $person
     * @param  string  $fullname
     * @return void
     */
    public function __construct(Person $person, string $fullname)
    {
        $this->person = $person;
        $this->fullname = $fullname;
    }

    /**
     * Ejecuta el job.
     *
     * @return void
     */
    public function handle()
    {
        Resend::emails()->send([
            'from'    => 'Acme <onboarding@resend.dev>',
            'to'      => [$this->person->email],
            'subject' => 'Certificate for ' . $this->fullname,
            'html'    => '<p>Dear ' . $this->fullname . ',</p><p>Your certificate is attached.</p>',
        ]);
    }
}
