@extends('backend.layout.master')

@section('title', 'Edit Mark')

@section('content')
<div class="container">
    <h5 class="text-warning">Edit Mark</h5>

    <form method="POST" action="{{ route('marks.update', $mark->id) }}">
        @csrf
        @method('PUT')




        <div class="form-group">
            <label for="student_name">Student Name:</label>
            <input type="text" name="student_name" class="form-control" value="{{ $mark->student->name }}" disabled>
        </div>
        <div class="form-group">
            <label for="student_adm">ADM:</label>
            <input type="text" name="student_adm" class="form-control" value="{{ $mark->student->adm }}" disabled>
        </div>
        <div class="form-group">
            <label for="stream_name">Stream:</label>
            <input type="text" name="stream_name" class="form-control" value="{{ $mark->student->stream->name }}" disabled>
        </div>

        <div class="form-group">
            <label for="subject_name">Subject:</label>
            <input type="text" name="subject_name" class="form-control" value="{{ $mark->subject->name }}" disabled>
        </div>

        <div class="form-group">
            <label for="marks">Marks:</label>
            <input type="number" name="marks" min="0" max="100" class="form-control" value="{{ $mark->marks }}">
        </div>

        <button type="submit" class="btn btn-sm btn-primary">Update Mark</button>
    </form>
</div>
@endsection
