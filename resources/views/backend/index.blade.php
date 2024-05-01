@extends('backend.layout.master')
@section('title', 'JamaJoint :: Dashboard')
@section('content')
<div class="container">
    {{-- Initialize a counter to track the number of exams the user can view --}}
    @php
        $viewableExamsCount = 0;
    @endphp

    <div class="row">
        {{-- Loop through the exams --}}
        @foreach ($exams as $exam)
            {{-- Use the view-exam gate to check if the user can view the exam --}}
            @can('view-exam', $exam)
                {{-- Increment the counter --}}
                @php
                    $viewableExamsCount++;
                @endphp

                {{-- Display the exam card --}}
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="font-weight-bold text-uppercase mb-1">
                                        {{ $exam->name }} Form {{ $exam->form->name }}
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Term {{ $exam->term }} - {{ $exam->year }}
                                    </div>
                                    <div class="mt-2 mb-0 text-muted text-xs">
                                        @if ($exam->published === 'yes')
                                            <a href="{{ route('results.index', ['id' => $exam->id, 'slug' => $exam->slug]) }}" class="btn btn-sm btn-success btn-block">View Results</a>
                                        @else
                                            <a href="{{ route('marks.index', ['exam' => $exam->id]) }}" class="btn btn-sm btn-primary btn-block">Submit Marks</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        @endforeach
    </div>

    {{-- Display the alert message if there are no exams available for the user to view --}}
    @if ($viewableExamsCount === 0)
        <div class="text-center">
            {{-- <h3>No active or processed exams available...</h3> --}}
            <div class="alert alert-warning" role="alert">
                There are no exams available for you to view or submit marks. Please contact the admin for support.
            </div>
        </div>
    @endif
</div>
@endsection
