<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Grading;
use App\Models\Student;
use App\Models\Mark;
use Barryvdh\DomPDF\Facade\Pdf;


class OverallRankingPDFContoller extends Controller
{
    public function exportPDF($id, $slug, $form_id)
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

        // Generate the PDF view for overall student ranking
        $pdf = PDF::loadView('backend.downloads.overall_student_ranking', compact('exam', 'studentMeans', 'gradingSystem'));

        // Name the PDF file based on the exam details
        $pdfFileName = str_replace(' ', '_', $exam->name . '_Form_' . $exam->form->name . '_Term_' . $exam->term . '_' . $exam->year . '_Overall_Student_Ranking') . '.pdf';

        // Return the PDF for download with inline display
        return $pdf->download($pdfFileName);
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
