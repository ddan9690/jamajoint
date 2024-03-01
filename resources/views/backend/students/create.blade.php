@extends('backend.layout.master')
@section('title', 'Create Student')
@section('content')

<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Add student to stream <strong>{{$stream->name}} </strong></h6>
            <a href="{{ route('streams.show', ['schoolId' => $school->id, 'streamId' => $stream->id, 'form' => $form->id]) }}" class="btn btn-sm btn-primary">Cancel</a>
        </div>
        <div class="card-body">
            <form action="{{ route('students.store', ['schoolId' => $school->id, 'streamId' => $stream->id, 'form' => $form->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Student Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="adm">Admission Number</label>
                    <input type="number" name="adm" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" class="form-control" required>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-sm btn-primary">Create Student</button>
            </form>
        </div>
    </div>
</div>

@endsection
