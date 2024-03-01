<?php

namespace App\Models;

use App\Models\Exam;
use App\Models\Form;
use App\Models\User;
use App\Models\Stream;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;

    public function streams(): HasMany
    {
        return $this->hasMany(Stream::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function schools()
    {
        return $this->belongsToMany(School::class, 'exam_school', 'exam_id', 'school_id');
    }

    public function forms(): HasMany
    {
        return $this->hasMany(Form::class);
    }
}
