<?php

namespace App\Exports;

use App\Models\Exam;
use App\Models\Grading;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OverallStudentRankingExport implements FromCollection, WithHeadings, WithMapping
{
    protected $exam;
    protected $gradingSystem;
    protected $studentMeans;

    public function __construct(Exam $exam, $gradingSystem, $studentMeans)
    {
        $this->exam = $exam;
        $this->gradingSystem = $gradingSystem;
        $this->studentMeans = $studentMeans;
    }

    public function collection()
    {
        return collect($this->studentMeans);
    }

    public function headings(): array
    {
        return [
            '#', 'ADM', 'NAME', 'GENDER', 'SCHOOL', 'STRM', 'PP1', 'PP2', 'AVG', 'GRD', 'RNK'
        ];
    }

    public function map($result): array
    {
        return [
            $result['rank'],
            $result['student']->adm,
            $result['student']->name,
            $result['student']->gender,
            $result['student']->school->name,
            $result['student']->stream->name,
            $result['subject1Marks'],
            $result['subject2Marks'],
            $result['average'],
            $result['grade'],
            $result['rank'] // Ensure this matches your intended output
        ];
    }
}
