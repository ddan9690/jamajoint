<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Stream;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MarksheetController extends Controller
{
    public function generate($schoolId, $slug)
    {
        // Retrieve the school by its ID
        $school = School::findOrFail($schoolId);

        // Get the streams and students grouped by stream, ordered by admission number
        $streams = Stream::where('school_id', $schoolId)->with(['students' => function ($query) {
            $query->orderBy('adm', 'asc');
        }])->get();

        // Generate the PDF view
        $pdf = PDF::loadView('backend.downloads.marksheet', compact('school', 'streams'));

        // Create a custom filename for the marksheet PDF
        $filename = str_replace(' ', '_', $school->name) . '.pdf';

        // Download the marksheet PDF with the custom filename
        return $pdf->download($filename);
    }
}

