<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Agreement;
use App\Models\Career;
use App\Models\Event;
use App\Models\University;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Log;

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
     * @param  \App\Http\Requests\EventRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function store(EventRequest $request)
    {
        // Los datos ya están validados por el EventRequest

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
            'agreement_id' => $request->agreement_id,
            'modality' => $request->modality,
            'location' => $request->location,
            'internationalization_at_home' => $request->internationalization_at_home,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'event_code' => $eventCode,
            'description' => $request->description,
            'career_id' => $request->career_id, // Carrera asociada
            'significant_results' => $request->significant_results,
        ]);

        // Manejar archivos de soporte fotográfico
        if ($request->hasFile('photographic_support')) {
            $this->handlePhotographicSupport($request, $event);
        }

        // Asociar universidades al evento en la tabla pivote
        $event->universities()->attach($request->universities);

        Log::info('Event created successfully by user: ' . auth()->user()->email . ' at ' . now());
        Log::info('Event created: ' . $event->name . ' at ' . now());

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
        // Obtener todas las carrersa
        $careers = Career::all();
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
        // Obtener la carrera asociada al evento
        $careerAssociated = $event->career_id;

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
            'careerAssociated',
            'careers'
        ]));
    }

    /**
     * Actualiza un evento existente en la base de datos después de validar los datos recibidos.
     *
     * @param  \App\Http\Requests\EventRequest  $request
     * @param  string  $id  ID del evento a actualizar
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function update(EventRequest $request, string $id)
    {
        // Los datos ya están validados por el EventRequest
        // Buscar el evento por ID
        $event = Event::findOrFail($id);

        // Manejar archivos de soporte fotográfico ANTES de actualizar otros campos
        if ($request->hasFile('photographic_support')) {
            $this->handlePhotographicSupport($request, $event);
        }

        // Actualizar los campos del evento (sin incluir photographic_support para preservarlo)
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
            'description' => $request->description,
            'career_id' => $request->career_id,
            'significant_results' => $request->significant_results,
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

        Log::info('Event updated successfully by user: ' . auth()->user()->email . ' at ' . now());
        Log::info('Event updated: ' . $event->name . ' at ' . now());

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


        Log::info('Event deleted successfully by user: ' . auth()->user()->email . ' at ' . now());
        Log::info('Event deleted: ' . $event->name . ' at ' . now());

        return redirect()->route('events')->with('success', 'Evento eliminado exitosamente.');
    }

    /**
     * Maneja la subida de archivos de soporte fotográfico
     */
    private function handlePhotographicSupport(Request $request, Event $event): void
    {
        $uploadedFiles = [];
        
        foreach ($request->file('photographic_support') as $file) {
            if ($file->isValid()) {
                // Generar nombre único para el archivo
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Guardar archivo en storage/app/public/events/photographic_support
                $filePath = $file->storeAs(
                    'events/photographic_support/' . $event->id,
                    $fileName,
                    'public'
                );
                
                $uploadedFiles[] = $filePath;
            }
        }
        
        if (!empty($uploadedFiles)) {
            $event->addPhotographicSupportFiles($uploadedFiles);
        }
    }

    /**
     * Descarga un archivo comprimido con todo el soporte fotográfico del evento
     */
    public function downloadPhotographicSupport(string $id)
    {
        $event = Event::findOrFail($id);
        
        if (empty($event->photographic_support)) {
            toast_warning('No hay archivos de soporte fotográfico para descargar.');
            return back();
        }

        $zip = new \ZipArchive();
        $zipFileName = 'soporte_fotografico_evento_' . $event->id . '_' . date('Y-m-d') . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        // Crear directorio temporal si no existe
        if (!file_exists(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }

        if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
            foreach ($event->photographic_support as $filePath) {
                $fullPath = storage_path('app/public/' . $filePath);
                
                if (file_exists($fullPath)) {
                    $zip->addFile($fullPath, basename($filePath));
                }
            }
            
            $zip->close();

            // Descargar y eliminar archivo temporal después
            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        toast_error('No se pudo crear el archivo comprimido.');
        return back();
    }

    /**
     * Elimina un archivo específico del soporte fotográfico
     */
    public function removePhotographicSupportFile(string $eventId, string $fileIndex)
    {
        $event = Event::findOrFail($eventId);
        
        if (!auth()->user()->can('edit events')) {
            toast_error('No tienes permisos para realizar esta acción.');
            return back();
        }
        
        $files = $event->photographic_support ?? [];
        
        if (isset($files[$fileIndex])) {
            $filePath = $files[$fileIndex];
            
            if ($event->removePhotographicSupportFile($filePath)) {
                toast_success('Archivo eliminado exitosamente.');
            } else {
                toast_error('No se pudo eliminar el archivo.');
            }
        } else {
            toast_error('Archivo no encontrado.');
        }
        
        return back();
    }
}
