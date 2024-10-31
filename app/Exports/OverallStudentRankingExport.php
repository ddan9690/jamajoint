<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use Maatwebsite\Excel\Events\AfterSheet;

class OverallStudentRankingExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents, ShouldAutoSize
{
    protected $exam;
    protected $studentMeans;

    public function __construct($exam, $studentMeans)
    {
        $this->exam = $exam;
        $this->studentMeans = $studentMeans;
    }

    public function collection()
    {
        return collect($this->studentMeans);
    }

    public function headings(): array
    {
        return [
            [ strtoupper($this->exam->name) . ' - ' . strtoupper($this->exam->year) . ' TERM: ' . strtoupper($this->exam->term)],
            ['#', 'ADM', 'NAME', 'GENDER', 'SCHOOL', 'STREAM', 'PP1', 'PP2', 'AVG', 'GRD', 'RNK']
        ];
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
            $studentMean['rank']
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply styles to the first row (exam details)
        $sheet->mergeCells('A1:K1');
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Apply styles to the column headings
        $sheet->getStyle('A2:K2')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // Apply border to all cells
        $sheet->getStyle('A1:K' . (count($this->studentMeans) + 2))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // Apply bold style to AVG and GRD column data
        $sheet->getStyle('I3:I' . (count($this->studentMeans) + 2))->getFont()->setBold(true);
        $sheet->getStyle('J3:J' . (count($this->studentMeans) + 2))->getFont()->setBold(true);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Set the column widths
                foreach (range('A', 'K') as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }

                // Set rows to repeat at the top of each printed page (Rows 1 and 2)
                $event->sheet->getDelegate()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 2);
            },
        ];
    }
}


