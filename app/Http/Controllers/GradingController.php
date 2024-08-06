<?php

namespace App\Http\Controllers;

use App\Models\Grading;
use Illuminate\Http\Request;

class GradingController extends Controller
{
    public function index()
    {
        // Retrieve all gradings from the database
        $gradings = Grading::all();

        // Pass the gradings data to the view
        return view('backend.gradings.index', compact('gradings'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'grade' => 'required|string',
            'low' => 'required|numeric',
            'high' => 'required|numeric',
            'points' => 'required|numeric',
        ]);

        // Create a new Grading instance
        $grading = new Grading();
        $grading->grade = $validatedData['grade'];
        $grading->low = $validatedData['low'];
        $grading->high = $validatedData['high'];
        $grading->points = $validatedData['points'];

        // Save the grading
        $grading->save();

        // Return a JSON response
        return response()->json(['message' => 'Grading created successfully'], 201);
    }

    public function update(Request $request, $id)
    {
        $grading = Grading::findOrFail($id);

        // Validate the incoming request data
        $validatedData = $request->validate([
            'grade' => 'required|string',
            'low' => 'required|numeric',
            'high' => 'required|numeric',
            'points' => 'required|numeric',
        ]);

        // Check for overlap with existing gradings
        $overlaps = Grading::where('low', '<=', $validatedData['high'])
            ->where('high', '>=', $validatedData['low'])
            ->where('id', '<>', $grading->id)
            ->exists();

        if ($overlaps) {
            return response()->json(['message' => 'Grade range overlaps with existing gradings'], 400);
        }

        // Update the grading
        $grading->update($validatedData);

        return response()->json(['message' => 'Grading updated successfully'], 200);
    }

    public function destroy($id)
    {
        $grading = Grading::findOrFail($id);
        $grading->delete();

        return response()->json(['message' => 'Grading deleted successfully'], 200);
    }

}
