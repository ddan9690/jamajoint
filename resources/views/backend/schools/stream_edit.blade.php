@extends('backend.layout.master')
@section('title', 'Edit Stream of ' . $school->name)
@section('content')

<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Edit Stream of {{ $school->name }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('streams.update', ['id' => $stream->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Stream Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $stream->name }}" required>
                </div>

                <button type="submit" class="btn btn-sm btn-primary">Update Stream</button>
            </form>
        </div>
    </div>
</div>

@endsection
