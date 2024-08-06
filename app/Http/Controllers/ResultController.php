<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamSchool;
use App\Models\Grading;
use App\Models\Mark;
use App\Models\School;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
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

        // Get the grading system ID associated with the exam
        $gradingSystemId = $exam->grading_system_id;

        // Retrieve the grading system associated with the exam
        $gradingSystem = Grading::where('grading_system_id', $gradingSystemId)->get();

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
            $grade = $gradingSystem->where('low', '<=', $average)
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

        // Retrieve the grading system for the exam
        $gradingSystem = Grading::where('grading_system_id', $exam->grading_system_id)->get();

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

        // Render the view with the results
        return view('backend.results.top_performances', compact('exam', 'topBoys', 'topGirls', 'gradingSystem'));
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

        // Retrieve the grading system associated with the exam
        $gradingSystem = Grading::where('grading_system_id', $exam->grading_system_id)->get();

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

                    // Determine the grade based on the grading system associated with the exam
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
        // Retrieve the exam
        $exam = Exam::findOrFail($exam_id);

        // Retrieve the form associated with the exam
        $form = $exam->form;

        // Get the authenticated user's school
        $school = Auth::user()->school;

        // Retrieve the grading system for the exam
        $gradingSystem = Grading::where('grading_system_id', $exam->grading_system_id)->get();

        // Get subject 1 marks for students in the same form as the exam
        $subject1Marks = Mark::where('exam_id', $exam_id)
            ->where('subject_id', 1)
            ->whereIn('student_id', function($query) use ($form) {
                $query->select('id')->from('students')->where('form_id', $form->id);
            })
            ->get();

        // Initialize arrays to store subject 1 analysis data
        $subject1AnalysisData = [];

        // Filter students to include only those with marks in subject 1
        $filteredStudents = $subject1Marks->pluck('student_id')->unique();

        // Calculate average marks and determine grade for each student
        foreach ($filteredStudents as $student_id) {
            // Fetch marks for the student
            $studentMarks = $subject1Marks->where('student_id', $student_id);

            // Calculate average for subject 1
            $average = $studentMarks->avg('marks');

            // Determine the grade based on the grading system
            $grade = $this->calculateGrade($average, $gradingSystem);

            // Store the analysis data
            $subject1AnalysisData[] = [
                'student' => Student::findOrFail($student_id),
                'average' => $average,
                'grade' => $grade,
            ];
        }

        // Sort the analysis data by average in descending order
        usort($subject1AnalysisData, function ($a, $b) {
            return $b['average'] - $a['average'];
        });

        // Pass the subject 1 analysis data and exam details to the view
        return view('backend.results.subject1_analysis', compact('exam', 'school', 'subject1AnalysisData', 'gradingSystem'));
    }


    public function schoolRanking($id, $slug)
    {
        // Retrieve the exam
        $exam = Exam::findOrFail($id);

        // Retrieve the grading system associated with the exam
        $gradingSystem = Grading::where('grading_system_id', $exam->grading_system_id)->get();

        // Retrieve all schools that participated in the exam
        $examSchools = ExamSchool::where('exam_id', $exam->id)->get();
        // dd($examSchools);
        // Initialize an array to store school mean results
        $schoolMeans = [];

        foreach ($examSchools as $examSchool) {
            $school = $examSchool->school;

            // Filter students of the specific form for this exam
            $students = $school->students->where('form_id', $exam->form_id);

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

                // Determine the grade based on the grading system associated with the exam
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
        return view('backend.results.overall_student_ranking', compact('exam', 'studentMeans', 'gradingSystem'));
    }



// Helper method to calculate the grade based on the average and grading system
    private function calculateGrade($average, $gradingSystem)
    {
        foreach ($gradingSystem as $grade) {
            if ($average >= $grade->low && $average <= $grade->high) {
                return $grade->grade;
            }
        }
        return 'N/A'; // If grade not found
    }

}
