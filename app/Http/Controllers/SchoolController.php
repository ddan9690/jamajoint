<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\County;
use App\Models\School;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schools = School::orderBy('name', 'asc')->get();
        $counties = County::orderBy('name', 'asc')->get(); // Fetch all counties

        return view('backend.schools.index', compact('schools', 'counties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $counties = County::all();
        return view('backend.schools.create', compact('counties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|in:National,Extra-County,County,Sub-County',
            'type' => 'required|string|in:Boys,Girls,Mixed',
            'county_id' => 'required|exists:counties,id', // Ensure county_id exists in counties table
        ]);

        $school = new School();
        $school->name = $validatedData['name'];
        $school->level = $validatedData['level'];
        $school->type = $validatedData['type'];
        $school->county_id = $validatedData['county_id'];
        $school->slug = Str::slug($validatedData['name'], '-'); // Generate slug based on name
        $school->save();

        return response()->json([
            'message' => 'School created successfully.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $school = School::with('streams', 'users')->findOrFail($id);
        $forms = Form::all();

        return view('backend.schools.show', compact('school', 'forms'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $school = School::findOrFail($id);
        $counties = County::all();

        return view('backend.schools.edit', compact('school', 'counties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'type' => 'required|in:Boys,Girls,Mixed',
            'level' => 'required|in:National,Extra-County,County,Sub-County',
            'county_id' => 'required|exists:counties,id',
            'status' => 'required|in:0,1',
        ]);

        $school = School::findOrFail($id);

        // Check if the name has changed
        if ($school->name !== $request->name) {
            $school->slug = Str::slug($request->name, '-');
        }

        $school->name = $request->name;
        $school->type = $request->type;
        $school->level = $request->level;
        $school->county_id = $request->county_id;
        $school->status = $request->status;

        $school->save();

        return redirect()->route('schools.index')->with('success', 'School updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $school = School::findOrFail($id);

        // You can perform any additional checks or validations here before deletion

        $school->delete();

        return response()->json([
            'message' => 'School deleted successfully.',
        ], 200);
    }
}
