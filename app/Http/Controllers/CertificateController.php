<?php

namespace App\Http\Controllers;

use App\Jobs\SendCertificateEmailJob;
use App\Models\Event;
use Illuminate\Http\Request;
use Resend\Laravel\Facades\Resend;

class CertificateController extends Controller
{
    public function sendAllCertificates(Request $request, string $id)
    {
        // Enviar certificados a todos los asistentes tanto a sus correos personales como institucionales

        // Obtener el evento por ID
        $event = Event::findOrFail($id);
        // Obtener los asistentes al evento
        $assistances = $event->assistances()->with('person')->get();

        foreach ($assistances as $assistance) {
            $person = $assistance->person;
            $fullname = $person->firstname . ' ' . $person->lastname;

            dispatch((new SendCertificateEmailJob($person, $fullname))->delay(now()));
        }
        return redirect()->route('events.edit', $id)->with('success', 'Certificados enviados exitosamente.');
    }

    public function sendCertificate(Request $request, string $event_id, string $assistance_id)
    {
        // Enviar certificado a un asistente específico por correo
        // Obtener el evento por ID
        $event = Event::findOrFail($event_id);
        // Obtener la asistencia por ID
        $assistance = $event->assistances()->with('person')->findOrFail($assistance_id);
        $person = $assistance->person;


        $fullname = $person->firstname . ' ' . $person->lastname;

        // Usa el Job para enviar el correo
        dispatch((new SendCertificateEmailJob($person, $fullname))->delay(now()));


        // Redirigir a la página de edición del evento con un mensaje de éxito

        return redirect()->route('events.edit', $event_id)->with('success', 'Certificado enviado exitosamente.');
    }
}
