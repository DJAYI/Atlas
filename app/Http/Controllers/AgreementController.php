<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Http\Requests\AgreementRequest;
use Illuminate\Http\Request;
use Log;

/**
 * Class AgreementController
 *
 * Handles CRUD operations for Agreement resources, including listing, creation, editing, updating, and deletion.
 *
 * Methods:
 * - index(): Displays a list of all agreements and a paginated list ordered by start date.
 * - store(Request $request): Validates and stores a new agreement.
 * - edit(string $id): Shows the form for editing a specific agreement.
 * - update(Request $request, string $id): Validates and updates an existing agreement.
 * - destroy(string $id): Deletes a specific agreement.
 */
class AgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $agreements = Agreement::all();
        $agreementsPaginated = Agreement::orderBy('start_date', 'desc')->paginate(6);

        return view('dashboard.pages.agreements.index', compact(['agreements', 'agreementsPaginated']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AgreementRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AgreementRequest $request)
    {
        // Datos ya validados por AgreementRequest
        $validatedData = $request->validated();
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

        Log::info('Agreement created successfully by user: ' . auth()->user()->email . ' at ' . now());

        // Redirigir a la vista de acuerdos con un mensaje de éxito
        return redirect()->route('agreements')
            ->with('success', 'Agreement created successfully.');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id  The ID of the agreement to edit
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {

        // Find the agreement by ID
        $agreement = Agreement::findOrFail($id);

        return view('dashboard.pages.agreements.edit', compact(['agreement']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AgreementRequest  $request
     * @param  string  $id  The ID of the agreement to update
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AgreementRequest $request, string $id)
    {
        // Find the agreement by ID
        $agreement = Agreement::findOrFail($id);

        // Datos ya validados por AgreementRequest
        $validatedData = $request->validated();

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

        Log::info('Agreement updated successfully by user: ' . auth()->user()->email . ' at ' . now());

        Log::info('Agreement updated: ' . $agreement->code . ' at ' . now());

        return redirect()->route('agreements')
            ->with('success', 'Agreement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id  The ID of the agreement to delete
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $agreement = Agreement::findOrFail($id);
        $agreement->delete();

        Log::info('Agreement deleted successfully by user: ' . auth()->user()->email . ' at ' . now());
        Log::info('Agreement deleted: ' . $agreement->code . ' at ' . now());

        return redirect()->route('agreements')
            ->with('success', 'Agreement deleted successfully.');
    }
}
