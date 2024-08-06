<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MySchoolResultsExport implements WithMultipleSheets
{
    use Exportable;

    private $results;
    private $gradingSystem;
    private $exam;
    private $school;
    private $analysis;

    public function __construct($results, $gradingSystem, $exam, $school, $analysis)
    {
        $this->results = $results;
        $this->gradingSystem = $gradingSystem;
        $this->exam = $exam;
        $this->school = $school;
        $this->analysis = $analysis;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Main Results Sheet
        $sheets[] = new MainResultsSheet($this->results);

        // Grade Analysis Sheet
        $sheets[] = new GradeAnalysisSheet($this->analysis, $this->gradingSystem);

        return $sheets;
    }
}

class MainResultsSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    private $results;

    public function __construct($results)
    {
        $this->results = $results;
    }

    public function headings(): array
    {
        return [
            'NAME',
            'ADM',
            'STREAM',
            'PP1',
            'PP2',
            'AVG',
            'GRD',
        ];
    }

    public function title(): string
    {
        return 'Main Results';
    }

    public function collection()
    {
        $data = [];

        foreach ($this->results as $result) {
            $data[] = [
                $result['student']->name,
                $result['student']->adm,
                $result['student']->stream->name,
                $result['subject1Marks'],
                $result['subject2Marks'],
                $result['average'],
                $result['grade'],
            ];
        }

        return collect($data);
    }
}

class GradeAnalysisSheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    private $analysis;
    private $gradingSystem;

    public function __construct($analysis, $gradingSystem)
    {
        $this->analysis = $analysis;
        $this->gradingSystem = $gradingSystem;
    }

    public function headings(): array
    {
        $headingRow = ['STREAM'];

        foreach ($this->gradingSystem as $grade) {
            $headingRow[] = $grade->grade;
        }

        $headingRow[] = 'TOTAL';
        $headingRow[] = 'MEAN';

        return $headingRow;
    }

    public function title(): string
    {
        return 'Grade Analysis';
    }

    public function collection()
    {
        $data = [];

        $sortedAnalysis = collect($this->analysis)->sortByDesc('mean');

        foreach ($sortedAnalysis as $item) {
            $dataRow = [$item['stream']];

            foreach ($this->gradingSystem as $grade) {
                $dataRow[] = $item['grades'][$grade->grade];
            }

            $dataRow[] = $item['total'];
            $dataRow[] = $item['mean'];

            $data[] = $dataRow;
        }


        $overallRow = ['Overall'];

        $overallTotal = 0;
        $overallMean = 0;

        foreach ($this->gradingSystem as $grade) {
            $gradeCount = 0;

            foreach ($sortedAnalysis as $item) {
                $gradeCount += $item['grades'][$grade->grade];
            }

            $overallTotal += $gradeCount;
            $gradePoints = $this->gradingSystem->where('grade', $grade->grade)->first()->points ?? 0;
            $overallMean += ($gradeCount * $gradePoints);

            $overallRow[] = $gradeCount;
        }

        $overallRow[] = $overallTotal;
        $overallRow[] = $overallTotal > 0 ? round($overallMean / $overallTotal, 4) : 0;

        $data[] = $overallRow;

        return collect($data);
    }
}

