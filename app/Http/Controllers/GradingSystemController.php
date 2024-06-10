<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GradingSystem;

class GradingSystemController extends Controller
{
    public function index()
    {
        $gradingSystems = GradingSystem::all();
        return view('backend.grading_system.index', compact('gradingSystems'));
    }


    public function create()
    {
        return view('backend.grading_system.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string',

        ]);



        // Create a new grading system
        GradingSystem::create([
            'name' => $request->name,

        ]);

        // Redirect the user to the index page with a success message
        return redirect()->route('grading_systems.index')->with('success', 'Grading system created successfully.');
    }

    public function edit($id)
    {
        $gradingSystem = GradingSystem::findOrFail($id);
        return view('backend.grading_system.edit', compact('gradingSystem'));
    }

    public function destroy($id)
    {
        $gradingSystem = GradingSystem::findOrFail($id);
        $gradingSystem->delete();

        return redirect()->route('grading_systems.index')->with('success', 'Grading System deleted successfully');
    }
}
