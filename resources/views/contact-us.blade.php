@extends('frontend.layout.master')
@section('title', 'JamaJoint :: Contact Us')

@section('content')

<!-- Contact Start -->
<div class="container-xxl py-5">
    <div class="container px-lg-5">
        <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="position-relative d-inline text-primary ps-4">Contact Us</h6>
            <h2 class="mt-2">Get in Touch</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="contact-info text-center bg-light rounded p-4">
                    <i class="fas fa-phone-alt fa-2x mb-3 text-primary"></i>
                    <h5 class="mb-3">Call Us</h5>
                    <p>0711317235</p>
                    <p>0729946710</p>
                    <p>0703165332</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-info text-center bg-light rounded p-4">
                    <i class="fas fa-envelope fa-2x mb-3 text-primary"></i>
                    <h5 class="mb-3">Email Us</h5>
                    <p>ddnan9690@gmail.com</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-info text-center bg-light rounded p-4">
                    <i class="fab fa-facebook fa-2x mb-3 text-primary"></i>
                    <h5 class="mb-3">Visit Our Facebook Page</h5>
                    <a href="https://www.facebook.com/profile.php?id=61558591801433" target="_blank" class="text-decoration-none">JamaJoint</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

@endsection
