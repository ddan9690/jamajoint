<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

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
        // Convert all data to uppercase
        $uppercasedData = $this->data->map(function ($row) {
            return array_map('strtoupper', $row);
        });

        return $uppercasedData;
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
        return 'A2'; // Start from cell A2, leaving cell A1 for the merged overall heading
    }

    public function styles(Worksheet $sheet)
    {
        // Merge cells for the overall heading
        $sheet->mergeCells('A1:J1');

        // Set the overall heading text including the exam name and year
        $overallHeading = $this->examDetails['name'] . ' - Term ' . $this->examDetails['term']  . ' ' . $this->examDetails['year'];
        $sheet->setCellValue('A1', $overallHeading);

        // Set font size and center align the overall heading
        $sheet->getStyle('A1')->getFont()->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    }
}
