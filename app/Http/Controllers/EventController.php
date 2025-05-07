<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Agreement;
use App\Models\Event;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Class EventController
 * 
 * Controlador para la gestión de eventos en el sistema. Permite listar, crear, editar, actualizar y eliminar eventos,
 * así como asociar universidades, actividades y acuerdos a los eventos.
 * 
 * Métodos principales:
 * - index(): Muestra la lista de eventos y la paginación.
 * - store(Request $request): Valida y almacena un nuevo evento.
 * - edit(string $id): Muestra el formulario de edición de un evento.
 * - update(Request $request, string $id): Valida y actualiza un evento existente.
 * - destroy(string $id): Elimina un evento y desasocia sus universidades.
 * 
 * @package App\Http\Controllers
 */
class EventController extends Controller
{
    /**
     * Muestra una lista de los eventos registrados.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $events = Event::all();
        $eventsPaginated = Event::orderBy('start_date', 'desc')->paginate(6);

        return view('dashboard.pages.events.index', compact(['events', 'eventsPaginated']));
    }

    /**
     * Almacena un nuevo evento en la base de datos después de validar los datos recibidos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
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
     * Muestra el formulario para editar un evento específico.
     *
     * @param  string  $id  ID del evento a editar
     * @return \Illuminate\View\View
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

        $assistancesPaginated = $event->assistances()->with('person')->paginate(6);


        return view('dashboard.pages.events.edit', compact([
            'event',
            'universities',
            'activities',
            'agreements',
            'universitiesAssociated',
            'agreementAssociated',
            'activityAssociated',
            'assistances',
            'assistancesPaginated',
        ]));
    }

    /**
     * Actualiza un evento existente en la base de datos después de validar los datos recibidos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id  ID del evento a actualizar
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
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
     * Elimina un evento específico de la base de datos y desasocia sus universidades.
     *
     * @param  string  $id  ID del evento a eliminar
     * @return \Illuminate\Http\RedirectResponse
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
