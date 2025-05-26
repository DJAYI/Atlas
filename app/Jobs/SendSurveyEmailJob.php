<?php

namespace App\Jobs;

use App\Models\Assistance;
use App\Models\Event;
use App\Models\Person;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendSurveyEmailJob implements ShouldQueue
{
    use Queueable;

    protected $person;
    protected $fullname;
    protected $event;
    protected $assistance;
    protected $url;

    /**
     * Crea una nueva instancia del job.
     *
     * @param  Person  $person
     * @param  string  $fullname
     * @return void
     */
    public function __construct(Person $person, string $fullname, Event $event, Assistance $assistance, string $url = null)
    {
        $this->person = $person;
        $this->fullname = $fullname;
        $this->event = $event;
        $this->assistance = $assistance;
        $this->url = $url;
    }

    /**
     * Ejecuta el job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $surveyUrl = $this->url ? '<br><a href="' . $this->url . '">' . $this->url . '</a>' : '';
            // Enviar el correo de encuesta
            Mail::send([], [], function ($message) use ($surveyUrl) {
                $message->from('onboarding@resend.dev', 'Acme')
                    ->to($this->person->email)
                    ->subject('Encuesta para ' . $this->fullname)
                    ->html('Hola ' . $this->fullname . ', por favor responde la encuesta para el evento: ' . $this->event->name . $surveyUrl);
            });
        } catch (\Exception $e) {
            Log::error('Error sending survey: ' . $e->getMessage());
            throw $e;
        }
    }
}
