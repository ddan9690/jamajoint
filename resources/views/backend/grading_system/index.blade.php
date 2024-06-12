{{-- resources\views\backend\grading_system\index.blade.php --}}

@extends('backend.layout.master')
@section('title', 'Grading Systems')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Grading Systems</div>

                    <div class="card-body">
                        <a href="{{ route('grading_system.create') }}" class="btn btn-sm btn-primary mb-3">Create New Grading System</a>

                        <table class="table">
                            <thead>
                                <tr>
                                    {{-- <th>ID</th> --}}
                                    <th>Name</th>
                                    {{-- <th>Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($gradingSystems as $gradingSystem)
                                    <tr>
                                        {{-- <td>{{ $gradingSystem->id }}</td> --}}
                                        <td>{{ $gradingSystem->name }}</td>
                                        {{-- <td>
                                            <a href="{{ route('grading_system.edit', $gradingSystem->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('grading_system.destroy', $gradingSystem->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this grading system?')">Delete</button>
                                            </form>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
