<?php

namespace App\Http\Controllers;

use App\Exports\AssistancesExport;
use App\Http\Requests\StoreAssistanceRequest;
use App\Http\Requests\ValidateAssistaceRequest;
use App\Models\Assistance;
use App\Models\Career;
use App\Models\Country;
use App\Models\Event;
use App\Models\Mobility;
use App\Models\Person;
use App\Models\University;
use App\Rules\Recaptcha;
use App\Services\TurnstileServiceCF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class AssistanceController
 *
 * Handles operations related to event assistance registration, verification, and management.
 *
 * Methods:
 * - index(string $locale): Displays the assistance registration form with required data.
 * - store(Request $request): Handles the registration of a new assistance, including validation, person creation/update, and file upload.
 * - verifyAssistance(Request $request): Verifies if a person is registered for an event and checks event validity.
 *
 * This controller manages the workflow for registering and verifying assistance to events, including handling identity documents and session data.
 */
class AssistanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $locale)
    {
        $universities = University::all();
        $countries = Country::all();
        $careers = Career::all();
        $mobilities = Mobility::all();
        return view('assistance', compact(['universities', 'countries', 'careers', 'mobilities']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssistanceRequest $request)
    {
        // Validation is now handled by StoreAssistanceRequest
        // The Turnstile validation is also included in the form request

        // Retrieve data from session
        $documentType = session('document_type');
        $documentNumber = session('document_number');
        $eventCode = session('event_code');

        if (!$documentType || !$documentNumber) {
            return redirect()->route('assistance', ['locale' => $request->locale])
                ->with('error', __('assistance.missing_document_data'));
        }

        $requiredFields = [
            'first_name',
            'last_name',
            'personal_email',
            'phone_number',
            'country_of_origin',
            'origin_university',
            'academic_program',
            'biological_sex',
            'birth_date',
            'type'
        ];

        foreach ($requiredFields as $field) {
            if (!$request->filled($field)) {
                return redirect()->route('assistance', ['locale' => $request->locale])
                    ->with('error', __('assistance.missing_required_field', ['field' => $field]));
            }
        }

        if (!filter_var($request->input('personal_email'), FILTER_VALIDATE_EMAIL)) {
            return redirect()->route('assistance', ['locale' => $request->locale])
                ->with('error', __('assistance.invalid_email'));
        }

        if ($request->filled('institutional_email') && !filter_var($request->input('institutional_email'), FILTER_VALIDATE_EMAIL)) {
            return redirect()->route('assistance', ['locale' => $request->locale])
                ->with('error', __('assistance.invalid_institutional_email'));
        }

        if (!is_numeric($request->input('phone_number'))) {
            return redirect()->route('assistance', ['locale' => $request->locale])
                ->with('error', __('assistance.invalid_phone_number'));
        }

        if (!strtotime($request->input('birth_date'))) {
            return redirect()->route('assistance', ['locale' => $request->locale])
                ->with('error', __('assistance.invalid_birth_date'));
        }

        $person = Person::updateOrCreate(
            [
                'document_type' => $documentType,
                'document_number' => $documentNumber,
            ],
            [
                'firstname' => $request->input('first_name'),
                'middlename' => $request->input('middle_name'),
                'lastname' => $request->input('last_name'),
                'second_lastname' => $request->input('second_last_name'),
                'email' => $request->input('personal_email'),
                'institutional_email' => $request->input('institutional_email'),
                'phone' => $request->input('phone_number'),
                'country_id' => $request->input('country_of_origin'),
                'university_id' => $request->input('origin_university'),
                'career_id' => $request->input('academic_program'),
                'genre' => $request->input('biological_sex'),
                'birth_date' => $request->input('birth_date'),
                'minority' => $request->input('minority_group'),
                'type' => $request->input('type'),
            ]
        );

        // Store the person in the session
        session()->put('person', $person);

        // Find the event and load universities relationship
        $event = Event::with('universities')->firstWhere('event_code', $eventCode);

        if (!$event) {
            return redirect()->route('assistance', ['locale' => $request->locale])
                ->with('error', __('assistance.event_not_found'));
        }

        // Validar que el asistente no haya sido registrado previamente
        $existingPerson = Assistance::where('event_id', $event->id)
            ->where('person_id', $person->id)
            ->first();

        /**
         * Handle existing assistance record
         */
        if ($existingPerson) {
            if ($request->hasFile('identity_document')) {
                // Delete the previous file if it exists
                if ($existingPerson->identity_document_file) {
                    Storage::disk('public')->delete($existingPerson->identity_document_file);
                }

                // Validate file size (maximum 2MB)
                if ($request->file('identity_document')->getSize() > 2 * 1024 * 1024) {
                    return redirect()->route('assistance', ['locale' => $request->locale])
                        ->with('error', __('assistance.file_size_exceeded'));
                }

                // Upload the new file
                $documentFilePath = $request->file('identity_document')->store('identity_documents', 'public');

                // Update the record
                $existingPerson->update([
                    'identity_document_file' => $documentFilePath,
                ]);

                return redirect()->route('assistance', ['locale' => $request->locale])
                    ->with('success', __('assistance.identity_document_file_updated_successfully'));
            } else {
                return redirect()->route('assistance', ['locale' => $request->locale])
                    ->with('error', __('assistance.already_registered'));
            }
        }



        $documentFilePath = null;
        if ($request->hasFile('identity_document')) {
            $documentFilePath = $request->file('identity_document')->store('identity_documents', 'public');
        }

        // Create the assistance record with identity_document_file
        $assistance = Assistance::create([
            'event_id' => $event->id,
            'person_id' => $person->id,
            'university_destiny_id' => $request->input('destination_university'),
            'mobility_id' => $request->input('mobility_id'),
            'identity_document_file' => $documentFilePath,
        ]);

        return redirect()->route('assistance', ['locale' => $request->locale])
            ->with('success', __('Asistencia registrada correctamente'));
    }


    public function verifyAssistance(\App\Http\Requests\ValidateAssistaceRequest $request)
    {
        // The validation is now handled by the ValidateAssistaceRequest class
        // The Turnstile validation is also included in the form request

        // Buscar persona
        $person = Person::where([
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
        ])->first();

        // Buscar evento (ya validado que existe por ValidateAssistaceRequest) y cargar relaciones
        $event = Event::with('universities')->firstWhere('event_code', $request->event_code);

        // Verificar si el evento ya ha pasado
        if (Carbon::parse($event->end_date)->isPast()) {
            return redirect()->route('assistance', ['locale' => $request->locale])
                ->with('error', __('assistance.event_expired'));
        }

        if (Carbon::parse($event->start_date)->isFuture()) {
            return redirect()->route('assistance', ['locale' => $request->locale])
                ->with('error', __('assistance.event_not_started'));
        }

        // Almacenar información necesaria en la sesión para el formulario
        session()->put('document_type', $request->document_type);
        session()->put('document_number', $request->document_number);
        session()->put('event_code', $request->event_code);

        // Verificar si la persona existe
        if (!$person) {
            return redirect()->route('assistance', ['locale' => $request->locale])
                ->with([
                    'error' => __('Asistencias previas no registradas'),
                    'found' => false,
                    'event' => $event,
                ]);
        }

        // Recuperar el archivo de documento de identidad si existe
        $assistance = Assistance::where([
            'person_id' => $person->id,
            'event_id' => $event->id,
        ])->first();

        // Preparar los datos para pasar al formulario
        $data = [
            'found' => true,
            'person' => $person,
            'success' => 'Evento encontrado correctamente',
            'event' => $event,
        ];

        if ($assistance && $assistance->identity_document_file) {
            $data['identity_document_file'] = $assistance->identity_document_file;
        }

        return redirect()->route('assistance', ['locale' => $request->locale])
            ->with($data);
    }

    public function exportAssistances(Request $request, $eventId)
    {
        // Validar el evento
        $event = Event::findOrFail($eventId);

        // Obtener las asistencias del evento
        $assistances = Assistance::where('event_id', $event->id)->with('person')->get();

        return Excel::download(new AssistancesExport($assistances), 'assistances_' . $event->event_code . '.xlsx');
    }

    public function exportIdentityDocumentsZip(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        $assistances = Assistance::where('event_id', $event->id)
            ->whereNotNull('identity_document_file')
            ->with('person')
            ->get();

        if ($assistances->isEmpty()) {
            return redirect()->back()
                ->with('error', __('assistance.no_identity_documents_found'));
        }

        $zipFileName = 'identity_documents_' . $event->event_code . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return redirect()->back()
                ->with('error', __('assistance.zip_creation_failed'));
        }

        foreach ($assistances as $assistance) {
            $filePath = storage_path('app/public/' . $assistance->identity_document_file);
            if (file_exists($filePath)) {
                $person = $assistance->person;
                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                $filename = $person->firstname . '_' . $person->lastname . '_' . $person->document_number . '.' . $extension;
                $filename = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $filename);
                $zip->addFile($filePath, $filename);
            }
        }

        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
