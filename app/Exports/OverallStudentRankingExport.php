<?php

namespace App\Exports;

use App\Models\Exam;
use App\Models\Grading;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class OverallStudentRankingExport implements FromCollection, WithHeadings
{
    protected $exam;
    protected $studentMeans;
    protected $gradingSystem;

    /**
     * Constructor to initialize necessary data.
     *
     * @param  \App\Models\Exam  $exam
     * @param  array  $studentMeans
     * @param  \Illuminate\Database\Eloquent\Collection  $gradingSystem
     */
    public function __construct(Exam $exam, array $studentMeans, Collection $gradingSystem)
    {
        $this->exam = $exam;
        $this->studentMeans = $studentMeans;
        $this->gradingSystem = $gradingSystem;
    }

    /**
     * Return the collection of data to be exported.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->studentMeans);
    }

    /**
     * Define the headings for the exported Excel file.
     *
     * @return array
     */
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
            'RNK',
        ];
    }
}
