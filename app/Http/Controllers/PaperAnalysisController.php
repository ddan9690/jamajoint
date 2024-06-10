<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Form;
use App\Models\Grading;
use App\Models\Mark;
use Illuminate\Support\Facades\Auth;

class PaperAnalysisController extends Controller
{
    public function subject1Analysis($exam_id, $form_id, $slug)
    {
        // Fetch data or calculations for subject 1 analysis
        // For example:
        $exam = Exam::find($exam_id);
        $form = Form::find($form_id);

        // $subject1AnalysisData = ...; // Get the analysis data for subject 1

        return view('backend.results.paper1.index', compact('exam', 'form'));
    }

    public function myschoolResultsPaper1($exam_id, $form_id, $slug)
    {
        // Retrieve the exam
        $exam = Exam::findOrFail($exam_id);

        // Retrieve the form associated with the exam
        $form = $exam->form;



        // Get the authenticated user's school
        $school = Auth::user()->school;

        // Get the students from the school who are in the same form
        $students = $school->students->where('form_id', $form->id);

        // Filter students to include only those with marks greater than 0 in Paper 1
        $filteredStudents = $students->filter(function ($student) use ($exam) {
            $paper1Marks = Mark::where('student_id', $student->id)
                ->where('exam_id', $exam->id)
                ->where('subject_id', 1) // Assuming subject_id 1 is Paper 1
                ->sum('marks');

            return $paper1Marks > 0;
        });

        // Retrieve the grading system for the exam
        $gradingSystem = Grading::where('grading_system_id', $exam->grading_system_id)->get();

        // Calculate the average marks and assign grades for Paper 1 for each filtered student
        $results = [];

        foreach ($filteredStudents as $student) {
            $paper1Marks = Mark::where('student_id', $student->id)
                ->where('exam_id', $exam->id)
                ->where('subject_id', 1)
                ->sum('marks');

            // Determine the grade based on the grading system
            $grade = $this->calculateGrade($paper1Marks, $gradingSystem);

            // Store the student's result for Paper 1
            $results[] = [
                'student' => $student,
                'paper1Marks' => $paper1Marks,
                'grade' => $grade,
            ];
        }

        // Sort the results by Paper 1 marks in descending order
        usort($results, function ($a, $b) {
            return $b['paper1Marks'] - $a['paper1Marks'];
        });

        // Calculate grade analysis for Paper 1
        $analysis = [];

        // Group students by stream for Paper 1
        $studentsByStream = $filteredStudents->groupBy('stream.name');

        foreach ($studentsByStream as $streamName => $streamStudents) {
            $gradesCount = [];

            // Initialize the gradesCount array with zeros
            foreach ($gradingSystem as $grade) {
                $gradesCount[$grade->grade] = 0;
            }

            $totalStudents = $streamStudents->count();

            // Calculate grades count for each grade for Paper 1
            foreach ($streamStudents as $student) {
                $studentResult = collect($results)->where('student.id', $student->id)->first();

                if ($studentResult) {
                    $studentGrade = $studentResult['grade'];
                    $gradesCount[$studentGrade]++;
                }
            }

            // Calculate mean for Paper 1
            $mean = 0;
            foreach ($gradesCount as $grade => $count) {
                $gradePoints = $gradingSystem->where('grade', $grade)->first()->points ?? 0;
                $mean += ($count * $gradePoints);
            }
            $mean = ($totalStudents > 0) ? round($mean / $totalStudents, 4) : 0;

            // Add data to the analysis array for Paper 1
            $analysis[] = [
                'stream' => $streamName,
                'grades' => $gradesCount,
                'total' => $totalStudents,
                'mean' => $mean,
            ];
        }

        // Sort the analysis by mean in descending order
        usort($analysis, function ($a, $b) {
            return $b['mean'] - $a['mean'];
        });

        // Add the overall analysis row for Paper 1
        $overallGradesCount = [];
        foreach ($gradingSystem as $grade) {
            $overallGradesCount[$grade->grade] = 0;
        }

        $overallTotalStudents = 0;

        // Calculate overall grades count for Paper 1
        foreach ($studentsByStream as $streamStudents) {
            foreach ($streamStudents as $student) {
                $studentResult = collect($results)->where('student.id', $student->id)->first();

                if ($studentResult) {
                    $studentGrade = $studentResult['grade'];
                    $overallGradesCount[$studentGrade]++;
                    $overallTotalStudents++;
                }
            }
        }

        // Calculate overall mean for Paper 1
        $overallMean = 0;
        foreach ($overallGradesCount as $grade => $count) {
            $gradePoints = $gradingSystem->where('grade', $grade)->first()->points ?? 0;
            $overallMean += ($count * $gradePoints);
        }
        $overallMean = ($overallTotalStudents > 0) ? round($overallMean / $overallTotalStudents, 4) : 0;

        // Load the view with the results, gradingSystem, and analysis for Paper 1
        return view('backend.results.paper1.myschoolResult', compact('exam', 'school', 'results', 'gradingSystem', 'analysis', 'overallGradesCount', 'overallTotalStudents', 'overallMean', 'form'));
    }

/**
 * Calculate the grade based on the marks and grading system.
 *
 * @param int $marks
 * @param \Illuminate\Support\Collection $gradingSystem
 * @return string
 */
    private function calculateGrade($marks, $gradingSystem)
    {
        foreach ($gradingSystem as $grade) {
            if ($marks >= $grade->low && $marks <= $grade->high) {
                return $grade->grade;
            }
        }
        return 'N/A';
    }

