@extends('backend.layout.master')

@section('title', 'Stream Marks View')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <h4>{{ $exam->name }}</h4>
            <p>Stream: {{ $stream->name }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subjects as $subject)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $subject->name }}</td>
                            <td class="text-center">
                                @if ($marksExistence[$subject->id])
                                    <a href="{{ route('marks.show', [$exam->id, $stream->id, $subject->id]) }}" class="btn btn-success btn-sm">
                                        View submitted marks
                                    </a>
                                @else
                                    <a href="{{ route('marks.submit', [$exam->id, $stream->id, $subject->id]) }}" class="btn btn-primary btn-sm">
                                        Submit Marks
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
