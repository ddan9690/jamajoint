<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\School;
use Illuminate\Http\Request;

class ExamSchoolController extends Controller
{
    public function register(Exam $exam)
    {

        $schools = School::whereNotIn('id', $exam->schools->pluck('id'))
            ->orderBy('name')
            ->get();


        return view('backend.exams.register', compact('exam', 'schools'));
    }

    public function store(Request $request, Exam $exam)
    {
        // Validate the incoming request data
        $request->validate([
            'schools' => 'required|array',
            'schools.*' => 'exists:schools,id',
        ]);



        // Attach selected schools to the exam
        $exam->schools()->attach($request->input('schools'));

        return redirect()->route('exams.show', ['id' => $exam->id])
            ->with('success', 'Schools registered successfully for the exam.');
    }

    public function unregisterSchool($id, $schoolId)
    {
        $exam = Exam::findOrFail($id);
        $school = School::findOrFail($schoolId);

        $exam->schools()->detach($schoolId);

        return redirect()->route('exams.show', ['id' => $exam->id])->with('success', 'School unregistered successfully.');
    }
}
