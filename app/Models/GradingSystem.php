<?php

namespace App\Models;

use App\Models\Exam;
use App\Models\Grading;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GradingSystem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function gradings()
    {
        return $this->hasMany(Grading::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
