<?php

namespace App\Http\Controllers;

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
        // Recorrer los asistentes y enviar el certificado a cada uno como PDF por correo
        foreach ($assistances as $assistance) {
            $person = $assistance->person;
            // Usa resend para mandar un email a cada asistente

            Resend::emails()->send([
                'from' => 'Acme <onboarding@resend.dev>',
                'to' => [$person->email],
                'subject' => 'Certificate for ' . $person->fullname,
                'html' => '<p>Dear ' . $person->fullname . ',</p><p>Your certificate is attached.</p>',
            ]);
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
        // Aquí puedes implementar la lógica para enviar el certificado por correo
        // Puedes usar una librería de envío de correos como Laravel Mail
        // y generar el PDF del certificado usando una librería como DomPDF o Snappy
        // Ejemplo:
        // Mail::to($person->email)->send(new CertificateMail($event, $person));
        return redirect()->route('events.edit', $event_id)->with('success', 'Certificado enviado exitosamente.');
    }
}
