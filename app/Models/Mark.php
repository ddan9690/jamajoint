<?php

namespace App\Models;

use App\Models\Exam;
use App\Models\Stream;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'stream_id',
        'subject_id',
        'student_id',
        'marks',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function stream()
    {
        return $this->belongsTo(Stream::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

