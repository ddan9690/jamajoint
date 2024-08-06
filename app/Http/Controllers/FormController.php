<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\School;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function show($schoolId, $form)
    {
        $school = School::findOrFail($schoolId);
        $form = Form::findOrFail($form);


        $streams = $school->streams()->where('form_id', $form->id)->get();

        // resources\views\backend\schools\streams.blade.php
        return view('backend.schools.streams', compact('school', 'form', 'streams'));
    }

}
