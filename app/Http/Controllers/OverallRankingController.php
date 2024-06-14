<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Mark;
use App\Models\Grading;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OverallRankingController extends Controller
{
    public function downloadOverallRankingPdf($id, $slug, $form_id)
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300');

        $exam = Exam::findOrFail($id);
        $gradingSystem = Grading::where('grading_system_id', $exam->grading_system_id)->get();
        $studentMeans = [];

        Student::where('form_id', $form_id)->chunk(100, function ($studentsChunk) use ($exam, $gradingSystem, &$studentMeans) {
            foreach ($studentsChunk as $student) {
                $subjectMarks = $this->getSubjectMarks($student->id, $exam->id);

                if ($this->hasMarksInAllSubjects($subjectMarks)) {
                    $average = $this->calculateAverage($subjectMarks);
                    $grade = $this->calculateGrade($average, $gradingSystem);

                    $studentMeans[] = [
                        'student' => $student,
                        'subjectMarks' => $subjectMarks,
                        'average' => $average,
                        'grade' => $grade,
                    ];
                }
            }
        });

        $studentMeans = $this->rankStudents($studentMeans);

        $pdf = Pdf::loadView('backend.downloads.overall_ranking', [
            'exam' => $exam,
            'studentMeans' => $studentMeans,
            'gradingSystem' => $gradingSystem,
            'subjectNames' => ['PP1', 'PP2'], // Replace with dynamic subjects if needed
        ]);

        $filename = $this->generateFilename($exam, $form_id);

        return $pdf->download($filename);
    }

    private function getSubjectMarks($studentId, $examId)
    {
        $subjectIds = [1, 2]; // Replace with dynamic subject IDs if needed
        $subjectMarks = [];

        foreach ($subjectIds as $subjectId) {
            $subjectMarks[$subjectId] = Mark::where('student_id', $studentId)
                ->where('exam_id', $examId)
                ->where('subject_id', $subjectId)
                ->sum('marks');
        }

        return $subjectMarks;
    }

    private function hasMarksInAllSubjects($subjectMarks)
    {
        foreach ($subjectMarks as $marks) {
            if ($marks <= 0) {
                return false;
            }
        }
        return true;
    }

    private function calculateAverage($subjectMarks)
    {
        return round(array_sum($subjectMarks) / count($subjectMarks));
    }

    private function calculateGrade($average, $gradingSystem)
    {
        foreach ($gradingSystem as $grade) {
            if ($average >= $grade->low && $average <= $grade->high) {
                return $grade->grade;
            }
        }
        return 'N/A'; // If grade not found
    }

    private function rankStudents($studentMeans)
    {
        usort($studentMeans, function ($a, $b) {
            return $b['average'] - $a['average'];
        });

        $rank = 1;
        foreach ($studentMeans as $key => $studentMean) {
            if ($key > 0 && $studentMean['average'] != $studentMeans[$key - 1]['average']) {
                $rank = $key + 1;
            }
            $studentMeans[$key]['rank'] = $rank;
        }

        return $studentMeans;
    }

    private function generateFilename($exam, $formId)
    {
        return str_replace(' ', '_', $exam->name) . '_Form_' . $formId . '_Overall_Student_Ranking.pdf';
    }
}
