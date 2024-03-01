<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{
    private $schoolId;
    private $streamId;
    private $form;

    public function __construct($schoolId, $streamId, $form)
    {
        $this->schoolId = $schoolId;
        $this->streamId = $streamId;
        $this->form = $form;
    }



    public function model(array $row)
    {
        return new Student([
            'name' => $row['name'],
            'adm' => $row['adm'],
            'gender' => $row['gender'],
            'school_id' => $this->schoolId,
            'stream_id' => $this->streamId,
            'form_id' => $this->form,
            'slug' => Str::slug($row['name'])
        ]);
    }

}
