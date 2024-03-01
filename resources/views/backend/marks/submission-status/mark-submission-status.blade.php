@extends('backend.layout.master')

@section('title', 'Mark Submission Status')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="container">
            <h5 class="text-warning">Mark Submission Status</h5>

            @if ($exams->isEmpty())
                <p>No active exams.</p>
            @else
                <table class="table table-responsive table-striped table-sm table-bordered table-hover">
                    <thead>
                        <tr>

                            <th>Exam</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exams as $exam)
                            <tr>

                                <td>{{ $exam->name }} T{{ $exam->term }} {{ $exam->year }}</td>

                                <td>
                                    <a href="{{ route('marks.schoolsRegistered', $exam->id) }}" class="btn btn-secondary btn-sm">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
