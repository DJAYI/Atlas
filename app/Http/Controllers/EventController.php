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


        return view('dashboard.pages.events.edit', compact([
            'event',
            'universities',
            'activities',
            'agreements',
            'universitiesAssociated',
            'agreementAssociated',
            'activityAssociated'
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Buscar el evento por ID
        $event = Event::findOrFail($id);

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
            'universities' => 'required|array',
            'universities.*' => 'exists:universities,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación',
                'errors' => $validator->errors()
            ], 422);
        }

        // Regeneramos el código del evento en base a la nueva fecha de inicio
        $dateCode = date('dm', strtotime($request->start_date));
        $randomCode = mt_rand(100, 999);
        $eventCode = $dateCode . $randomCode;

        // Actualizar los datos del evento
        $event->update([
            'name' => $request->name,
            'responsable' => $request->responsable,
            'activity_id' => $request->activity_id,
            'has_agreement' => $request->has_agreement,
            'agreement_id' => $request->agreement_id,
            'modality' => $request->modality,
            'location' => $request->location,
            'internationalization_at_home' => $request->internationalization_at_home,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'event_code' => $eventCode,
        ]);

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
}
