<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Faculty;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $careers = Career::all()->sortByDesc('created_at');
        $careersPaginated = Career::paginate(10);
        return view('dashboard.pages.careers.index', compact('careers', 'careersPaginated'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'faculty_id' => 'required|exists:faculties,id',
        ]);

        Career::create($request->all());

        return redirect()->route('careers')->with('success', 'Career created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $faculties = Faculty::all();
        $career = Career::findOrFail($id);
        return view('dashboard.pages.careers.edit', compact(['career', 'faculties']));
    }

    /**
     * Update the specified resource in storage.
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

        return redirect()->route('careers')->with('success', 'Career updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $career = Career::findOrFail($id);
        $career->delete();

        return redirect()->route('careers')->with('success', 'Career deleted successfully.');
    }
}
