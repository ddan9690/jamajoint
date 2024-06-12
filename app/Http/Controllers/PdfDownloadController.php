<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamSchool;
use App\Models\Form;
use App\Models\Grading;
use App\Models\Invoice;
use App\Models\Mark;
use App\Models\School;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PdfDownloadController extends Controller
{

    public function downloadStudentResultsPdf($id, $form_id, $slug)
    {
        // Retrieve the exam
        $exam = Exam::findOrFail($id);

        // Get the authenticated user's school
        $school = School::where('slug', $slug)->firstOrFail();

        // Get the students from the school for the specified form
        $students = $school->students->where('form_id', $form_id);

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

        // Generate the PDF view for student results
        $pdf = PDF::loadView('backend.downloads.student_results', [
            'exam' => $exam,
            'school' => $school,
            'results' => $results,
            'gradingSystem' => $gradingSystem,
        ]);

        // Create a custom filename for the student results PDF
        $filename = str_replace(' ', '_', $exam->name) . '_' . $school->name . '_Form_' . $form_id . '_Student_Results.pdf';

        // Download the student results PDF with the custom filename
        return $pdf->download($filename);
    }

    public function downloadGradeAnalysisPdf($id, $form_id, $slug)
    {
        // Retrieve the exam
        $exam = Exam::findOrFail($id);

        // Get the authenticated user's school
        $school = School::where('slug', $slug)->firstOrFail();

        // Get the grading system ID associated with the exam
        $gradingSystemId = $exam->grading_system_id;

        // Retrieve the grading system associated with the exam
        $gradingSystem = Grading::where('grading_system_id', $gradingSystemId)->get();

        // Get the students from the school for the specified form
        $students = $school->students->where('form_id', $form_id);

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

            // Store the student's result for both subjects
            $results[] = [
                'student' => $student,
                'subject1Marks' => $subject1Marks,
                'subject2Marks' => $subject2Marks,
                'average' => $average,
                'grade' => $grade,
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

            // Add data to analysis array for both subjects
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

        // Generate the PDF view for grade analysis
        $pdf = PDF::loadView('backend.downloads.grade_analysis', [
            'school' => $school,
            'gradingSystem' => $gradingSystem,
            'analysis' => $analysis,
        ]);

        // Create a custom filename for the grade analysis PDF
        $filename = str_replace(' ', '_', $school->name) . '_Form_' . $form_id . '_Grade_Analysis.pdf';

        // Download the grade analysis PDF with the custom filename
        return $pdf->download($filename);
    }

    protected function calculateGrade($average, $gradingSystem)
    {
        foreach ($gradingSystem as $grade) {
            if ($average >= $grade->low && $average <= $grade->high) {
                return $grade->grade;
            }
        }

        return 'N/A'; // Return 'N/A' if no matching grade is found
    }

    public function topPerformancesPdf($id, $form_id, $slug)
    {
        // Retrieve the exam
        $exam = Exam::findOrFail($id);

        // Retrieve the form
        $form = Form::findOrFail($form_id);

        // Retrieve all schools registered for the exam
        $schools = ExamSchool::where('exam_id', $exam->id)->with('school')->get();

        // Retrieve the grading system for the exam
        $gradingSystem = Grading::where('grading_system_id', $exam->grading_system_id)->get();

        // Initialize arrays to store top-performing boys and girls
        $topBoys = [];
        $topGirls = [];

        // Calculate the mean for each student from the specified form
        foreach ($schools as $school) {
            // Retrieve the students from the school
            $students = $school->school->students;

            // Filter students from the specified form
            $formStudents = $students->where('form_id', $form_id);

            // Calculate the average marks for each student
            foreach ($formStudents as $student) {
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

        // Load the PDF view with the results and grading system
        $data = compact('exam', 'topBoys', 'topGirls', 'gradingSystem');
        $pdf = PDF::loadView('backend.downloads.top_performances', $data);

        // Name the PDF file based on the exam details
        $pdfFileName = str_replace(' ', '_', $exam->name . '_Term_' . $exam->term . '_' . $exam->year . '_Top_Performances') . '.pdf';

        // Return the PDF for download
        return $pdf->stream($pdfFileName);
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

    public function streamRanking($id, $slug)
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
            $streams = $school->streams->where('form_id', $exam->form_id);

            foreach ($streams as $stream) {
                $students = $stream->students;
                $gradesCount = [];
                $rankedStudentsCount = 0; // Initialize the count of ranked students

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
                        // Calculate the average for the two papers
                        $average = round(($paper1Marks + $paper2Marks) / 2);

                        // Determine the grade based on the grading system
                        $grade = $this->calculateGrade($average, $gradingSystem);

                        // Count the number of students in each grade category
                        if (!isset($gradesCount[$grade])) {
                            $gradesCount[$grade] = 0;
                        }
                        $gradesCount[$grade]++;

                        $rankedStudentsCount++; // Increment the count of ranked students
                    }
                }

                // Calculate the mean for the stream based on the grading system and counts
                $streamMean = 0;
                $totalStudents = count($students);

                if ($rankedStudentsCount > 0) {
                    foreach ($gradesCount as $grade => $count) {
                        $gradePoints = $gradingSystem->where('grade', $grade)->first()->points ?? 0;
                        $streamMean += ($count * $gradePoints);
                    }
                    $streamMean = $streamMean / $rankedStudentsCount;
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

        // Load the view with the stream ranking results
        $data = compact('exam', 'streamMeans');
        $pdf = PDF::loadView('backend.downloads.stream_ranking', $data);

        // Name the PDF file based on the exam details
        $pdfFileName = str_replace(' ', '_', $exam->name . '_Term_' . $exam->term . '_' . $exam->year . '_Stream_Ranking') . '.pdf';

        // Return the PDF for download
        return $pdf->stream($pdfFileName);
    }


    public function downloadInvoice(Request $request, $id)
    {
        // Retrieve the invoice by its ID
        $invoice = Invoice::findOrFail($id);

        // Generate the invoice PDF
        $data = compact('invoice');
        $pdf = PDF::loadView('backend.downloads.invoice', $data);

        // Define the PDF file name based on the invoice number
        $pdfFileName = $invoice->invoice_number . '.pdf';

        // Return the PDF for download
        return $pdf->stream($pdfFileName);
    }

    public function schoolRankingPdf($id, $slug)
    {
        // Retrieve the exam
        $exam = Exam::findOrFail($id);

        // Retrieve the grading system associated with the exam
        $gradingSystem = Grading::where('grading_system_id', $exam->grading_system_id)->get();

        // Retrieve all schools registered for the exam
        $examSchools = ExamSchool::where('exam_id', $exam->id)->with('school')->get();

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

                // Add school performance data to the results array, including the school mean
                $schoolMeans[] = [
                    'school' => $school,
                    'school_mean' => $schoolMean,
                    'total_ranked_students' => $totalStudents,
                ];
            }
        }

        // Sort the $schoolMeans array by 'school_mean' in descending order
        usort($schoolMeans, function ($a, $b) {
            return $b['school_mean'] <=> $a['school_mean'];
        });

        // Generate the PDF view for school ranking
        $pdf = PDF::loadView('backend.downloads.school_ranking', compact('exam', 'schoolMeans'));

        // Name the PDF file based on the exam details
        $pdfFileName = str_replace(' ', '_', $exam->name . '_Term_' . $exam->term . '_' . $exam->year . '_School_Ranking') . '.pdf';

        // Return the PDF for download with inline display
        return $pdf->download($pdfFileName);
    }



    public function downloadPaper1Pdf($exam_id, $form_id, $slug)
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

        // Calculate the average marks and assign grades for Paper 1 for each filtered student
        $results = [];

        foreach ($filteredStudents as $student) {
            $paper1Marks = Mark::where('student_id', $student->id)
                ->where('exam_id', $exam->id)
                ->where('subject_id', 1)
                ->sum('marks');

            // Retrieve the grading system for the exam
            $gradingSystem = Grading::where('grading_system_id', $exam->grading_system_id)->get();

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
            // Retrieve the grading system for the exam
            $gradingSystem = Grading::where('grading_system_id', $exam->grading_system_id)->get();

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

        // Generate PDF
        $pdf = PDF::loadView('backend.downloads.paper1', compact('exam', 'school', 'results', 'gradingSystem', 'analysis', 'overallGradesCount', 'overallTotalStudents', 'overallMean', 'form'));
        $fileName = strtolower(str_replace(' ', '_', $exam->name . '_' . $exam->term . '_' . $exam->year) . '.pdf');

        return $pdf->download($fileName);
    }



    public function downloadPaper2Pdf($exam_id, $form_id, $slug)
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

    // Calculate the average marks and assign grades for Paper 2 for each filtered student
    $results = [];

    foreach ($filteredStudents as $student) {
        $paper2Marks = Mark::where('student_id', $student->id)
            ->where('exam_id', $exam->id)
            ->where('subject_id', 2)
            ->sum('marks');

        // Retrieve the grading system for the exam
        $gradingSystem = Grading::where('grading_system_id', $exam->grading_system_id)->get();

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
        // Retrieve the grading system for the exam
        $gradingSystem = Grading::where('grading_system_id', $exam->grading_system_id)->get();

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

    // Generate PDF
    $pdf = PDF::loadView('backend.downloads.paper2', compact('exam', 'school', 'results', 'gradingSystem', 'analysis', 'overallGradesCount', 'overallTotalStudents', 'overallMean', 'form'));
    $fileName = strtolower(str_replace(' ', '_', $exam->name . '_' . $exam->term . '_' . $exam->year) . '.pdf');

    return $pdf->download($fileName);
}






}
