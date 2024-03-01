@extends('frontend.layout.master')
@section('title', 'Felix John Oduor - History and Government Specialist')

@section('content')

<!-- Profile Start -->
<div class="container py-5">
    <div class="row">
        <div class="col-lg-6">
            <img src="{{ asset('frontend/img/felix1.jpg') }}" class="img-fluid" alt="Felix John Odiwuor">
        </div>
        <div class="col-lg-6">
            {{-- <h1 class="display-4 mb-4">Meet Felix John Odiwuor</h1> --}}
            <p class="lead">
                Felix John Oduor is a renowned teacher at Asumbi Girls High School, specializing in the field of History and Government. With a passion for education and a focus on excellence, he has become a trusted mentor to many students.
            </p>
            <p class="lead">
                Felix's expertise in History and Government, particularly in Paper 1, has led to exceptional outcomes for his students. His inspirational talks and mentorship have played a pivotal role in preparing students for the KCSE exams, resulting in remarkable success stories.
            </p>
            <p class="lead">
                Under his guidance, Asumbi Girls High School has risen to prominence as a national powerhouse in History and Government. The school consistently produces top-performing students, setting new standards of excellence in the subject.
            </p>
        </div>
    </div>
</div>
<!-- Profile End -->

@endsection
