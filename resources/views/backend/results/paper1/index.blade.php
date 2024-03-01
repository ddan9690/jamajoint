@extends('backend.layout.master')

@section('title', 'Paper 1 Analysis')

@section('content')
<div class="container">
    <h5 class="text-warning text-uppercase">{{ $exam->name }} term {{ $exam->term }} {{ $exam->year }}</h5>

    <!-- Subject 1 Analysis Heading -->
    <h6>Peper 1 Analysis</h6>

    <!-- Links for different analysis options -->
    <ul>
        <li><a href="{{ route('results.paper1.myschoolResults', ['exam_id' => $exam->id, 'form_id' => $exam->form->id, 'slug' => $exam->slug]) }}">My School Results</a></li>


        {{-- <li><a href="#">School Ranking</a></li>
        <li><a href="#">Overall Student Ranking</a></li>
        <li><a href="#">Stream Ranking</a></li> --}}
    </ul>

    <!-- Display subject 1 analysis data here -->
    <div class="row">
        <div class="col-md-12">
            <!-- Add your content for subject 1 analysis here -->
        </div>
    </div>
</div>
@endsection
