<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\University;
use App\Http\Requests\UniversityRequest;
use Illuminate\Http\Request;
use Log;

/**
 * Controller for managing University resources.
 * Handles CRUD operations for universities, including listing, creating, editing, updating, and deleting universities.
 * Also manages the association between universities and countries, and handles deletion of related people when a university is deleted.
 */
class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * Retrieves all universities and a paginated list of universities ordered by name.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $universities = University::all();
        $universitiesPaginated = University::orderBy('name', 'asc')->paginate(6);

        return view('dashboard.pages.universities.index', compact(['universities', 'universitiesPaginated']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * Validates and creates a new university, associating it with a country.
     *
     * @param  \App\Http\Requests\UniversityRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UniversityRequest $request)
    {
        $validatedData = $request->validated();

        // Create a new university instance with validated data except the city relation
        $university = new University();
        $university->name = $validatedData['name'];
        $university->code = $validatedData['code'];
        $university->description = $validatedData['description'];

        // Associate the university with a city
        $country = \App\Models\Country::find($validatedData['country_id']);
        $university->country()->associate($country);

        $university->save();

        Log::info('University created successfully by user: ' . auth()->user()->email . ' at ' . now());

        return redirect()->route('universities')
            ->with('success', 'University created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * Retrieves the university and all countries for the edit form.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        // Find the university by ID
        $university = University::findOrFail($id);
        $countries = \App\Models\Country::all();

        return view('dashboard.pages.universities.edit', compact(['university', 'countries']));
    }

    /**
     * Update the specified resource in storage.
     *
     * Validates and updates the university, associating it with a country.
     *
     * @param  \App\Http\Requests\UniversityRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UniversityRequest $request, string $id)
    {
        // Find the university by ID
        $university = University::findOrFail($id);

        $validatedData = $request->validated();

        // Update the university with validated data
        $university->name = $validatedData['name'];
        $university->code = $validatedData['code'];
        $university->description = $validatedData['description'];

        // Associate the university with a city
        $country = \App\Models\Country::find($validatedData['country_id']);
        $university->country()->associate($country);

        $university->save();

        Log::info('University updated successfully by user: ' . auth()->user()->email . ' at ' . now());
        Log::info('University updated: ' . $university->name . ' at ' . now());

        return redirect()->route('universities')
            ->with('success', 'University updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * Deletes the university and all people associated with it.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        // Find the university by ID
        $university = University::findOrFail($id);

        $people = Person::where('university_id', $university->id)->get();
        // Delete each person associated with this university
        foreach ($people as $person) {
            $person->delete();
        }

        // Delete the university
        $university->delete();

        Log::info('University deleted successfully by user: ' . auth()->user()->email . ' at ' . now());
        Log::info('University deleted: ' . $university->name . ' at ' . now());

        return redirect()->route('universities')
            ->with('success', 'University deleted successfully.');
    }
}
