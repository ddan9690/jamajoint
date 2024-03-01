@extends('backend.layout.master')
@section('title', 'Create News')
@section('content')

<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Create News</h6>
            <a href="{{ route('news.index') }}" class="btn btn-sm btn-primary">Back to News List</a>
        </div>
        <div class="card-body">

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control summernote" id="description" required></textarea>
                </div>


                <button type="submit" class="btn btn-sm btn-primary">Post</button>
            </form>
        </div>
    </div>
</div>

@endsection
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.css" rel="stylesheet">
@endpush

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.js"></script>

<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 200,
        });
    });
</script>
@endpush

