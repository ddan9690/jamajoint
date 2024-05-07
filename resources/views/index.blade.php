@extends('frontend.layout.master')
@section('title', 'JamaJoint :: Home')

@section('content')

 <!-- About Start -->
 <div class="container-xxl py-5">
    <div class="container px-lg-5">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="section-title position-relative mb-4 pb-2">
                    <h6 class="position-relative text-primary ps-4">About JamaJoint</h6>
                    <h2 class="mt-2">Streamline Your Joint, CATs and RATs Analysis Insights Effortlessly</h2>
                </div>
                <p class="mb-4">Welcome to JamaJoint, where exam analysis meets simplicity. Say goodbye to the complexities of manual processes and Excel headaches. Our platform ensures meticulous examination analysis, providing insightful reports on school, stream, and student performances.</p>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>Meticulous Analysis</h6>
                        <h6 class="mb-0"><i class="fa fa-check text-primary me-2"></i>Effortless Data Entry</h6>
                    </div>
                    <div class="col-sm-6">
                        <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>Comprehensive Reports</h6>
                        <h6 class="mb-0"><i class="fa fa-check text-primary me-2"></i>User-Friendly Interface</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img class="img-fluid wow zoomIn" data-wow-delay="0.5s" src="{{ asset('frontend/img/about.jpg') }}" alt="JamaJoint About Image">
            </div>
        </div>
    </div>
</div>




<!-- About End -->


<!-- Newsletter Start -->
<div class="container-xxl bg-primary call-to-action my-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container px-lg-5">
        <div class="row align-items-center" style="min-height: 250px;">
            <div class="col-12 col-md-6">
                <h3 class="text-white">Explore the JamaJoint Exam Area</h3>
                <small class="text-white">Get comprehensive insights into joint exam analysis. Click the button below to access the exam area.</small>
                <div class="position-relative w-100 mt-3">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-light rounded-pill w-100 ps-4 pe-5" style="height: 48px;">Go to JamaJoint Exam Area</a>
                </div>
            </div>
            <div class="col-md-6 text-center mb-n5 d-none d-md-block">
                <img class="img-fluid mt-5" style="height: 250px;" src="{{ asset('frontend/img/newsletter.png') }}" alt="JamaJoint Newsletter">
            </div>
        </div>
    </div>
</div>


<!-- Newsletter End -->


<!-- Service Start -->
<div class="container-xxl py-5">
    <div class="container px-lg-5">
        <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="position-relative d-inline text-primary ps-4">JamaJoint Features</h6>
            <h2 class="mt-2">Empowering Teachers with Seamless Exam Analysis</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.1s">
                <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                    <div class="service-icon flex-shrink-0">
                        <i class="fa fa-search fa-2x"></i>
                    </div>
                    <h5 class="mb-3">Joint Exam Precision</h5>
                    <p>Revolutionize joint exam analysis with JamaJoint. Experience meticulous examination analysis, eliminating errors, and receiving comprehensive reports instantly.</p>
                    <a class="btn px-3 mt-auto mx-auto" href="#">Learn More</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.3s">
                <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                    <div class="service-icon flex-shrink-0">
                        <i class="fa fa-chart-bar fa-2x"></i>
                    </div>
                    <h5 class="mb-3">Performance Insights</h5>
                    <p>Unlock valuable insights into school ranking, stream analysis, overall student ranking, and detailed paper-wise analysis to enhance teaching strategies.</p>
                    <a class="btn px-3 mt-auto mx-auto" href="#">Discover More</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.6s">
                <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                    <div class="service-icon flex-shrink-0">
                        <i class="fa fa-cogs fa-2x"></i>
                    </div>
                    <h5 class="mb-3">User-Friendly Platform</h5>
                    <p>Simplify your joint exam analysis with JamaJoint. Just create exams, input marks, and publish effortlessly, saving time and reducing complexity.</p>
                    <a class="btn px-3 mt-auto mx-auto" href="#">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Service End -->


