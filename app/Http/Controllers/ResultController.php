<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Mark;
use App\Models\School;
use App\Models\Stream;
use App\Models\Grading;
use App\Models\Student;
use App\Models\Subject;
use App\Models\ExamSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    // Display the index page for results
    public function index($id, $slug)
    {
        // Find the exam based on the provided ID
        $exam = Exam::findOrFail($id);

        // Return the 'backend.results.index' view and pass the 'exam' variable to it
        return view('backend.results.index', compact('exam'));
    }

   public function mySchoolResults($exam_id, $form_id, $slug)
{
    // Retrieve the exam
    $exam = Exam::findOrFail($exam_id);

    // Retrieve the form associated with the exam
    $form = $exam->form; // Assuming there's a relationship in your Exam model

    // Get the authenticated user's school
    $school = Auth::user()->school;

    // Get the students from the school who are in the same form
    $students = $school->students->where('form_id', $form->id);

    // Initialize an array to store results with averages and grades for both subjects
    $results = [];

    // Filter students to include only those with marks in both subjects
    $filteredStudents = $students->filter(function ($student) use ($exam) {
        $subject1Marks = Mark::where('student_id', $student->id)
            ->where('exam_id', $exam->id)
            ->where('subject_id', 1)
            ->sum('marks');

        $subject2Marks = Mark::where('student_id', $student->id)
            ->where('exam_id', $exam->id)
            ->where('subject_id', 2)
            ->sum('marks');

        // Check if both subject marks are greater than 0
        return $subject1Marks > 0 && $subject2Marks > 0;
    });

    // Calculate the average marks and assign grades for both subjects for each filtered student
    foreach ($filteredStudents as $student) {
        // Assuming you have a method to retrieve marks for both subjects for a student in the Mark model
        $subject1Marks = Mark::where('student_id', $student->id)
            ->where('exam_id', $exam->id)
            ->where('subject_id', 1)
            ->sum('marks');

        $subject2Marks = Mark::where('student_id', $student->id)
            ->where('exam_id', $exam->id)
            ->where('subject_id', 2)
            ->sum('marks');

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

    // Sort the results by average in descending order
    usort($results, function ($a, $b) {
        return $b['average'] - $a['average'];
    });

    // Calculate grade analysis for both subjects
    $analysis = [];

    // Retrieve the grading system from the database
    $gradingSystem = Grading::all();

    // Group students by stream for both subjects
    $studentsByStream = $filteredStudents->groupBy('stream.name');

    foreach ($studentsByStream as $streamName => $streamStudents) {
        $gradesCount = [];

        // Initialize the gradesCount array with zeros
        foreach ($gradingSystem as $grade) {
            $gradesCount[$grade->grade] = 0;
        }

        $totalStudents = $streamStudents->count();

        // Calculate grades count for each grade for both subjects
        foreach ($streamStudents as $student) {
            $studentResult = collect($results)->where('student.id', $student->id)->first();

            if ($studentResult) {
                $studentGrade = $studentResult['grade'];
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

        // Add data to the analysis array for both subjects
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

    // Load the view with the results, gradingSystem, and analysis for both subjects
    return view('backend.results.my_school_results', compact('exam', 'school', 'results', 'gradingSystem', 'analysis'));
}


public function overallStudentRanking($id, $slug, $form_id)
{
    // Retrieve the exam
    $exam = Exam::findOrFail($id);

    // Retrieve all schools registered for the exam
    $schools = ExamSchool::where('exam_id', $exam->id)->with('school')->get();

    // Retrieve the grading system from the database
    $gradingSystem = Grading::all();

    // Initialize an array to store student mean results
    $studentMeans = [];

    // Calculate the mean for each student
    foreach ($schools as $school) {
        // Retrieve the students from the school and filter by the form ID
        $students = $school->school->students->where('form_id', $form_id);

        // Filter students to include only those with marks in both subjects
        $filteredStudents = $students->filter(function ($student) use ($exam) {
            $subject1Marks = Mark::where('student_id', $student->id)
                ->where('exam_id', $exam->id)
                ->where('subject_id', 1)
                ->sum('marks');

            $subject2Marks = Mark::where('student_id', $student->id)
                ->where('exam_id', $exam->id)
                ->where('subject_id', 2)
                ->sum('marks');

            // Check if both subject marks are greater than 0
            return $subject1Marks > 0 && $subject2Marks > 0;
        });

        // Calculate the average marks for each student
        foreach ($filteredStudents as $student) {
            $subject1Marks = Mark::where('student_id', $student->id)
                ->where('exam_id', $exam->id)
                ->where('subject_id', 1)
                ->sum('marks');

            $subject2Marks = Mark::where('student_id', $student->id)
                ->where('exam_id', $exam->id)
                ->where('subject_id', 2)
                ->sum('marks');

            // Calculate the average
            $average = round(($subject1Marks + $subject2Marks) / 2);

            // Determine the grade based on the grading system
            $grade = $this->calculateGrade($average, $gradingSystem);

            // Store the student's result including subject-wise marks
            $studentMeans[] = [
                'student' => $student,
                'subject1Marks' => $subject1Marks,
                'subject2Marks' => $subject2Marks,
                'average' => $average,
                'grade' => $grade,
            ];
        }
    }

    // Sort the students by average in descending order
    usort($studentMeans, function ($a, $b) {
        return $b['average'] - $a['average'];
    });

    // Initialize rank
    $rank = 1;

    // Calculate the rank while considering students with the same average marks
    foreach ($studentMeans as $key => $studentMean) {
        if ($key > 0 && $studentMean['average'] != $studentMeans[$key - 1]['average']) {
            $rank = $key + 1;
        }
        $studentMeans[$key]['rank'] = $rank;
    }

    // Load the view with the results, gradingSystem, and analysis
    return view('backend.results.overall_student_ranking', compact('exam', 'studentMeans'));
}




public function topPerformances($id, $form_id, $slug)
{
    // Retrieve the exam
    $exam = Exam::findOrFail($id);

    // Check if the requested form ID matches the exam's form ID
    if ($exam->form_id != $form_id) {
        // Redirect or handle the case where the form ID doesn't match
        // For example, you can redirect to an error page or return an error response.
        return redirect()->route('error'); // Adjust as needed
    }

    // Retrieve all schools registered for the exam
    $schools = ExamSchool::where('exam_id', $exam->id)->with('school')->get();

    // Retrieve the grading system from the database
    $gradingSystem = Grading::all();

    // Initialize arrays to store top-performing boys and girls
    $topBoys = [];
    $topGirls = [];

    // Calculate the mean for each student
    foreach ($schools as $school) {
        // Retrieve the students from the school
        $students = $school->school->students;

        // Calculate the average marks for each student
        foreach ($students as $student) {
            // Check if the student belongs to the same form as the exam
            if ($student->form_id === $exam->form_id) {
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
                    // Calculate the average
                    $average = ($subject1Marks + $subject2Marks) / 2;
                    $average = round($average); // Round to 2 decimal places

                    // Determine the grade based on the grading system
                    $grade = $this->calculateGrade($average, $gradingSystem);

                    // Store the student's result including subject-wise marks
                    $studentData = [
                        'student' => $student,
                        'subject1Marks' => $subject1Marks,
                        'subject2Marks' => $subject2Marks,
                        'average' => $average,
                        'grade' => $grade,
                    ];

                    // Check the gender of the student and add them to the respective array
                    if ($student->gender === 'M') {
                        $topBoys[] = $studentData;
                    } elseif ($student->gender === 'F') {
                        $topGirls[] = $studentData;
                    }
                }
            }
        }
    }

    // Sort the arrays by average in descending order
    usort($topBoys, function ($a, $b) {
        return $b['average'] - $a['average'];
    });

    usort($topGirls, function ($a, $b) {
        return $b['average'] - $a['average'];
    });

    // Retrieve the top 10 performers for boys and girls while handling ties
    $topBoys = $this->getTopPerformersWithTies($topBoys, 10);
    $topGirls = $this->getTopPerformersWithTies($topGirls, 10);

    // Load the view with the results
    return view('backend.results.top_performances', compact('exam', 'topBoys', 'topGirls'));
}



    private function getTopPerformersWithTies($students, $limit)
    {
        $result = [];

        // Initialize variables to keep track of ties
        $currentAverage = null;
        $currentRank = 0;
        $currentCount = 0;

        foreach ($students as $student) {
            // Check if the current student's average is the same as the previous student
            if ($student['average'] === $currentAverage) {
                // If it's a tie, increment the tie count and add the student to the result
                $currentCount++;
            } else {
                // If it's not a tie, update the current rank and reset the tie count
                $currentRank += $currentCount + 1;
                $currentCount = 0;
            }

            // Update the current average
            $currentAverage = $student['average'];

            // If the current rank is less than the limit, add the student to the result
            if ($currentRank < $limit) {
                $result[] = $student;
            }
        }

        return $result;
    }


    public function streamRanking($id, $form_id, $slug)
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
            // Filter students by the form for which the exam belongs
            $students = $stream->students->where('form_id', $form_id);

            // Filter students to include only those with marks in both subjects
            $filteredStudents = $students->filter(function ($student) use ($exam) {
                $subject1Marks = Mark::where('student_id', $student->id)
                    ->where('exam_id', $exam->id)
                    ->where('subject_id', 1)
                    ->sum('marks');

                $subject2Marks = Mark::where('student_id', $student->id)
                    ->where('exam_id', $exam->id)
                    ->where('subject_id', 2)
                    ->sum('marks');

                // Check if both subject marks are greater than 0
                return $subject1Marks > 0 && $subject2Marks > 0;
            });

            $gradesCount = [];

            foreach ($filteredStudents as $student) {
                $subject1Marks = Mark::where('student_id', $student->id)
                    ->where('exam_id', $exam->id)
                    ->where('subject_id', 1)
                    ->sum('marks');

                $subject2Marks = Mark::where('student_id', $student->id)
                    ->where('exam_id', $exam->id)
                    ->where('subject_id', 2)
                    ->sum('marks');

                // Calculate the average for the two subjects
                $average = round(($subject1Marks + $subject2Marks) / 2);

                // Determine the grade based on the grading system
                $grade = $this->calculateGrade($average, $gradingSystem);

                // Count the number of students in each grade category
                if (!isset($gradesCount[$grade])) {
                    $gradesCount[$grade] = 0;
                }
                $gradesCount[$grade]++;
            }

            // Calculate the mean for the stream based on the grading system and counts
            $streamMean = 0;
            $totalStudents = count($filteredStudents);

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

    // Load the view with the results, exam, and sorted $streamMeans array
    return view('backend.results.stream_ranking', compact('exam', 'streamMeans'));
}


    public function subject1Analysis($exam_id)
    {
        // Fetch data or calculations for subject 1 analysis
        // For example:
        $exam = Exam::find($exam_id);
        // $subject1AnalysisData = ...; // Get the analysis data for subject 1

        return view('backend.results.paper1.index', compact('exam'));
    }

    public function schoolRanking($id, $slug)
{
    // Retrieve the exam
    $exam = Exam::findOrFail($id);

    // Retrieve the grading system from the database
    $gradingSystem = Grading::all();

    // Retrieve all schools that participated in the exam
    $examSchools = ExamSchool::where('exam_id', $exam->id)->get();

    // Get the form ID of the exam
    $examFormId = $exam->form_id;

    // Initialize an array to store school mean results
    $schoolMeans = [];

    foreach ($examSchools as $examSchool) {
        $school = $examSchool->school;

        // Filter students of the specific form for this exam
        $students = $school->students->where('form_id', $examFormId);

        // Filter students to include only those with marks in both subjects
        $filteredStudents = $students->filter(function ($student) use ($exam) {
            $subject1Marks = Mark::where('student_id', $student->id)
                ->where('exam_id', $exam->id)
                ->where('subject_id', 1)
                ->sum('marks');

            $subject2Marks = Mark::where('student_id', $student->id)
                ->where('exam_id', $exam->id)
                ->where('subject_id', 2)
                ->sum('marks');

            // Check if both subject marks are greater than 0
            return $subject1Marks > 0 && $subject2Marks > 0;
        });

        $gradesCount = [];
        $rankedStudentsCount = 0; // Initialize the count of ranked students

        foreach ($filteredStudents as $student) {
            $subject1Marks = Mark::where('student_id', $student->id)
                ->where('exam_id', $exam->id)
                ->where('subject_id', 1)
                ->sum('marks');

            $subject2Marks = Mark::where('student_id', $student->id)
                ->where('exam_id', $exam->id)
                ->where('subject_id', 2)
                ->sum('marks');

            // Calculate the average for the two subjects
            $average = round(($subject1Marks + $subject2Marks) / 2);

            // Determine the grade based on the grading system
            $grade = $this->calculateGrade($average, $gradingSystem);

            // Count the number of students in each grade category
            if (!isset($gradesCount[$grade])) {
                $gradesCount[$grade] = 0;
            }
            $gradesCount[$grade]++;

            $rankedStudentsCount++; // Increment the count of ranked students
        }

        // Calculate the mean for the school based on the grading system and counts
        $schoolMean = 0;
        $totalStudents = count($filteredStudents);

        if ($rankedStudentsCount > 0) {
            foreach ($gradesCount as $grade => $count) {
                $gradePoints = $gradingSystem->where('grade', $grade)->first()->points ?? 0;
                $schoolMean += ($count * $gradePoints);
            }
            $schoolMean = $schoolMean / $rankedStudentsCount; // Calculate mean based on ranked students
            $schoolMean = round($schoolMean, 4); // Round to 4 decimal places

            // Add school performance data to the results array, including the school mean and the count of ranked students
            $schoolMeans[] = [
                'school' => $school,
                'school_mean' => $schoolMean,
                'ranked_students_count' => $rankedStudentsCount,
            ];
        }
    }

    // Sort the $schoolMeans array by 'school_mean' in descending order
    usort($schoolMeans, function ($a, $b) {
        return $b['school_mean'] <=> $a['school_mean'];
    });

    // Load the view with the results, exam, and sorted $schoolMeans array
    return view('backend.results.school_ranking', compact('exam', 'schoolMeans'));
}


    private function calculateGrade($average, $gradingSystem)
    {
        $grade = $gradingSystem->where('low', '<=', $average)
            ->where('high', '>=', $average)
            ->first();

        return $grade ? $grade->grade : 'N/A';
    }


}
