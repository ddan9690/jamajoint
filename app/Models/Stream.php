<?php

namespace App\Models;

use App\Models\Form;
use App\Models\Mark;
use App\Models\School;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stream extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'school_id','form_id'];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}