<!-- Portfolio Start -->
{{-- <div class="container-xxl py-5">
    <div class="container px-lg-5">
        <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="position-relative d-inline text-primary ps-4">Our Projects</h6>
            <h2 class="mt-2">Recently Launched Projects</h2>
        </div>
        <div class="row mt-n2 wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-12 text-center">
                <ul class="list-inline mb-5" id="portfolio-flters">
                    <li class="btn px-3 pe-4 active" data-filter="*">All</li>
                    <li class="btn px-3 pe-4" data-filter=".first">Design</li>
                    <li class="btn px-3 pe-4" data-filter=".second">Development</li>
                </ul>
            </div>
        </div>
        <div class="row g-4 portfolio-container">
            <div class="col-lg-4 col-md-6 portfolio-item first wow zoomIn" data-wow-delay="0.1s">
                <div class="position-relative rounded overflow-hidden">
                    <img class="img-fluid w-100" src="{{ asset('frontend/img/portfolio-1.jpg') }}" alt="">
                    <div class="portfolio-overlay">
                        <a class="btn btn-light" href="{{ asset('frontend/img/portfolio-1.jpg') }}" data-lightbox="portfolio"><i class="fa fa-plus fa-2x text-primary"></i></a>
                        <div class="mt-auto">
                            <small class="text-white"><i class="fa fa-folder me-2"></i>Web Design</small>
                            <a class="h5 d-block text-white mt-1 mb-0" href="">Project Name</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 portfolio-item second wow zoomIn" data-wow-delay="0.3s">
                <div class="position-relative rounded overflow-hidden">
                    <img class="img-fluid w-100" src="{{ asset('frontend/img/portfolio-2.jpg') }}" alt="">
                    <div class="portfolio-overlay">
                        <a class="btn btn-light" href="{{ asset('frontend/img/portfolio-2.jpg') }}" data-lightbox="portfolio"><i class="fa fa-plus fa-2x text-primary"></i></a>
                        <div class="mt-auto">
                            <small class="text-white"><i class="fa fa-folder me-2"></i>Web Design</small>
                            <a class="h5 d-block text-white mt-1 mb-0" href="">Project Name</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 portfolio-item first wow zoomIn" data-wow-delay="0.6s">
                <div class="position-relative rounded overflow-hidden">
                    <img class="img-fluid w-100" src="{{ asset('frontend/img/portfolio-3.jpg') }}" alt="">
                    <div class="portfolio-overlay">
                        <a class="btn btn-light" href="{{ asset('frontend/img/portfolio-3.jpg') }}" data-lightbox="portfolio"><i class="fa fa-plus fa-2x text-primary"></i></a>
                        <div class="mt-auto">
                            <small class="text-white"><i class="fa fa-folder me-2"></i>Web Design</small>
                            <a class="h5 d-block text-white mt-1 mb-0" href="">Project Name</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Repeat the pattern for other items -->
            <div class="col-lg-4 col-md-6 portfolio-item second wow zoomIn" data-wow-delay="0.1s">
                <div class="position-relative rounded overflow-hidden">
                    <img class="img-fluid w-100" src="{{ asset('frontend/img/portfolio-4.jpg') }}" alt="">
                    <div class="portfolio-overlay">
                        <a class="btn btn-light" href="{{ asset('frontend/img/portfolio-4.jpg') }}" data-lightbox="portfolio"><i class="fa fa-plus fa-2x text-primary"></i></a>
                        <div class="mt-auto">
                            <small class="text-white"><i class="fa fa-folder me-2"></i>Web Design</small>
                            <a class="h5 d-block text-white mt-1 mb-0" href="">Project Name</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 portfolio-item first wow zoomIn" data-wow-delay="0.3s">
                <div class="position-relative rounded overflow-hidden">
                    <img class="img-fluid w-100" src="{{ asset('frontend/img/portfolio-5.jpg') }}" alt="">
                    <div class="portfolio-overlay">
                        <a class="btn btn-light" href="{{ asset('frontend/img/portfolio-5.jpg') }}" data-lightbox="portfolio"><i class="fa fa-plus fa-2x text-primary"></i></a>
                        <div class="mt-auto">
                            <small class="text-white"><i class="fa fa-folder me-2"></i>Web Design</small>
                            <a class="h5 d-block text-white mt-1 mb-0" href="">Project Name</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 portfolio-item second wow zoomIn" data-wow-delay="0.6s">
                <div class="position-relative rounded overflow-hidden">
                    <img class="img-fluid w-100" src="{{ asset('frontend/img/portfolio-6.jpg') }}" alt="">
                    <div class="portfolio-overlay">
                        <a class="btn btn-light" href="{{ asset('frontend/img/portfolio-6.jpg') }}" data-lightbox="portfolio"><i class="fa fa-plus fa-2x text-primary"></i></a>
                        <div class="mt-auto">
                            <small class="text-white"><i class="fa fa-folder me-2"></i>Web Design</small>
                            <a class="h5 d-block text-white mt-1 mb-0" href="">Project Name</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div> --}}
<!-- Portfolio End -->


