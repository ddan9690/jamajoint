@extends('backend.layout.master')

@section('title', 'Schools Registered for Exam')

@section('content')
<style>
    .table-sm td,
    .table-sm th {
        white-space: nowrap; /* Prevent wrapping */
        padding: 0.5rem; /* Adjust padding as needed */
    }
</style>
<div class="container">
    <h5 class="text-warning">Schools Registered for {{ $exam->name }}</h5>

    @if ($schools->isEmpty())
        <p>No schools are registered for this exam.</p>
    @else
        <table class="table table-responsive table-striped table-sm table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>School</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>Download Marksheet</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schools as $school)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $school->name }}</td>
                        <td>{{ $school->studentsWithMarks }}</td>
                        <td>
                            <a href="{{ route('streamsForSchool', ['examId' => $exam->id, 'schoolId' => $school->id]) }}" class="btn btn-sm btn-secondary">View</a>
                        </td>
                        <td>
                            <a href="{{ route('marksheet', ['schoolId' => $school->id, 'slug' => $school->slug]) }}" class="btn btn-sm btn-primary">Download Marksheet</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
