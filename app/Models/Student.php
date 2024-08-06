<?php

namespace App\Models;

use App\Models\Form;
use App\Models\Mark;
use App\Models\School;
use App\Models\Stream;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'adm', 'school_id', 'stream_id', 'slug','gender','form_id'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function stream()
    {
        return $this->belongsTo(Stream::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }


}
