<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OverallStudentRankingExport implements FromCollection, WithHeadings, ShouldAutoSize, WithCustomStartCell, WithStyles
{
    protected $data;
    protected $examDetails;

    public function __construct(array $data, array $examDetails)
    {
        $this->data = collect($data);
        $this->examDetails = $examDetails;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
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

    public function startCell(): string
    {
        return 'A2';
    }

    public function styles(Worksheet $sheet)
    {
        // Merge cells for the overall heading
        $sheet->mergeCells('A1:J1');

        // Set the overall heading text including the exam name and year
        $overallHeading = $this->examDetails['name'] . ' - Term ' . $this->examDetails['term']  . ' ' . $this->examDetails['year'];
        $sheet->setCellValue('A1', $overallHeading);

        // Set font size, bold, and center align the overall heading
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // Set font size and bold for headings
        $sheet->getStyle('A2:J2')->getFont()->setBold(true)->setSize(12);
    }
}
