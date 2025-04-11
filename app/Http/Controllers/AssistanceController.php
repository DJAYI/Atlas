<?php

namespace App\Http\Controllers;

use App\Models\Assistance;
use App\Models\Career;
use App\Models\Country;
use App\Models\Event;
use App\Models\Mobility;
use App\Models\Person;
use App\Models\University;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        // Validate the request

        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'personal_email' => 'required|email|max:255',
                'institutional_email' => 'nullable|email|max:255',
                'phone_number' => 'nullable|string|max:20',
                'country_of_origin' => 'required|exists:countries,id',
                'origin_university' => 'required|exists:universities,id',
                'academic_program' => 'required|exists:careers,id',
                'biological_sex' => 'required|string|max:10',
                'birth_date' => 'required|date',
                'minority_group' => 'nullable|string|max:255',
                'type' => 'required|string|max:50',
                'destination_university' => 'required|exists:universities,id',
                'mobility_id' => 'required|exists:mobilities,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('errors', $e->validator->errors());
            return redirect()->back()->withInput();
        }

        // Retrieve data from session
        $documentType = session('document_type');
        $documentNumber = session('document_number');
        $eventCode = session('event_code');


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

        // Find the event
        $event = Event::firstWhere('event_code', $eventCode);

        if (!$event) {
            session()->flash('error', __('assistance.event_not_found'));
            return redirect()->route('assistance', ['locale' => $request->locale]);
        }

        // Validar que el asistente no haya sido registrado previamente
        $existingAssistance = Assistance::where('event_id', $event->id)
            ->where('person_id', $person->id)
            ->first();
        if ($existingAssistance) {
            session()->flash('error', __('assistance.already_registered'));
            return redirect()->route('assistance', ['locale' => $request->locale]);
        }


        // Create the assistance record
        $assistance = Assistance::create([
            'event_id' => $event->id,
            'person_id' => $person->id,
            'university_destiny_id' => $request->input('destination_university'),
            'mobility_id' => $request->input('mobility_id'),
            'identity_document_file' => null

        ]);

        session()->flash('success', __('assistance.saved_successfully'));
        return redirect()->route('assistance', ['locale' => $request->locale]);
    }


    public function verifyAssistance(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'document_type' => 'required|string|max:255',
            'document_number' => 'required|string|max:255',
            'event_code' => 'required|string|max:255',
        ]);

        // Buscar persona (Asegurar que whereAny existe o usar where con un array)
        $person = Person::where([
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
        ])->first();

        // Buscar evento
        $event = Event::firstWhere('event_code', $request->event_code);

        // Verificar si el evento existe
        if (!$event) {
            session()->flash('error', __('assistance.event_not_found'));
            return redirect()->route('assistance', ['locale' => $request->locale]);
        }

        // Verificar si el evento ya ha pasado
        if (Carbon::parse($event->end_date)->isPast()) {
            session()->flash('error', __('assistance.event_expired'));
            return redirect()->route('assistance', ['locale' => $request->locale]);
        }

        if (Carbon::parse($event->start_date)->isFuture()) {
            session()->flash('error', __('assistance.event_not_started'));
            return redirect()->route('assistance', ['locale' => $request->locale]);
        }

        session()->put('document_type', $request->document_type);
        session()->put('document_number', $request->document_number);
        session()->put('event_code', $request->event_code);
        session()->flash('locale', $request->locale);
        session()->flash('success', 'event_found');
        session()->flash('event', $event);

        // Verificar si la persona existe
        if (!$person) {
            session()->flash('error', __('assistance.not_found'));
            session()->flash('found', false);
            return redirect()->route('assistance', ['locale' => $request->locale]);
        }

        // Recuperar el archivo de documento de identidad si existe
        $assistance = Assistance::where([
            'person_id' => $person->id,
            'event_id' => $event->id,
        ])->first();

        if ($assistance && $assistance->identity_document_file) {
            session()->flash('identity_document_file', $assistance->identity_document_file);
        }

        session()->flash('found', true);
        session()->flash('person', $person);

        return redirect()->route('assistance', ['locale' => $request->locale]);
    }
}
