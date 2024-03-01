@extends('frontend.layout.master')

@section('title', 'Cyberspace :: Victor Mwoma Profile')

@section('content')

<!-- Profile Start -->
<div class="container-xxl py-6">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="profile-image-container">
                    <img src="{{ asset('frontend/img/victor-mwoma.jpg') }}" alt="Victor Mwoma" class="img-fluid rounded-circle profile-image">
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <p>Victor Mwoma is an esteemed educator with a deep passion for the subjects of History and Government. With a career spanning several years, he has dedicated his expertise to Kathiani Girls High School, located in the picturesque Machakos County. As a long-serving teacher of History and Government, Victor has consistently demonstrated his commitment to providing high-quality education and inspiring students to excel.</p>
                <p>In addition to his role as a teacher, Victor Mwoma also serves as the Director of Studies at Kathiani Girls High School. </p>
                <p>Victor Mwoma's impact extends far beyond the classroom. He is a mentor, guiding students towards their goals and inspiring them to explore the rich tapestry of history and the intricacies of government. His unwavering commitment to education makes him an invaluable asset to both Kathiani Girls High School.</p>
            </div>
        </div>
    </div>
</div>
<!-- Profile End -->

<style>
    .profile-image-container {
        width: 200px;
        height: 200px;
        border: 5px solid #000; /* You can adjust the thickness and color of the border here */
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

@endsection
