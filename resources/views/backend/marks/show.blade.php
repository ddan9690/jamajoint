@extends('backend.layout.master')

@section('title', 'Exam Details')

@section('content')
<style>
    .table-sm td,
    .table-sm th {
        white-space: nowrap;
        padding: 0.5rem;
    }
</style>

<div class="container">
    <h5 class="text-warning">{{ $exam->name }} Term {{ $exam->term }} - {{ $exam->year }}</h5>
    <p><strong>School:</strong> {{ $stream->school->name }}</p>
    <p><strong>Stream:</strong> {{ $stream->name }}</p>
    <p><strong>Subject:</strong> {{ $subject->name }}</p>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12 text-right mb-3">
            @can('admin')

            <a href="{{ route('marks.deleteAll', [$exam->id, $stream->id, $subject->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete all records?');">
                <i class="fa-solid fa-trash"></i> Delete All
            </a>
            @endcan

            <a href="{{ route('marks.addResult', [$exam->id, $stream->id, $subject->id]) }}" class="btn btn-success btn-sm">
                <i class="fa-solid fa-plus"></i> Add Result
            </a>
        </div>
    </div>

    <table class="table table-responsive table-striped table-sm table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>ADM</th>
                <th>Name</th>
                <th>Marks</th>
                @can('admin')
                <th>Actions</th>

                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach ($marks as $mark)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mark->student->adm }}</td>
                    <td>{{ $mark->student->name }}</td>
                    <td>{{ $mark->marks }}</td>
                    <td>
                        <div class="btn-group">
                            @can('admin')


                            <a href="{{ route('marks.edit', $mark->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-pencil-alt" style="margin-right: 5px;"></i>
                            </a>
                            <form method="POST" action="{{ route('marks.destroy', $mark->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">
                                    <i class="fas fa-trash-alt" style="margin-right: 5px;"></i>
                                </button>
                            </form>

                            @endcan
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
