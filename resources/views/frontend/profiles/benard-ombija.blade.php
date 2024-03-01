@extends('frontend.layout.master')

@section('title', 'Cyberspace :: Ombija Benard Profile')

@section('description', 'Ombija Benard is a teacher of History and Government stationed at Agoro Sare Boys High School, Homa Bay County, where his expertise and commitment shine brightly.')

@section('content')

<div class="container-xxl py-6">
    <div class="container">
      <div class="row">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <img src="{{ asset('frontend/img/benard.jpg') }}" alt="Ombija Benard" class="img-fluid rounded-circle">
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                {{-- <h1 class="display-6 text-primary mb-4">Meet Ombija Benard</h1> --}}
                <p>Ombija Benard is a teacher stationed at Agoro Sare Boys High School, Homa Bay County, where his expertise and commitment shine brightly.</p>
                <p>Ombija Benard's journey in the teaching profession has been marked by continuous growth and a passion for student success. Over the years, he has developed a deep understanding of his subject matter and a unique ability to inspire students.</p>
                <p>While Ombija's contributions extend beyond the classroom, his primary focus remains on equipping his students with the knowledge and skills they need to excel. His commitment to fostering a positive learning environment makes him a respected figure at Agoro Sare Boys High School.</p>
            </div>
        </div>
    </div>
</div>
@endsection
