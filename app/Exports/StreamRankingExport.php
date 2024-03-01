<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class StreamRankingExport implements FromCollection, WithHeadings
{
    protected $streamMeans;

    public function __construct(array $streamMeans)
    {
        $this->streamMeans = $streamMeans;
    }

    public function collection()
    {
        return collect($this->streamMeans);
    }

    public function headings(): array
    {
        return [
            'Stream',
            'School',
            'County',
            'Mean',
        ];
    }

    public function map($streamMean): array
    {
        return [
            $streamMean['stream']['name'],
            $streamMean['school']['name'],
            $streamMean['school']['county'],
            $streamMean['stream_mean'],
        ];
    }
}