<!-- Testimonial Start -->
<div class="container-xxl bg-primary testimonial py-5 my-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container py-5 px-lg-5">
        <div class="owl-carousel testimonial-carousel">
            <div class="testimonial-item bg-transparent border rounded text-white p-4">
                <i class="fa fa-quote-left fa-2x mb-3"></i>
                <p>Jamajoint is amazing! It makes analyzing joint exams easy and accurate. The user-friendly design is a big plus. I highly recommend it.</p>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0 rounded-circle" src="{{ asset('frontend/img/kokuro.jpg') }}" style="width: 50px; height: 50px;" alt="Client Image">
                    <div class="ps-3">
                        <h6 class="text-white mb-1">McKorucho</h6>
                        <small>Teacher</small>
                    </div>
                </div>
            </div>
            <div class="testimonial-item bg-transparent border rounded text-white p-4">
                <i class="fa fa-quote-left fa-2x mb-3"></i>
                <p>We used JamaJoint for our SharpShooters CRE joint analysis, and I was impressed. It's worth considering for any joint out there. Easy to use and provides accurate insights.</p>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0 rounded-circle" src="{{ asset('frontend/img/gordon-stanley.jpg') }}" style="width: 50px; height: 50px;" alt="Client Image">
                    <div class="ps-3">
                        <h6 class="text-white mb-1">Gordon Stanley</h6>
                        <small>Sharspshooters CRE Joint Coordinator</small>
                    </div>
                </div>
            </div>
            <div class="testimonial-item bg-transparent border rounded text-white p-4">
                <i class="fa fa-quote-left fa-2x mb-3"></i>
                <p>JamaJoint is fantastic! It's easy, accurate, and the reports help us a lot. I recommend it for any school</p>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0 rounded-circle" src="{{ asset('frontend/img/amos-raini.jpg') }}" style="width: 50px; height: 50px;" alt="Client Image">
                    <div class="ps-3">
                        <h6 class="text-white mb-1">Amos Raini</h6>
                        <small>Teacher</small>
                    </div>
                </div>
            </div>
            <div class="testimonial-item bg-transparent border rounded text-white p-4">
                <i class="fa fa-quote-left fa-2x mb-3"></i>
                <p>JamaJoint has simplified our examination analysis process, allowing us to focus more on enhancing our teaching methods. The user-friendly platform and insightful reports have positively impacted our department analysis process</p>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0 rounded-circle" src="{{ asset('frontend/img/chacha-samuel.jpg') }}" style="width: 50px; height: 50px;" alt="Client Image">
                    <div class="ps-3">
                        <h6 class="text-white mb-1">Chacha Samuel</h6>
                        <small>Mathematics Teacher</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Testimonial End -->


<!-- Team Start -->
<div class="container-xxl py-5">
    <div class="container px-lg-5">
        <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="position-relative d-inline text-primary ps-4">Our Team</h6>
            <h2 class="mt-2">Meet Our Team Members</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="team-item">
                    <div class="d-flex">
                        <div class="flex-shrink-0 d-flex flex-column align-items-center mt-4 pt-5" style="width: 75px;">
                            <a class="btn btn-square text-primary bg-white my-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square text-primary bg-white my-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square text-primary bg-white my-1" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-square text-primary bg-white my-1" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                        <img class="img-fluid rounded w-100" src="{{ asset('frontend/img/jamadata-dan.jpg') }}" alt="">
                    </div>
                    <div class="px-4 py-3">
                        <h5 class="fw-bold m-0">Dancan Okeyo</h5>
                        <small>Teacher</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="team-item">
                    <div class="d-flex">
                        <div class="flex-shrink-0 d-flex flex-column align-items-center mt-4 pt-5" style="width: 75px;">
                            <a class="btn btn-square text-primary bg-white my-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square text-primary bg-white my-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square text-primary bg-white my-1" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-square text-primary bg-white my-1" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                        <img class="img-fluid rounded w-100" src="{{ asset('frontend/img/emmanuel-mwita.jfif') }}" alt="">
                    </div>
                    <div class="px-4 py-3">
                        <h5 class="fw-bold m-0">Emmanuel Mwita</h5>
                        <small>CEO Rango Technologies</small>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                <div class="team-item">
                    <div class="d-flex">
                        <div class="flex-shrink-0 d-flex flex-column align-items-center mt-4 pt-5" style="width: 75px;">
                            <a class="btn btn-square text-primary bg-white my-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square text-primary bg-white my-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-square text-primary bg-white my-1" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-square text-primary bg-white my-1" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                        <img class="img-fluid rounded w-100" src="{{ asset('frontend/img/team-3.jpg') }}" alt="">
                    </div>
                    <div class="px-4 py-3">
                        <h5 class="fw-bold m-0">Noah Michael</h5>
                        <small>Designer</small>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>

<!-- Team End -->


@endsection
