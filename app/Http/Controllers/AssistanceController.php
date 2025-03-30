<?php

namespace App\Http\Controllers;

use App\Models\Assistance;
use App\Models\Career;
use App\Models\Country;
use App\Models\Event;
use App\Models\Person;
use App\Models\University;
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
        return view('assistance', compact(['universities', 'countries', 'careers']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Assistance $assistance)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assistance $assistance)
    {
        //
    }

    /**
     * Verify if the assistance exists in API or database
     */

    public function verifyAssistance(Request $request)
    {
        // Buscar persona (Asegurar que whereAny existe o usar where con un array)
        $person = Person::where([
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
        ])->first();

        // Buscar evento
        $event = Event::firstWhere('event_code', $request->event_code);

        if (!$event) {
            session()->flash('error', __('assistance.event_not_found'));
            return redirect()->route('assistance', ['locale' => $request->locale]);
        }

        session()->flash('document_type', $request->document_type);
        session()->flash('document_number', $request->document_number);
        session()->flash('event_code', $request->event_code);
        session()->flash('locale', $request->locale);
        session()->flash('success', 'event_found');
        session()->flash('event', $event);

        if (!$person) {
            session()->flash('error', __('assistance.not_found'));
            session()->flash('found', false);
            return redirect()->route('assistance', ['locale' => $request->locale]);
        }

        session()->flash('found', true);
        session()->flash('person', $person);

        return redirect()->route('assistance', ['locale' => $request->locale]);
    }
}