    public function subject2Analysis($exam_id)
    {
        // Fetch data or calculations for subject 1 analysis
        // For example:
        $exam = Exam::find($exam_id);
        // $subject1AnalysisData = ...; // Get the analysis data for subject 1

        return view('backend.results.paper2.index', compact('exam'));
    }

    public function myschoolResultsPaper2($exam_id, $form_id, $slug)
    {
        // Retrieve the exam
        $exam = Exam::findOrFail($exam_id);

        // Retrieve the form associated with the exam
        $form = $exam->form;

        // Get the authenticated user's school
        $school = Auth::user()->school;

        // Get the students from the school who are in the same form
        $students = $school->students->where('form_id', $form->id);

        // Filter students to include only those with marks greater than 0 in Paper 2
        $filteredStudents = $students->filter(function ($student) use ($exam) {
            $paper2Marks = Mark::where('student_id', $student->id)
                ->where('exam_id', $exam->id)
                ->where('subject_id', 2) // Assuming subject_id 2 is Paper 2
                ->sum('marks');

            return $paper2Marks > 0;
        });

        // Retrieve the grading system for the exam
        $gradingSystem = Grading::where('grading_system_id', $exam->grading_system_id)->get();

        // Calculate the average marks and assign grades for Paper 2 for each filtered student
        $results = [];

        foreach ($filteredStudents as $student) {
            $paper2Marks = Mark::where('student_id', $student->id)
                ->where('exam_id', $exam->id)
                ->where('subject_id', 2)
                ->sum('marks');

            // Determine the grade based on the grading system
            $grade = $this->calculateGrade($paper2Marks, $gradingSystem);

            // Store the student's result for Paper 2
            $results[] = [
                'student' => $student,
                'paper2Marks' => $paper2Marks,
                'grade' => $grade,
            ];
        }

        // Sort the results by Paper 2 marks in descending order
        usort($results, function ($a, $b) {
            return $b['paper2Marks'] - $a['paper2Marks'];
        });

        // Calculate grade analysis for Paper 2
        $analysis = [];

        // Group students by stream for Paper 2
        $studentsByStream = $filteredStudents->groupBy('stream.name');

        foreach ($studentsByStream as $streamName => $streamStudents) {
            $gradesCount = [];

            // Initialize the gradesCount array with zeros
            foreach ($gradingSystem as $grade) {
                $gradesCount[$grade->grade] = 0;
            }

            $totalStudents = $streamStudents->count();

            // Calculate grades count for each grade for Paper 2
            foreach ($streamStudents as $student) {
                $studentResult = collect($results)->where('student.id', $student->id)->first();

                if ($studentResult) {
                    $studentGrade = $studentResult['grade'];
                    $gradesCount[$studentGrade]++;
                }
            }

            // Calculate mean for Paper 2
            $mean = 0;
            foreach ($gradesCount as $grade => $count) {
                $gradePoints = $gradingSystem->where('grade', $grade)->first()->points ?? 0;
                $mean += ($count * $gradePoints);
            }
            $mean = ($totalStudents > 0) ? round($mean / $totalStudents, 4) : 0;

            // Add data to the analysis array for Paper 2
            $analysis[] = [
                'stream' => $streamName,
                'grades' => $gradesCount,
                'total' => $totalStudents,
                'mean' => $mean,
            ];
        }

        // Sort the analysis by mean in descending order
        usort($analysis, function ($a, $b) {
            return $b['mean'] - $a['mean'];
        });

        // Add the overall analysis row for Paper 2
        $overallGradesCount = [];
        foreach ($gradingSystem as $grade) {
            $overallGradesCount[$grade->grade] = 0;
        }

        $overallTotalStudents = 0;

        // Calculate overall grades count for Paper 2
        foreach ($studentsByStream as $streamStudents) {
            foreach ($streamStudents as $student) {
                $studentResult = collect($results)->where('student.id', $student->id)->first();

                if ($studentResult) {
                    $studentGrade = $studentResult['grade'];
                    $overallGradesCount[$studentGrade]++;
                    $overallTotalStudents++;
                }
            }
        }

        // Calculate overall mean for Paper 2
        $overallMean = 0;
        foreach ($overallGradesCount as $grade => $count) {
            $gradePoints = $gradingSystem->where('grade', $grade)->first()->points ?? 0;
            $overallMean += ($count * $gradePoints);
        }
        $overallMean = ($overallTotalStudents > 0) ? round($overallMean / $overallTotalStudents, 4) : 0;

        // Load the view with the results, gradingSystem, and analysis for Paper 2
        return view('backend.results.paper2.myschoolResult', compact('exam', 'school', 'results', 'gradingSystem', 'analysis', 'overallGradesCount', 'overallTotalStudents', 'overallMean', 'form'));
    }


}
