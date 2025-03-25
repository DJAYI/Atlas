<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Agreement;
use App\Models\Event;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        $eventsPaginated = Event::orderBy('start_date', 'desc')->paginate(6);

        return view('dashboard.pages.events.index', compact(['events', 'eventsPaginated']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'activity_id' => 'required|exists:activities,id',
            'has_agreement' => ['required', Rule::in(['si', 'no'])],
            'agreement_id' => 'nullable|exists:agreements,id',
            'modality' => ['required', Rule::in(['presencial', 'virtual', 'en casa'])],
            'location' => ['required', Rule::in(['nacional', 'internacional', 'local'])],
            'internationalization_at_home' => ['nullable', Rule::in(['si', 'no'])],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'universities' => 'required|array', // Debe ser un array de IDs
            'universities.*' => 'exists:universities,id' // Cada ID debe existir en la BD
        ]);

        // Si hay errores de validación, devolverlos
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación',
                'errors' => $validator->errors()
            ], 422);
        }

        // Generar código del evento
        $dateCode = date('dm', strtotime($request->start_date)); // ddmm de la fecha
        $randomCode = mt_rand(100, 999); // Número aleatorio de 3 dígitos
        $eventCode = $dateCode . $randomCode;

        // Crear el evento sin incluir 'universities'
        $event = Event::create([
            'name' => $request->name,
            'responsable' => $request->responsable,
            'activity_id' => $request->activity_id,
            'has_agreement' => $request->has_agreement,
            'modality' => $request->modality,
            'location' => $request->location,
            'internationalization_at_home' => $request->internationalization_at_home,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'event_code' => $eventCode,
        ]);

        // Asociar universidades al evento en la tabla pivote
        $event->universities()->attach($request->universities);
        return redirect()->route('events')->with('success', 'Evento creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Buscar el evento por ID
        $event = Event::findOrFail($id);
        // Obtener todas las universidades
        $universities = University::all();
        // Obtener todas las actividades
        $activities = Activity::all();
        // Obtener todos los acuerdos
        $agreements = Agreement::all();
        // Obtener las universidades asociadas al evento
        $universitiesAssociated = $event->universities()->pluck('id')->toArray();
        // Obtener el acuerdo asociado al evento
        $agreementAssociated = $event->agreement_id;
        // Obtener la actividad asociada al evento
        $activityAssociated = $event->activity_id;

        // Obtener los asistentes al evento
        $assistances = $event->assistances()->with('person')->get();


        return view('dashboard.pages.events.edit', compact([
            'event',
            'universities',
            'activities',
            'agreements',
            'universitiesAssociated',
            'agreementAssociated',
            'activityAssociated',
            'assistances'
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validación de los datos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'activity_id' => 'required|exists:activities,id',
            'has_agreement' => ['required', Rule::in(['si', 'no'])],
            'agreement_id' => 'nullable|exists:agreements,id',
            'modality' => ['required', Rule::in(['presencial', 'virtual', 'en casa'])],
            'location' => ['required', Rule::in(['nacional', 'internacional', 'local'])],
            'internationalization_at_home' => ['nullable', Rule::in(['si', 'no'])],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'universities' => 'required|array', // Debe ser un array de IDs
            'universities.*' => 'exists:universities,id' // Cada ID debe existir en la BD
        ]);

        // Si hay errores de validación, devolverlos
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación',
                'errors' => $validator->errors()
            ], 422);
        }
        // Buscar el evento por ID
        $event = Event::findOrFail($id);

        // Actualizar el evento sin incluir 'universities'
        $event->update([
            'name' => $request->name,
            'responsable' => $request->responsable,
            'activity_id' => $request->activity_id,
            'has_agreement' => $request->has_agreement,
            'modality' => $request->modality,
            'location' => $request->location,
            'internationalization_at_home' => $request->internationalization_at_home,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);
        // Actualizar el acuerdo asociado al evento
        if ($request->has_agreement == 'si') {
            $event->agreement_id = $request->agreement_id;
        } else {
            $event->agreement_id = null;
        }
        $event->save();
        // Actualizar las universidades asociadas al evento
        $event->universities()->sync($request->universities);
        return redirect()->route('events')->with('success', 'Evento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar el evento por ID

        $event = Event::findOrFail($id);
        // Eliminar el evento
        $event->universities()->detach(); // Desasociar universidades
        $event->delete(); // Eliminar el evento

        return redirect()->route('events')->with('success', 'Evento eliminado exitosamente.');
    }

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
            // Aquí puedes implementar la lógica para enviar el certificado por correo
            // Puedes usar una librería de envío de correos como Laravel Mail
            // y generar el PDF del certificado usando una librería como DomPDF o Snappy
            // Ejemplo:
            // Mail::to($person->email)->send(new CertificateMail($event, $person));
        }
        return redirect()->route('events')->with('success', 'Certificados enviados exitosamente.');
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
        return redirect()->route('events')->with('success', 'Certificado enviado exitosamente.');
    }
}
