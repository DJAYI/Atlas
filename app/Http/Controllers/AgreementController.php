<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use Illuminate\Http\Request;

class AgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agreements = Agreement::all();
        $agreementsPaginated = Agreement::orderBy('start_date', 'desc')->paginate(6);

        return view('dashboard.pages.agreements.index', compact(['agreements', 'agreementsPaginated']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validación de los datos
        $validatedData = $request->validate([
            'year' => 'required|integer',
            'semester' => 'required|string|max:1',
            'code' => 'required|string|max:6|unique:agreements,code',
            'type' => 'required|in:marco,especifico',
            'activity' => 'required|in:formacion,investigacion,extension,administrativa,otra',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        // Crear el acuerdo
        $agreement = new Agreement();
        $agreement->year = $validatedData['year'];
        $agreement->semester = $validatedData['semester'];
        $agreement->code = $validatedData['code'];
        $agreement->type = $validatedData['type'];
        $agreement->activity = $validatedData['activity'];
        $agreement->start_date = $validatedData['start_date'];

        $agreement->end_date = $validatedData['end_date'];
        $agreement->save();
        // Redirigir a la vista de acuerdos con un mensaje de éxito
        return redirect()->route('agreements')
            ->with('success', 'Agreement created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Agreement $agreement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        // Find the agreement by ID
        $agreement = Agreement::findOrFail($id);

        return view('dashboard.pages.agreements.edit', compact(['agreement']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the agreement by ID
        $agreement = Agreement::findOrFail($id);

        // Validación de los datos
        $validatedData = $request->validate([
            'year' => 'required|integer',
            'semester' => 'required|string|max:1',
            'code' => 'required|string|max:6|unique:agreements,code,' . $agreement->id,
            'type' => 'required|in:marco,especifico',
            'activity' => 'required|in:formacion,investigacion,extension,administrativa,otra',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Update the agreement with validated data
        $agreement->year = $validatedData['year'];
        $agreement->semester = $validatedData['semester'];
        $agreement->code = $validatedData['code'];
        $agreement->type = $validatedData['type'];
        $agreement->activity = $validatedData['activity'];
        $agreement->start_date = $validatedData['start_date'];
        $agreement->end_date = $validatedData['end_date'];

        // Save the changes
        $agreement->save();

        return redirect()->route('agreements')
            ->with('success', 'Agreement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $agreement = Agreement::findOrFail($id);
        $agreement->delete();

        return redirect()->route('agreements')
            ->with('success', 'Agreement deleted successfully.');
    }
}
