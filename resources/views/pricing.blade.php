@extends('frontend.layout.master')
@section('title', 'JamaJoint :: Pricing')

@section('content')

<!-- Pricing Start -->
<div class="container-xxl py-5">
    <div class="container px-lg-5">
        <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="position-relative d-inline text-primary ps-4">JamaJoint Pricing</h6>
            {{-- <h2 class="mt-2">Choose the Plan That Fits Your Needs</h2> --}}
        </div>
        <div class="row g-4">
            <div class="col-lg-6 wow zoomIn" data-wow-delay="0.1s">
                <div class="pricing-item text-center rounded">
                    <div class="pricing-header">
                        <h5 class="fw-bold text-primary">Inter-School Joint Analysis</h5>
                    </div>
                    <div class="pricing-price">
                        <h2 class="fw-bold">Ksh 1,500</h2>
                        <p class="text-muted">Per Joint Exam</p>
                    </div>
                    <div class="pricing-features">
                        <p><i class="fas fa-check text-primary me-2"></i> Comprehensive Joint Exam Analysis</p>
                        <p><i class="fas fa-check text-primary me-2"></i> School Ranking Insights</p>
                        <p><i class="fas fa-check text-primary me-2"></i> Stream Reports</p>
                        <p><i class="fas fa-check text-primary me-2"></i> Overall Student Ranking</p>
                        <p><i class="fas fa-check text-primary me-2"></i> Top 10 girls and Boys</p>
                        <p><i class="fas fa-check text-primary me-2"></i> Paper-wise Analysis report</p>
                        <p><i class="fas fa-check text-primary me-2"></i> Downloadable Analysis report</p>
                    </div>
                    <div class="pricing-action">
                        {{-- <a class="btn btn-primary" href="#">Get Started</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow zoomIn" data-wow-delay="0.3s">
                <div class="pricing-item text-center rounded">
                    <div class="pricing-header">
                        <h5 class="fw-bold text-primary">Individual Subject Analysis</h5>
                    </div>
                    <div class="pricing-price">
                        <h2 class="fw-bold">Ksh 100</h2>
                        <p class="text-muted">Per Subject Analysis</p>
                    </div>
                    <div class="pricing-features">
                        <p><i class="fas fa-check text-primary me-2"></i> Quick Instant Analysis</p>
                        <p><i class="fas fa-check text-primary me-2"></i> Downloadable Analysis Reports</p>
                    </div>
                    <div class="pricing-action">
                        {{-- <a class="btn btn-primary" href="#">Get Started</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Pricing End -->

@endsection
