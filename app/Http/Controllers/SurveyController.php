<?php

namespace App\Http\Controllers;

use App\Jobs\SendSurveyEmailJob;
use App\Models\Event;
use Illuminate\Http\Request;

/**
 * Class SurveyController
 * 
 * Handles the sending of surveys to event participants via email.
 *
 * @package App\Http\Controllers
 */
class SurveyController extends Controller
{
    /**
     * Send surveys to all event attendees (both personal and institutional emails).
     *
     * @param Request $request The HTTP request instance.
     * @param string $id The event ID.
     * @return \Illuminate\Http\RedirectResponse Redirects to the event edit page with a success message.
     */
    public function sendAllSurveys(Request $request, string $id)
    {
        // Enviar encuestas a todos los asistentes tanto a sus correos personales como institucionales

        // Obtener el evento por ID
        $event = Event::findOrFail($id);
        // Obtener los asistentes al evento
        $assistances = $event->assistances()->with('person')->get();

        $batchSize = 10; // Tamaño del paquete
        $chunks = $assistances->chunk($batchSize);

        foreach ($chunks as $chunk) {
            foreach ($chunk as $assistance) {
                $person = $assistance->person;
                $fullname = $person->firstname . ' ' . $person->middlename . ' ' . $person->lastname . ' ' . $person->second_lastname;

                dispatch((new SendSurveyEmailJob($person, $fullname, $event, $assistance))->delay(now()));
            }
            // Opcional: Agregar un pequeño retraso entre paquetes para reducir la carga
            usleep(500000); // 500ms
        }
        return redirect()->route('events.edit', $id)->with('success', 'Encuestas enviadas exitosamente.');
    }

    /**
     * Send a survey to a specific attendee by email.
     *
     * @param Request $request The HTTP request instance.
     * @param string $event_id The event ID.
     * @param string $assistance_id The assistance (attendance) ID.
     * @return \Illuminate\Http\RedirectResponse Redirects to the event edit page with a success message.
     */
    public function sendSurvey(Request $request, string $event_id, string $assistance_id)
    {
        // Enviar encuesta a un asistente específico por correo
        // Obtener el evento por ID
        $event = Event::findOrFail($event_id);
        // Obtener la asistencia por ID
        $assistance = $event->assistances()->with('person')->findOrFail($assistance_id);
        $person = $assistance->person;

        $fullname = $person->firstname . ' ' . $person->middlename . ' ' . $person->lastname . ' ' . $person->second_lastname;

        // fullname = upper case full name
        $fullname = strtoupper($fullname);

        // Usa el Job para enviar el correo
        dispatch((new SendSurveyEmailJob($person, $fullname, $event, $assistance))->delay(now()));

        // Redirigir a la página de edición del evento con un mensaje de éxito
        return redirect()->route('events.edit', $event_id)->with('success', 'Encuesta enviada exitosamente.');
    }
}
