<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\School;
use App\Models\Stream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StreamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'school_id' => 'required|exists:schools,id',
            'form_id' => 'required|exists:forms,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        // Create a new stream
        Stream::create([
            'name' => $request->input('name'),
            'school_id' => $request->input('school_id'),
            'form_id' => $request->input('form_id'),
        ]);

        return response()->json(['message' => 'Stream created successfully'], 200);
    }
    /**
     * Display the specified resource.
     */
    public function show($schoolId, $streamId,$form)
    {
        $school = School::findOrFail($schoolId);
        $form = Form::findOrFail($form);

        $stream = Stream::with('students')
                       ->findOrFail($streamId);

        $students = $stream->students->sortBy('adm');

        return view('backend.schools.stream_show', compact('school','form', 'stream', 'students'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $stream = Stream::findOrFail($id);
        $school = $stream->school;

        return view('backend.schools.stream_edit', compact('stream', 'school'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $stream = Stream::findOrFail($id);
        $stream->update([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('schools.show', ['id' => $stream->school->id, 'slug' => $stream->school->slug])
    ->with('success', 'Stream updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $stream = Stream::findOrFail($id);
        $stream->delete();
        return redirect()->back()->with('success', 'Stream deleted successfully.');
    }
}
