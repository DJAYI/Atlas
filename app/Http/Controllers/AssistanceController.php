<?php

namespace App\Http\Controllers;

use App\Models\Assistance;
use App\Models\Person;
use Illuminate\Http\Request;

class AssistanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $locale)
    {
        return view('assistance');
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
        $person = Person::whereAny(['document_type', 'document_number'], $request->only(['document_type', 'document_number']))->first();

        if (!$person) {
            return view('assistance', [
                'document_type' => $request->document_type,
                'document_number' => $request->document_number,
                'error' => __('assistance.not_found'),
                'locale' => $request->locale,
                'found' => false,
            ]);
        }

        return view('assistance', [
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'locale' => $request->locale,
            'found' => true,
            'person' => $person,
        ]);
    }
}
