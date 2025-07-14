<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Faculty;
use Illuminate\Http\Request;

/**
 * Class CareerController
 * 
 * Handles CRUD operations for Career resources, including listing, creating, editing, updating, and deleting careers.
 *
 * @package App\Http\Controllers
 */
class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * Retrieves all careers sorted by creation date (descending) and paginates the results.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $careers = Career::all()->sortByDesc('created_at');
        $careersPaginated = Career::paginate(10);
        return view('dashboard.pages.careers.index', compact('careers', 'careersPaginated'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * Validates and creates a new career record from the request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'faculty_id' => 'required|exists:faculties,id',
        ]);

        Career::create($request->all());

        // Log the creation of the career
        Log::info('Career created successfully by user: ' . auth()->user()->email . ' at ' . now());

        return redirect()->route('careers')->with('success', 'Career created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * Retrieves the specified career and all faculties for the edit form.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        $faculties = Faculty::all();
        $career = Career::findOrFail($id);
        return view('dashboard.pages.careers.edit', compact(['career', 'faculties']));
    }

    /**
     * Update the specified resource in storage.
     *
     * Validates and updates the specified career record with the request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'faculty_id' => 'required|exists:faculties,id',
        ]);

        $career = Career::findOrFail($id);
        $career->update($request->all());

        Log::info('Career updated successfully by user: ' . auth()->user()->email . ' at ' . now());
        Log::info('Career updated: ' . $career->name . ' at ' . now());

        return redirect()->route('careers')->with('success', 'Career updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * Deletes the specified career record.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $career = Career::findOrFail($id);
        $career->delete();

        Log::info('Career deleted successfully by user: ' . auth()->user()->email . ' at ' . now());
        Log::info('Career deleted: ' . $career->name . ' at ' . now());

        return redirect()->route('careers')->with('success', 'Career deleted successfully.');
    }
}
