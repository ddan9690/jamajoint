<?php

namespace App\Http\Controllers;

use App\Exports\MySchoolResultsExport;
use App\Exports\OverallStudentRankingExport;
use App\Exports\StreamRankingExport;
use App\Models\Exam;
use App\Models\ExamSchool;
use App\Models\Form;
use App\Models\Grading;
use App\Models\Mark;
use App\Models\School;
use App\Models\Student;
use Maatwebsite\Excel\Facades\Excel;

class ExcelDownloadController extends Controller
{
    public function overallStudentRanking($id, $slug, $form_id)
    {
        // Retrieve the exam
        $exam = Exam::findOrFail($id);

        // Retrieve the grading system associated with the exam
        $gradingSystem = Grading::where('grading_system_id', $exam->grading_system_id)->get();

        // Retrieve all students from the specified form
        $students = Student::where('form_id', $form_id)->get();

        // Initialize an array to store student mean results
        $studentMeans = [];

        // Calculate the mean for each student
        foreach ($students as $student) {
            // Filter students to include only those with marks in both subjects for the specified exam
            $subject1Marks = Mark::where('student_id', $student->id)
                ->where('exam_id', $exam->id)
                ->where('subject_id', 1)
                ->sum('marks');

            $subject2Marks = Mark::where('student_id', $student->id)
                ->where('exam_id', $exam->id)
                ->where('subject_id', 2)
                ->sum('marks');

            // Check if both subject marks are greater than 0
            if ($subject1Marks > 0 && $subject2Marks > 0) {
                // Calculate the average
                $average = round(($subject1Marks + $subject2Marks) / 2);

                // Determine the grade based on the grading system
                $grade = $this->calculateGrade($average, $gradingSystem);

                // Store the student's result including subject-wise marks
                $studentMeans[] = [
                    'ADM' => $student->adm,
                    'NAME' => $student->name,
                    'GENDER' => $student->gender,
                    'SCHOOL' => $student->school->name,
                    'STRM' => $student->stream->name,
                    'PP1' => $subject1Marks,
                    'PP2' => $subject2Marks,
                    'AVG' => $average,
                    'GRD' => $grade,
                    'RNK' => null, // We'll calculate rank later
                ];
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

        // Generate Excel file
        $filename = $exam->name . '_Overall_Student_Ranking.xlsx';
        return Excel::download(new OverallStudentRankingExport($studentMeans, [
            'name' => $exam->name,
            'term' => $exam->term,
            'year' => $exam->year
        ]), $filename);
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

        // Retrieve the grading system associated with the exam
        $gradingSystem = Grading::where('grading_system_id', $exam->grading_system_id)->get();

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
                $grade = $this->calculateGrade($average, $gradingSystem);

                // Store the student's result for both subjects
                $results[] = [
                    'student' => $student,
                    'subject1Marks' => $subject1Marks,
                    'subject2Marks' => $subject2Marks,
                    'average' => $average,
                    'grade' => $grade,
                ];
            }
        }

        // Sort the results by average in descending order
        usort($results, function ($a, $b) {
            return $b['average'] - $a['average'];
        });

        // Calculate grade analysis for both subjects
        $analysis = [];

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
