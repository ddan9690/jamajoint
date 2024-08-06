@extends('backend.layout.master')
@section('title', 'Create Grading System')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Grading System</div>

                <div class="card-body">
                    <form action="{{ route('grading_system.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" required>
                        </div>

                        <!-- Add more form fields as needed for your grading system -->

                        <button type="submit" class="btn btn-sm btn-primary">Create Grading System</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
