<?php

namespace App\Http\Controllers;

use App\Imports\StudentImport;
use App\Models\Form;
use App\Models\School;
use App\Models\Stream;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function import(Request $request, $schoolId, $streamId, $form)
    {
        $validator = Validator::make($request->all(), [
            'import' => 'required|mimes:xls,xlsx',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Please select a valid Excel file.'], 422);
        }

        try {
            $import = new StudentImport($schoolId, $streamId, $form);
            Excel::import($import, request()->file('import'));

            return response()->json(['message' => 'Students imported successfully.']);
        } catch (\Exception $e) {

            return response()->json(['message' => 'An error occurred while importing students.'], 500);
        }
    }

    public function create($schoolId, $streamId, $form)
    {
        $school = School::findOrFail($schoolId);
        $stream = Stream::findOrFail($streamId);
        $form = Form::findOrFail($form);

        return view('backend.students.create', compact('school', 'form', 'stream'));
    }

    public function store(Request $request, $schoolId, $streamId, $form)
    {
        $request->validate([
            'name' => 'required|string',
            'adm' => 'required',
        ]);

        $student = new Student([
            'name' => $request->input('name'),
            'adm' => $request->input('adm'),
            'gender' => $request->input('gender'),
            'school_id' => $schoolId,
            'stream_id' => $streamId,
            'form_id' => $form,
            'slug' => Str::slug($request->input('name')),
        ]);

        $student->save();

        return redirect()->route('streams.show', ['schoolId' => $schoolId, 'streamId' => $streamId, 'form' => $form])
            ->with('success', 'Student created successfully.');
    }

    public function destroy($schoolId, $streamId, $id)
    {
        try {
            $student = Student::findOrFail($id);

            // Make sure the student belongs to the specified school and stream
            if ($student->school_id == $schoolId && $student->stream_id == $streamId) {
                $student->delete();
                return redirect()->back()->with('success', 'Student deleted successfully.');
            } else {
                return response()->json(['message' => 'Student not found in specified school and stream.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting the student.'], 500);
        }
    }

    public function deleteSelected(Request $request, $schoolId, $streamId, $form)
    {
        $selectedStudentIds = $request->input('selectedStudents', []);

        try {
            // Delete selected students
            Student::where('school_id', $schoolId)
                ->where('stream_id', $streamId)
                ->whereIn('id', $selectedStudentIds)
                ->delete();

            return redirect()->back()->with('success', 'Selected students deleted successfully.');
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting selected students.'], 500);
        }
    }

}
