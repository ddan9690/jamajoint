@extends('frontend.layout.master')

@section('title', 'News Details')

@section('content')

<div class="col-lg-12">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color: #007BFF; color: white;">
            <h1 class="m-0 font-weight-bold">{{ $news->title }}</h1>
        </div>

        <div class="card-body">
            <p class="font-weight-bold">{{ $news->created_at->format('d/m/y') }}</p>

            <hr>
            <div>{!! $news->description !!}</div>
        </div>
    </div>
</div>

@endsection
