@extends('frontend.layout.master')
@section('title', 'JamaJoint :: Features')

@section('content')

<!-- Service Start -->
<div class="container-xxl py-5">
    <div class="container px-lg-5">
        <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="position-relative d-inline text-primary ps-4">JamaJoint Features</h6>
            {{-- <h2 class="mt-2">Empowering Teachers with Comprehensive Exam Analysis</h2> --}}
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.1s">
                <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                    <div class="service-icon flex-shrink-0">
                        <i class="fas fa-school fa-2x text-primary"></i>
                    </div>
                    <h5 class="mb-3">My School Results</h5>
                    <p><strong>Access</strong> detailed analysis reports tailored for your school. Easily view and download results for the entire school with just a click.</p>
                    <a class="btn px-3 mt-auto mx-auto" href="#">Learn More</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.3s">
                <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                    <div class="service-icon flex-shrink-0">
                        <i class="fas fa-trophy fa-2x text-primary"></i>
                    </div>
                    <h5 class="mb-3">School Ranking</h5>
                    <p><strong>Explore</strong> the overall ranking of your school among participating schools. Gain insights into your school's performance and standing.</p>
                    <a class="btn px-3 mt-auto mx-auto" href="#">Discover More</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.6s">
                <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                    <div class="service-icon flex-shrink-0">
                        <i class="fas fa-graduation-cap fa-2x text-primary"></i>
                    </div>
                    <h5 class="mb-3">Overall Student Ranking</h5>
                    <p><strong>Gain</strong> insights into the overall ranking of individual students across all participating schools. Identify top-performing students.</p>
                    <a class="btn px-3 mt-auto mx-auto" href="#">Get Started</a>
                </div>
            </div>
            <!-- Add more items for other reports with relevant icons -->
            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.9s">
                <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                    <div class="service-icon flex-shrink-0">
                        <i class="fas fa-chart-bar fa-2x text-primary"></i>
                    </div>
                    <h5 class="mb-3">Stream Ranking</h5>
                    <p><strong>Explore</strong> how individual streams performed and their respective rankings. Enhance teaching strategies with stream-specific insights.</p>
                    <a class="btn px-3 mt-auto mx-auto" href="#">Discover More</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="1.2s">
                <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                    <div class="service-icon flex-shrink-0">
                        <i class="fas fa-star fa-2x text-primary"></i>
                    </div>
                    <h5 class="mb-3">Top Performances</h5>
                    <p><strong>Identify</strong> and celebrate top-performing students. Gain insights into exceptional achievements and use the data to improve overall performance.</p>
                    <a class="btn px-3 mt-auto mx-auto" href="#">Learn More</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="1.5s">
                <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                    <div class="service-icon flex-shrink-0">
                        <i class="fas fa-file-alt fa-2x text-primary"></i>
                    </div>
                    <h5 class="mb-3">Paper-wise Analysis</h5>
                    <p><strong>Dive deep</strong> into the specifics with detailed analysis reports for Paper 1 and Paper 2. Understand performance trends and areas for improvement.</p>
                    <a class="btn px-3 mt-auto mx-auto" href="#">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Service End -->

@endsection
