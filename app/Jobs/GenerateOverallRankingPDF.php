<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Exam;
use App\Models\Grading;
use App\Models\Student;
use App\Models\Mark;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Storage;

class GenerateOverallRankingPDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $exam;
    protected $form_id;
    protected $gradingSystem;
    protected $pdfFilePath;

    /**
     * Create a new job instance.
     *
     * @param Exam $exam
     * @param int $form_id
     * @param Grading $gradingSystem
     * @return void
     */
    public function __construct(Exam $exam, $form_id, $gradingSystem)
    {
        $this->exam = $exam;
        $this->form_id = $form_id;
        $this->gradingSystem = $gradingSystem;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Retrieve students for the specified form
        $students = Student::where('form_id', $this->form_id)->get();

        // Initialize array to store student means
        $studentMeans = [];

        // Iterate through students
        foreach ($students as $student) {
            // Filter students to include only those with marks in both subjects for the specified exam
            $subject1Marks = Mark::where('student_id', $student->id)
                ->where('exam_id', $this->exam->id)
                ->where('subject_id', 1)
                ->sum('marks');

            $subject2Marks = Mark::where('student_id', $student->id)
                ->where('exam_id', $this->exam->id)
                ->where('subject_id', 2)
                ->sum('marks');

            // Check if both subject marks are greater than 0
            if ($subject1Marks > 0 && $subject2Marks > 0) {
                // Calculate the average
                $average = round(($subject1Marks + $subject2Marks) / 2);

                // Determine the grade based on the grading system
                $grade = $this->calculateGrade($average, $this->gradingSystem);

                // Add student data to the array
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
        foreach ($studentMeans as $key => &$studentMean) {
            if ($key > 0 && $studentMean['average'] == $studentMeans[$key - 1]['average']) {
                $studentMean['rank'] = $rank;
            } else {
                $rank = $key + 1;
                $studentMean['rank'] = $rank;
            }
        }

        // Generate the PDF view for overall student ranking
        $pdf = PDF::loadView('backend.downloads.overall_student_ranking', compact('exam', 'studentMeans', 'gradingSystem'));

        // Name the PDF file based on the exam details
        $pdfFileName = str_replace(' ', '_', $this->exam->name . '_Form_' . $this->exam->form->name . '_Term_' . $this->exam->term . '_' . $this->exam->year . '_Overall_Student_Ranking') . '.pdf';

        // Save the PDF to storage
        $this->pdfFilePath = 'public/' . $pdfFileName;
        Storage::put($this->pdfFilePath, $pdf->output());
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

    /**
     * Get the path to the PDF file.
     *
     * @return string
     */
    public function getPDFFilePath()
    {
        return $this->pdfFilePath;
    }
}
