<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Form;
use App\Models\GradingSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams = Exam::orderBy('name', 'asc')->get();
        $forms = Form::all();
        $gradingSystems = GradingSystem::orderBy('name')->get();

        return view('backend.exams.index', compact('exams', 'forms', 'gradingSystems'));
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
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'form_id' => 'required|exists:forms,id',
            'term' => 'required|integer|in:1,2,3',
            'year' => 'required|integer',
            'grading_system_id' => 'required|exists:grading_systems,id',
        ]);

        // Get the authenticated user's ID or set it to 1 if not authenticated
        $user_id = auth()->user() ? auth()->user()->id : 1;

        // Generate a slug from the exam name
        $slug = Str::slug($validatedData['name']);

        // Create a new Exam instance with the validated data, user_id, and slug
        $exam = new Exam([
            'name' => $validatedData['name'],
            'slug' => $slug,
            'term' => $validatedData['term'],
            'year' => $validatedData['year'],
            'form_id' => $validatedData['form_id'],
            'user_id' => $user_id,
            'grading_system_id' => $validatedData['grading_system_id'],
        ]);

        // Save the exam instance
        $exam->save();

        return response()->json(['message' => 'Exam created successfully']);
    }

    /**
     * Display the specified resource.
     */
    // ExamController.php

    public function show($id)
    {
        $exam = Exam::findOrFail($id);
        $registeredSchools = $exam->schools;

        return view('backend.exams.show', compact('exam', 'registeredSchools'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, $slug)
    {
        $exam = Exam::findOrFail($id);
        $forms = Form::all(); // Retrieve all forms
        $gradingSystems = GradingSystem::orderBy('name')->get();

        // You can check if the provided slug matches the actual slug
        if ($exam->slug !== $slug) {
            return redirect()->route('exams.edit', ['id' => $id, 'slug' => $exam->slug]);
        }

        return view('backend.exams.edit', compact('exam', 'forms', 'gradingSystems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $slug)
    {
        $exam = Exam::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'term' => 'required|integer|in:1,2,3',
            'year' => 'required|integer',
            'published' => 'required|in:no,yes',
            'form_id' => 'required|exists:forms,id',
            'grading_system_id' => 'required|exists:grading_systems,id', // Add validation for "grading_system_id"
        ]);

        $slug = Str::slug($validatedData['name']);

        $exam->update([
            'name' => $validatedData['name'],
            'slug' => $slug,
            'term' => $validatedData['term'],
            'year' => $validatedData['year'],
            'published' => $validatedData['published'],
            'form_id' => $validatedData['form_id'],
            'grading_system_id' => $validatedData['grading_system_id'], // Update the "grading_system_id" field
        ]);

        return redirect()->route('exams.index')->with('success', 'Exam updated successfully.');
    }


    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);

        // Add any additional logic here, if needed

        $exam->delete();

        return redirect()->route('exams.index')->with('success', 'Exam deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $exam = Exam::findOrFail($id);

        $validatedData = $request->validate([
            'published' => 'required|in:yes,no',
        ]);

        $exam->update(['published' => $validatedData['published']]);

        return redirect()->route('exams.index')->with('success', 'Published status updated successfully.');
    }

    public function updateGradingSystem(Request $request, $id)
{
    $exam = Exam::findOrFail($id);

    $validatedData = $request->validate([
        'grading_system_id' => 'required|exists:grading_systems,id',
    ]);

    // Update the grading system for the exam
    $exam->update(['grading_system_id' => $validatedData['grading_system_id']]);

    return redirect()->route('exams.index')->with('success', 'Grading system updated successfully.');
}

}
