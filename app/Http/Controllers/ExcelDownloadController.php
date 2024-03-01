<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Form;
use App\Models\Mark;
use App\Models\School;
use App\Models\Grading;
use App\Models\ExamSchool;
use App\Exports\StreamRankingExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MySchoolResultsExport;
use App\Exports\OverallStudentRankingExport;

class ExcelDownloadController extends Controller
{
    public function overallStudentRanking($id, $form_id, $slug)
    {
        // Retrieve the exam
        $exam = Exam::findOrFail($id);

        // Retrieve the form for the exam
        $form = Form::findOrFail($form_id);

        // Retrieve all schools registered for the exam
        $schools = ExamSchool::where('exam_id', $exam->id)->with('school')->get();

        // Retrieve the grading system from the database
        $gradingSystem = Grading::all();

        // Initialize an array to store student mean results
        $studentMeans = [];

        // Calculate the mean for each student
        foreach ($schools as $school) {
            // Retrieve the students from the school for the specific form
            $students = $school->school->students()
                ->where('form_id', $form->id)
                ->with(['stream', 'school'])
                ->get();

            // Calculate the average marks for each student
            foreach ($students as $student) {
                $paper1Marks = Mark::where('student_id', $student->id)
                    ->where('exam_id', $exam->id)
                    ->where('subject_id', 1)
                    ->sum('marks');

                $paper2Marks = Mark::where('student_id', $student->id)
                    ->where('exam_id', $exam->id)
                    ->where('subject_id', 2)
                    ->sum('marks');

                // Check if both Paper 1 and Paper 2 marks exist for the student
                if ($paper1Marks > 0 && $paper2Marks > 0) {
                    // Calculate the average
                    $average = ($paper1Marks + $paper2Marks) / 2;
                    $average = round($average); // Round to 2 decimal places

                    // Determine the grade based on the grading system
                    $grade = $this->calculateGrade($average, $gradingSystem);

                    // Store the student's result properly formatted for Excel export
                    $studentMeans[] = [
                        'ADM' => $student->adm,
                        'NAME' => $student->name,
                        'GENDER' => $student->gender,
                        'SCHOOL' => $student->school->name,
                        'STRM' => $student->stream->name,
                        'PP1' => $paper1Marks,
                        'PP2' => $paper2Marks,
                        'AVG' => $average,
                        'GRD' => $grade,
                        'RNK' => null, // To be filled in later
                    ];
                }
            }
        }

        // Sort the students by average in descending order
        usort($studentMeans, function ($a, $b) {
            return $b['AVG'] - $a['AVG'];
        });

        // Initialize rank
        $rank = 1;

        // Calculate the rank while considering students with the same average marks
        foreach ($studentMeans as $key => $studentMean) {
            if ($key > 0 && $studentMean['AVG'] != $studentMeans[$key - 1]['AVG']) {
                $rank = $key + 1;
            }
            $studentMeans[$key]['RNK'] = $rank;
        }

        $filename = $exam->name . '_Form_' . $form->name . '_Term_' . $exam->term . '_' . $exam->year . '_Overall_Student_Ranking.xlsx';

        $examDetails = [
            'name' => $exam->name,
            'term' => $exam->term,
            'year' => $exam->year,
        ];

        // Generate and return the Excel file
        return Excel::download(new OverallStudentRankingExport($studentMeans, $examDetails), $filename);
    }

    public function streamRanking($id, $slug)
{
    // Retrieve the exam
    $exam = Exam::findOrFail($id);

    // Retrieve the grading system from the database
    $gradingSystem = Grading::all();

    // Retrieve the streams of all schools registered for the exam
    $examSchools = ExamSchool::where('exam_id', $exam->id)->with('school.streams')->get();

    // Initialize an array to store stream mean results
    $streamMeans = [];

    foreach ($examSchools as $examSchool) {
        $school = $examSchool->school;
        $streams = $school->streams;

        foreach ($streams as $stream) {
            $students = $stream->students;
            $gradesCount = [];

            foreach ($students as $student) {
                // Assuming you have a method to retrieve marks for both subjects for a student in the Mark model
                $subject1Marks = Mark::where('student_id', $student->id)
                    ->where('exam_id', $exam->id)
                    ->where('subject_id', 1)
                    ->sum('marks');

                $subject2Marks = Mark::where('student_id', $student->id)
                    ->where('exam_id', $exam->id)
                    ->where('subject_id', 2)
                    ->sum('marks');

                // Check if both subject marks exist for the student and if the average is greater than 0
                if ($subject1Marks !== null && $subject2Marks !== null) {
                    // Calculate the average as a whole number
                    $average = round(($subject1Marks + $subject2Marks) / 2);

                    // Determine the grade based on the grading system
                    $grade = $this->calculateGrade($average, $gradingSystem);

                    // Count the number of students in each grade category
                    if (!isset($gradesCount[$grade])) {
                        $gradesCount[$grade] = 0;
                    }
                    $gradesCount[$grade]++;
                }
            }

            // Calculate the mean for the stream based on the grading system and counts
            $streamMean = 0;
            $totalStudents = count($students);

            if ($totalStudents > 0) {
                foreach ($gradesCount as $grade => $count) {
                    $gradePoints = $gradingSystem->where('grade', $grade)->first()->points ?? 0;
                    $streamMean += ($count * $gradePoints);
                }
                $streamMean = $streamMean / $totalStudents;
                $streamMean = round($streamMean, 4); // Round to 4 decimal places

                // Add stream performance data to the results array, including the stream mean
                $streamMeans[] = [
                    'stream' => $stream,
                    'school' => $school,
                    'stream_mean' => $streamMean,
                ];
            }
        }
    }

    // Sort the $streamMeans array by 'stream_mean' in descending order
    usort($streamMeans, function ($a, $b) {
        return $b['stream_mean'] <=> $a['stream_mean'];
    });

    // Generate and return the Excel file
    $excelFileName = str_replace(' ', '_', $exam->name . '_Term_' . $exam->term . '_' . $exam->year . '_Stream_Ranking') . '.xlsx';

    return Excel::download(new StreamRankingExport($streamMeans), $excelFileName);
}

