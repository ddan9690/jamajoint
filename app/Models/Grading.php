<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grading extends Model
{
    use HasFactory;


    public function gradingSystem()
    {
        return $this->belongsTo(GradingSystem::class);
    }
}
