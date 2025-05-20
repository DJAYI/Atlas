<?php

namespace App\Jobs;

use App\Models\Assistance;
use App\Models\Event;
use App\Models\Person;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;
use Resend\Laravel\Facades\Resend;

class SendCertificateEmailJob implements ShouldQueue
{
    use Queueable;

    protected $person;
    protected $fullname;
    protected $event;
    protected $assistance;

    /**
     * Crea una nueva instancia del job.
     *
     * @param  Person  $person
     * @param  string  $fullname
     * @return void
     */
    public function __construct(Person $person, string $fullname, Event $event, Assistance $assistance)
    {
        $this->person = $person;
        $this->fullname = $fullname;
        $this->event = $event;
        $this->assistance = $assistance;
    }

    /**
     * Ejecuta el job.
     *
     * @return void
     */
    public function handle()
    {
        $directory = storage_path('app/certificates/');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Limpiar y validar las cadenas
        $fullname = preg_replace('/[^\p{L}\p{N}\s\-]/u', '', $this->fullname);
        $eventName = preg_replace('/[^\p{L}\p{N}\s\-]/u', '', $this->event->name);
        $filename = preg_replace('/[^A-Za-z0-9\- ]/', '', $fullname . '-' . $eventName) . '.pdf';
        $path = $directory . $filename;

        try {
            // Generar el PDF
            $certificatePDF = Pdf::loadView('utils.certificates.assistance-certificate', [
                'fullname' => $fullname,
                'person'   => $this->person,
                'event'    => $this->event,
                'assistance' => $this->assistance,
            ]);

            $certificatePDF->save($path);

            // Enviar el correo
            Mail::send([], [], function ($message) use ($fullname, $eventName, $path, $filename) {
                $message->from('onboarding@resend.dev', 'Acme')
                    ->to($this->person->email)
                    ->subject('Certificate for ' . $fullname)
                    ->html('Hello ' . $fullname . ', here is your certificate for the event: ' . $eventName) // Pass plain string here
                    ->attach($path, [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]);
            });
        } catch (\Exception $e) {
            Log::error('Error sending certificate: ' . $e->getMessage());
            throw $e;
        } finally {
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
}
