@extends('backend.layout.master')

@section('title', 'Streams for School')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h5>{{ $exam->name }} Term {{ $exam->term }} {{ $exam->year }}</h5>
            <p>{{ $school->name }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <table class="table table-sm align-items-center table-flush table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Stream</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($streams as $stream)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $stream->name }}</td>
                            <td>
                                <a href="{{ route('marks.streamMarksView', [$exam->id, $stream->id]) }}" class="btn btn-sm btn-secondary">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
