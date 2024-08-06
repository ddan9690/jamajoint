<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Mark;
use App\Models\User;
use App\Models\School;
use App\Models\Stream;
use App\Models\Student;
use App\Models\Subject;
use App\Models\ExamSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarkController extends Controller
{

    // check if the users'schol is registered for the exam clicked. if yes, proceed to the marks.index blade
    public function checkRegistrationStatus($exam)
    {
        $examId = $exam;

        $userSchoolId = auth()->user()->school_id;


        // Check if the user's school is registered for the exam
        $isRegistered = ExamSchool::where('exam_id', $examId)
            ->where('school_id', $userSchoolId)
            ->exists();



        if ($isRegistered) {
            return response()->json(['registered' => true]);
        } else {
            // Get the school name
            $schoolName = School::find($userSchoolId)->name;

            // Return an error message with Toastr
            return response()->json([
                'registered' => false,
                'message' => "Your school ($schoolName) is not registered for this exam or has not submitted students details."
            ]);
        }
    }


    public function index(Exam $exam)
    {
        $school = Auth::user()->school;

        // Get the form associated with the current exam
        $form = $exam->form;

        // Retrieve streams and students for the specific form
        $streams = $school->streams()
            ->where('form_id', $form->id)
            ->orderBy('name', 'asc')
            ->get();

        $students = Student::whereIn('stream_id', $streams->pluck('id'))
            ->orderBy('adm', 'asc')
            ->get();

        return view('backend.marks.index', [
            'exam' => $exam,
            'streams' => $streams,
            'students' => $students,
            'school' => $school,
        ]);
    }


    public function streamMarksView(Exam $exam, Stream $stream)
    {
        $subjects = Subject::orderBy('name', 'asc')->get();

        // Initialize an array to store the existence of submitted marks for each subject
        $marksExistence = [];

        foreach ($subjects as $subject) {
            // Check if marks exist for the subject in the given exam, stream, and students
            $marksExistence[$subject->id] = Mark::where([
                'exam_id' => $exam->id,
                'stream_id' => $stream->id,
                'subject_id' => $subject->id,
            ])->exists();
        }

        return view('backend.marks.streamview', [
            'exam' => $exam,
            'stream' => $stream,
            'subjects' => $subjects,
            'marksExistence' => $marksExistence, // Pass marksExistence to the view
        ]);
    }


    public function submitMarks(Exam $exam, Stream $stream, Subject $subject)
    {
        $students = $stream->students()->orderBy('adm', 'asc')->get();

        return view('backend.marks.submit', [
            'exam' => $exam,
            'stream' => $stream,
            'subject' => $subject,
            'students' => $students,
        ]);
    }

    public function store(Request $request, $exam, $stream, $subject)
    {
        // Validate the form input data
        $request->validate([
            'marks' => 'required|array',
            'student_ids' => 'required|array',
            'exam_id' => 'required|exists:exams,id',
            'stream_id' => 'required|exists:streams,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $marksData = $request->input('marks');
        $studentIds = $request->input('student_ids');

        // Filter out students with empty marks
        $validMarksData = array_filter($marksData, function ($marks) {
            return $marks !== null && $marks !== '';
        });

        // Filter student_ids based on valid marks
        $validStudentIds = array_keys($validMarksData);
        // Process and store the submitted marks
        foreach ($validStudentIds as $studentId) {
            // Find the corresponding student and mark record
            $student = Student::find($studentId);
            $marks = $marksData[$studentId];

            $mark = Mark::where([
                'student_id' => $studentId,
                'exam_id' => $request->input('exam_id'),
                'stream_id' => $request->input('stream_id'),
                'subject_id' => $request->input('subject_id'),
            ])->first();

            // Update or create a new mark record
            if (!$mark) {
                $mark = new Mark();
                $mark->student_id = $studentId;
                $mark->exam_id = $request->input('exam_id');
                $mark->stream_id = $request->input('stream_id');
                $mark->subject_id = $request->input('subject_id');
            }

            $mark->marks = $marks;
            $mark->save();
        }

        // Redirect back with a success message or to another page
        return redirect()->route('marks.show', [
            'exam' => $mark->exam_id,
            'stream' => $mark->stream_id,
            'subject' => $mark->subject_id,
        ])->with('success', 'Marks submitted successfully.');
    }

    public function show($exam, $stream, $subject)
    {
        $exam = Exam::findOrFail($exam);
        $stream = Stream::findOrFail($stream);
        $subject = Subject::findOrFail($subject);


        // Retrieve marks ordered by ADM ascending
        $marks = Mark::where([
            'exam_id' => $exam->id,
            'stream_id' => $stream->id,
            'subject_id' => $subject->id,
        ])->orderBy('marks', 'desc')->get();

        return view('backend.marks.show', compact('exam', 'stream', 'subject', 'marks'));
    }

    public function deleteAllMarks(Exam $exam, Stream $stream, Subject $subject)
    {
        // Ensure that you have appropriate validation and authorization logic here
        // to confirm that the user is allowed to delete all marks.

        // Delete all marks for the specified exam, stream, and subject
        Mark::where([
            'exam_id' => $exam->id,
            'stream_id' => $stream->id,
            'subject_id' => $subject->id,
        ])->delete();

        // Redirect to the marks.streamMarksView route after deleting marks
        return redirect()->route('marks.streamMarksView', [$exam->id, $stream->id])->with('success', 'All marks deleted successfully.');
    }

    public function addResultView(Exam $exam, Stream $stream, Subject $subject)
    {
        // Get the list of students who don't have marks for the specified exam, stream, and subject
        $studentsWithoutMarks = $stream->students()->whereDoesntHave('marks', function ($query) use ($exam, $subject) {
            $query->where('exam_id', $exam->id)->where('subject_id', $subject->id);
        })->orderBy('adm', 'asc')->get();

        return view('backend.marks.addResult', [
            'exam' => $exam,
            'stream' => $stream,
            'subject' => $subject,
            'studentsWithoutMarks' => $studentsWithoutMarks,
        ]);
    }

    public function storeAddedMark(Request $request, Exam $exam, Stream $stream, Subject $subject)
    {
        // Validate the submitted marks, you can customize the validation rules
        $validatedData = $request->validate([
            'marks.*' => 'required|numeric|min:0|max:100', // Adjust validation rules as needed
        ]);

        // Loop through the validated data to save marks
        foreach ($validatedData['marks'] as $studentId => $marks) {
            // Create or update a mark for each student
            Mark::updateOrCreate(
                [
                    'exam_id' => $exam->id,
                    'stream_id' => $stream->id,
                    'subject_id' => $subject->id,
                    'student_id' => $studentId,
                ],
                [
                    'marks' => $marks,
                ]
            );
        }

        // Redirect back to the marks.show route with a success message
        return redirect()->route('marks.show', [$exam->id, $stream->id, $subject->id])->with('success', 'Marks submitted successfully.');
    }


    public function edit(Mark $mark)
    {
        return view('backend.marks.edit', compact('mark'));
    }

    public function update(Request $request, Mark $mark)
    {
        // Validation rules for updating the mark
        $rules = [
            'marks' => 'required|integer|min:0|max:100',
        ];

        $request->validate($rules);

        // Update the mark's "marks" attribute with the new value
        $mark->update([
            'marks' => $request->input('marks'),
        ]);

        return redirect()->route('marks.show', [
            'exam' => $mark->exam->id,
            'stream' => $mark->stream->id,
            'subject' => $mark->subject->id,
        ])->with('success', 'Mark updated successfully.');
    }

    public function destroy(Mark $mark)
    {
        $mark->delete();

        // Redirect to the marks.show route
        return redirect()->route('marks.show', [
            'exam' => $mark->exam->id,
            'stream' => $mark->stream->id,
            'subject' => $mark->subject->id,
        ])->with('success', 'Mark deleted successfully.');
    }

    public function markSubmissionStatus()
    {
        // Retrieve exams with "published" status set to "no" and order them by name in ascending order
        $exams = Exam::where('published', 'no')
            ->orderBy('name', 'asc')
            ->get();

        return view('backend.marks.submission-status.mark-submission-status', compact('exams'));
    }

    public function displaySchoolsRegistered($examId)
    {
        // Find the exam
        $exam = Exam::find($examId);

        // Find the schools registered for the exam
        $schools = ExamSchool::where('exam_id', $examId)
            ->join('schools', 'exam_schools.school_id', '=', 'schools.id')
            ->orderBy('schools.name', 'asc')
            ->get();

        // Calculate the total number of students for each school
        foreach ($schools as $school) {
            $totalStudents = Student::where('school_id', $school->id)->count();

            $subject1Count = Mark::where('exam_id', $exam->id)
                ->where('subject_id', 1)
                ->whereIn('student_id', function ($query) use ($school) {
                    $query->select('id')
                        ->from('students')
                        ->where('school_id', $school->id);
                })->count();

            $subject2Count = Mark::where('exam_id', $exam->id)
                ->where('subject_id', 2)
                ->whereIn('student_id', function ($query) use ($school) {
                    $query->select('id')
                        ->from('students')
                        ->where('school_id', $school->id);
                })->count();

            $school->studentsWithMarks = "$subject1Count/$totalStudents";
            $school->totalStudents = $totalStudents;
        }

        return view('backend.marks.submission-status.schools-registered', compact('exam', 'schools'));
    }













    public function displayStreamsForSchool($examId, $schoolId)
    {
        $exam = Exam::find($examId);
        $school = School::find($schoolId);

        if (!$exam || !$school) {
            return abort(404); // Handle cases where the exam or school is not found.
        }

        // Get the streams for the school in ascending order by name
        $streams = Stream::where('school_id', $schoolId)
            ->orderBy('name', 'asc')
            ->get();

        return view('backend.marks.submission-status.streams-for-school', compact('exam', 'school', 'streams'));
    }
}