    private function calculateGrade($average, $gradingSystem)
    {
        foreach ($gradingSystem as $grade) {
            if ($average >= $grade->low && $average <= $grade->high) {
                return $grade->grade;
            }
        }

        return 'N/A';
    }

    public function mySchoolResultsExport($id, $form_id, $slug)
    {
        // Retrieve the exam
        $exam = Exam::findOrFail($id);

        // Retrieve the form (assuming you have a Form model)
        $form = Form::findOrFail($form_id);

        // Get the authenticated user's school
        $school = School::where('slug', $slug)->firstOrFail();

        // Get the students from the school who are in the specified form
        $students = $school->students->where('form_id', $form->id);

        // Initialize an array to store results with averages and grades for both subjects
        $results = [];
        $studentsWithMarksForBothSubjects = collect();

        // Calculate the average marks and assign grades for both subjects for each student
        foreach ($students as $student) {
            // Assuming you have a method to retrieve marks for both subjects for a student in the Mark model
            $subject1Marks = Mark::where('student_id', $student->id)
                ->where('exam_id', $exam->id)
                ->where('subject_id', 1)
                ->sum('marks');

            $subject2Marks = Mark::where('student_id', $student->id)
                ->where('exam_id', $exam->id)
                ->where('subject_id', 2)
                ->sum('marks');

            // Check if both subjects have marks greater than 0 for the student
            if ($subject1Marks > 0 && $subject2Marks > 0) {
                // Store students with marks in both subjects
                $studentsWithMarksForBothSubjects->push($student);

                // Calculate the average for the two subjects
                $average = round(($subject1Marks + $subject2Marks) / 2);

                // Determine the grade based on the grading system
                $grade = Grading::where('low', '<=', $average)
                    ->where('high', '>=', $average)
                    ->first();

                // Store the student's result for both subjects
                $results[] = [
                    'student' => $student,
                    'subject1Marks' => $subject1Marks,
                    'subject2Marks' => $subject2Marks,
                    'average' => $average,
                    'grade' => $grade ? $grade->grade : 'N/A',
                ];
            }
        }

        // Sort the results by average in descending order
        usort($results, function ($a, $b) {
            return $b['average'] - $a['average'];
        });

        // Calculate grade analysis for both subjects
        $analysis = [];

        // Retrieve the grading system from the database
        $gradingSystem = Grading::all();

        // Group students by stream for both subjects
        $studentsByStream = $studentsWithMarksForBothSubjects->groupBy('stream.name');

        foreach ($studentsByStream as $streamName => $streamStudents) {
            $gradesCount = [];

            // Initialize the gradesCount array with zeros
            foreach ($gradingSystem as $grade) {
                $gradesCount[$grade->grade] = 0;
            }

            $totalStudents = $streamStudents->count();

            // Calculate grades count for each grade for both subjects
            foreach ($streamStudents as $student) {
                $studentGrade = collect($results)->where('student.id', $student->id)->first()['grade'] ?? 'N/A';

                if (array_key_exists($studentGrade, $gradesCount)) {
                    $gradesCount[$studentGrade]++;
                }
            }

            // Calculate mean
            $mean = 0;
            foreach ($gradesCount as $grade => $count) {
                $gradePoints = $gradingSystem->where('grade', $grade)->first()->points ?? 0;
                $mean += ($count * $gradePoints);
            }
            $mean = ($totalStudents > 0) ? round($mean / $totalStudents, 4) : 0;

            $analysis[] = [
                'stream' => $streamName,
                'grades' => $gradesCount,
                'total' => $totalStudents,
                'mean' => $mean,
            ];
        }

        $filename = $exam->name . '_Term_' . $exam->term . '_' . $exam->year . '_mySchool.xlsx';

        return Excel::download(new MySchoolResultsExport($results, $gradingSystem, $exam, $school, $analysis), $filename);
    }










}
