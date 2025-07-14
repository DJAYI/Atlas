<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Http\Requests\ActivityRequest;
use Illuminate\Http\Request;
use Log;

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
     * @param  \App\Http\Requests\ActivityRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ActivityRequest $request)
    {
        $validated = $request->validated();

        Activity::create($validated);
        Log::info('Activity created successfully by user: ' . auth()->user()->email . ' at ' . now());

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
     * @param  \App\Http\Requests\ActivityRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ActivityRequest $request, string $id)
    {
        $activity = Activity::findOrFail($id);
        
        $validated = $request->validated();

        $activity->update($validated);

        Log::info('Activity updated successfully by user: ' . auth()->user()->email . ' at ' . now());
        Log::info('Activity updated: ' . $activity->name . ' at ' . now());
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

        Log::info('Activity deleted successfully by user: ' . auth()->user()->email . ' at ' . now());
        Log::info('Activity deleted: ' . $activity->name . ' at ' . now());

        return redirect()->route('activities')->with('success', 'Activity deleted successfully.');
    }
}
