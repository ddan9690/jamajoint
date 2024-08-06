<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Grading;
use App\Models\Student;
use App\Jobs\GenerateOverallRankingPDF; // Import the job class
use Barryvdh\DomPDF\Facade as PDF;

class OverallRankingPDFContoller extends Controller
{
    public function exportPDF($id, $slug, $form_id)
    {
        // Retrieve the exam
        $exam = Exam::findOrFail($id);

        // Retrieve the grading system associated with the exam
        $gradingSystem = Grading::where('grading_system_id', $exam->grading_system_id)->get();

        // Dispatch the job to generate the PDF asynchronously
        GenerateOverallRankingPDF::dispatch($exam, $form_id, $gradingSystem);

        // Redirect or respond with a success message indicating the PDF generation has started
        return redirect()->back()->with('message', 'PDF generation has started. Check your email shortly.');
    }
}
