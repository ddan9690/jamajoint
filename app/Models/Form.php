<?php

namespace App\Models;

use App\Models\Exam;
use App\Models\School;
use App\Models\Stream;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Form extends Model
{
    use HasFactory;

    public function schools()
    {
        return $this->hasMany(School::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function streams()
    {
        return $this->hasMany(Stream::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

}
