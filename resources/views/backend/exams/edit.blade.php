@extends('backend.layout.master')
@section('title', 'Edit Exam')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Exam</div>

                <div class="card-body">
                    <form action="{{ route('exams.update', ['id' => $exam->id, 'slug' => $exam->slug]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Exam Name</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ $exam->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="term">Form</label>
                            <select name="form_id" class="form-control" id="form_id" required>
                                @foreach ($forms as $form)
                                    <option value="{{ $form->id }}" {{ $exam->form_id == $form->id ? 'selected' : '' }}>Form {{ $form->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="term">Term</label>
                            <select name="term" class="form-control" id="term" required>
                                <option value="1" {{ $exam->term == 1 ? 'selected' : '' }}>Term 1</option>
                                <option value="2" {{ $exam->term == 2 ? 'selected' : '' }}>Term 2</option>
                                <option value="3" {{ $exam->term == 3 ? 'selected' : '' }}>Term 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="year">Year</label>
                            <input type="number" name="year" class="form-control" id="year" value="{{ $exam->year }}" required>
                        </div>

                        <div class="form-group">
                            <label for="published">Published</label>
                            <select name="published" class="form-control" id="published" required>
                                <option value="no" {{ $exam->published === 'no' ? 'selected' : '' }}>No</option>
                                <option value="yes" {{ $exam->published === 'yes' ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="grading_system_id">Grading System</label>
                            <select name="grading_system_id" class="form-control" id="grading_system_id" required>
                                @foreach ($gradingSystems as $gradingSystem)
                                    <option value="{{ $gradingSystem->id }}" {{ $exam->grading_system_id == $gradingSystem->id ? 'selected' : '' }}>{{ $gradingSystem->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-sm btn-primary">Update Exam</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
