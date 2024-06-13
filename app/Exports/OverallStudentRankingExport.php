<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class OverallStudentRankingExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function map($studentMean): array
    {
        return [
            $studentMean['rank'],
            $studentMean['student']->adm,
            $studentMean['student']->name,
            $studentMean['student']->gender,
            $studentMean['student']->school->name,
            $studentMean['student']->stream->name,
            $studentMean['subject1Marks'],
            $studentMean['subject2Marks'],
            $studentMean['average'],
            $studentMean['grade'],
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'ADM',
            'NAME',
            'GENDER',
            'SCHOOL',
            'STRM',
            'PP1',
            'PP2',
            'AVG',
            'GRD',
        ];
    }
}
