<?php

namespace App\Models;

use App\Models\Exam;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamSchool extends Model
{
    use HasFactory;

    protected $table = 'exam_schools';

    protected $fillable = [
        'exam_id',
        'school_id',
    ];
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

}
