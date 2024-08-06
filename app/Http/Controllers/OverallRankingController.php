<?php

namespace App\Http\Controllers;

use App\Exports\OverallStudentRankingExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Exam;
use App\Models\Grading;
use App\Models\Student;
use App\Models\Mark;

class OverallRankingController extends Controller
{
    public function exportExcel($id, $slug, $form_id)
    {
        // Retrieve the exam and grading system
        $exam = Exam::findOrFail($id);
        $gradingSystem = Grading::where('grading_system_id', $exam->grading_system_id)->get();

        // Determine the chunk size
        $chunkSize = 100; // Adjust the chunk size as needed

        $studentMeans = [];

        // Process students in chunks
        Student::where('form_id', $form_id)->chunk($chunkSize, function ($students) use ($exam, $gradingSystem, &$studentMeans) {
            $marks = Mark::where('exam_id', $exam->id)
                         ->whereIn('student_id', $students->pluck('id'))
                         ->whereIn('subject_id', [1, 2])
                         ->get();

            foreach ($students as $student) {
                $studentMarks = $marks->where('student_id', $student->id);
                $subject1Marks = $studentMarks->where('subject_id', 1)->sum('marks');
                $subject2Marks = $studentMarks->where('subject_id', 2)->sum('marks');

                if ($subject1Marks > 0 && $subject2Marks > 0) {
                    $average = round(($subject1Marks + $subject2Marks) / 2);
                    $grade = $this->calculateGrade($average, $gradingSystem);

                    $studentMeans[] = [
                        'student' => $student,
                        'subject1Marks' => $subject1Marks,
                        'subject2Marks' => $subject2Marks,
                        'average' => $average,
                        'grade' => $grade,
                    ];
                }
            }
        });

        // Sort students by their average marks
        usort($studentMeans, function ($a, $b) {
            return $b['average'] - $a['average'];
        });

        // Assign ranks to students
        $rank = 1;
        foreach ($studentMeans as $key => $studentMean) {
            if ($key > 0 && $studentMean['average'] != $studentMeans[$key - 1]['average']) {
                $rank = $key + 1;
            }
            $studentMeans[$key]['rank'] = $rank;
        }

        // Construct the dynamic file name
        $fileName = sprintf(
            '%s_%s_Term%s_Form%s_Overall_Ranking.xlsx',
            str_replace(' ', '_', $exam->name),
            $exam->year,
            $exam->term,
            $exam->form->name
        );

        return Excel::download(new OverallStudentRankingExport($exam, $studentMeans), $fileName);
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
}


