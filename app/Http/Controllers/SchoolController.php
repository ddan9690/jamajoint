<?php

namespace App\Http\Controllers;

use App\Models\Form;
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
    return view('backend.schools.index', ['schools' => $schools]);
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|string|in:National,Extra-County,County,Sub-County',
            'type' => 'required|string|in:Boys,Girls,Mixed',
            'county' => 'required|string', // You can further validate county here if needed
        ]);

        $school = new School();
        $school->name = $validatedData['name'];
        $school->level = $validatedData['level'];
        $school->type = $validatedData['type'];
        $school->county = $validatedData['county'];
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

        return view('backend.schools.edit', compact('school')); // Create view for editing school
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
            'county' => 'required',
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
        $school->county = $request->county;
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
