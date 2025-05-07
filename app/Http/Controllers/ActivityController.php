<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

/**
 * Controller for managing Activity resources.
 * 
 * Handles listing, creating, editing, updating, and deleting activities.
 */
class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * Retrieves all activities and a paginated list of activities ordered by creation date.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $activities = Activity::all();
        $activitiesPaginated = Activity::orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.pages.activities.index', compact(['activities', 'activitiesPaginated']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * Validates and creates a new activity from the request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        Activity::create($request->all());

        return redirect()->route('activities')->with('success', 'Activity created successfully.');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * Finds the activity by ID and returns the edit view.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        $activity = Activity::findOrFail($id);
        return view('dashboard.pages.activities.edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * Validates and updates the specified activity with request data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        $activity = Activity::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $activity->update($request->all());

        return redirect()->route('activities')->with('success', 'Activity updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * Deletes the specified activity by ID.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        return redirect()->route('activities')->with('success', 'Activity deleted successfully.');
    }
}
