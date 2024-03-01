<?php

namespace App\Models;

use App\Models\Form;
use App\Models\School;
use App\Models\Invoice;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'term',
        'year',
        'user_id',
        'published',
        'form_id',
    ];

    public function schools()
    {
        return $this->belongsToMany(School::class, 'exam_schools', 'exam_id', 'school_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }



    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }
}
