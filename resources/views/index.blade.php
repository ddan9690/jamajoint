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
                    <h2 class="mt-2">Revolutionizing Joint Exam Analysis for High School Teachers</h2>
                </div>
                <p class="mb-4">JamaJoint is your comprehensive solution for joint exam analysis, designed to empower high school teachers. Say goodbye to manual processes and Excel headaches. Our platform ensures meticulous examination analysis, providing accurate insights into school, stream, and student performances.</p>
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
                <div class="d-flex align-items-center mt-4">
                    <a class="btn btn-primary rounded-pill px-4 me-3" href="">Learn More</a>
                    <a class="btn btn-outline-primary btn-square me-3" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-primary btn-square me-3" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-primary btn-square me-3" href=""><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-outline-primary btn-square" href=""><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-6">
                <img class="img-fluid wow zoomIn" data-wow-delay="0.5s" src="{{ asset('path/to/jamajoint-about-image.jpg') }}">
            </div>
        </div>
    </div>
</div>

<!-- About End -->


<!-- Newsletter Start -->
<div class="container-xxl bg-primary newsletter my-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container px-lg-5">
        <div class="row align-items-center" style="min-height: 250px;">
            <div class="col-12 col-md-6">
                <h3 class="text-white">Stay Informed with JamaJoint</h3>
                <small class="text-white">Get the latest updates and insights on joint exam analysis.</small>
                <div class="position-relative w-100 mt-3">
                    <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="email" placeholder="Enter Your Email" style="height: 48px;" required>
                    <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i class="fa fa-paper-plane text-primary fs-4"></i></button>
                </div>
            </div>
            <div class="col-md-6 text-center mb-n5 d-none d-md-block">
                <img class="img-fluid mt-5" style="height: 250px;" src="{{ asset('path/to/jamajoint-newsletter-image.png') }}" alt="JamaJoint Newsletter">
            </div>
        </div>
    </div>
</div>

<!-- Newsletter End -->


<!-- Service Start -->
<div class="container-xxl py-5">
    <div class="container px-lg-5">
        <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="position-relative d-inline text-primary ps-4">Our Services</h6>
            <h2 class="mt-2">Empowering Education with JamaJoint</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.1s">
                <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                    <div class="service-icon flex-shrink-0">
                        <i class="fa fa-search fa-2x"></i>
                    </div>
                    <h5 class="mb-3">Joint Exam Analysis</h5>
                    <p>Revolutionize the way you analyze joint exams. Meticulous examination analysis, eliminating errors and providing comprehensive reports.</p>
                    <a class="btn px-3 mt-auto mx-auto" href="#">Learn More</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.3s">
                <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                    <div class="service-icon flex-shrink-0">
                        <i class="fa fa-chart-bar fa-2x"></i>
                    </div>
                    <h5 class="mb-3">Performance Insights</h5>
                    <p>Unlock valuable insights into school ranking, stream analysis, overall student ranking, and paper-wise analysis.</p>
                    <a class="btn px-3 mt-auto mx-auto" href="#">Discover More</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.6s">
                <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                    <div class="service-icon flex-shrink-0">
                        <i class="fa fa-cogs fa-2x"></i>
                    </div>
                    <h5 class="mb-3">User-Friendly Platform</h5>
                    <p>Simplify your joint analysis with JamaJoint. Just create exams, input marks, and publish effortlessly.</p>
                    <a class="btn px-3 mt-auto mx-auto" href="#">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Service End -->


<!-- Portfolio Start -->
<div class="container-xxl py-5">
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
</div>
<!-- Portfolio End -->


<!-- Testimonial Start -->
<div class="container-xxl bg-primary testimonial py-5 my-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container py-5 px-lg-5">
        <div class="owl-carousel testimonial-carousel">
            <div class="testimonial-item bg-transparent border rounded text-white p-4">
                <i class="fa fa-quote-left fa-2x mb-3"></i>
                <p>JamaJoint has truly transformed the way we handle joint exam analysis. The platform's accuracy and user-friendly interface have made the process seamless. It has become an essential tool for our school's success.</p>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0 rounded-circle" src="{{ asset('frontend/img/testimonial-1.jpg') }}" style="width: 50px; height: 50px;" alt="Client Image">
                    <div class="ps-3">
                        <h6 class="text-white mb-1">John Doe</h6>
                        <small>High School Teacher</small>
                    </div>
                </div>
            </div>
            <div class="testimonial-item bg-transparent border rounded text-white p-4">
                <i class="fa fa-quote-left fa-2x mb-3"></i>
                <p>Using JamaJoint has been a game-changer for us. The detailed analysis reports and insights provided have helped us identify areas of improvement and celebrate our successes. It's a must-have tool for any high school teacher.</p>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0 rounded-circle" src="{{ asset('frontend/img/testimonial-2.jpg') }}" style="width: 50px; height: 50px;" alt="Client Image">
                    <div class="ps-3">
                        <h6 class="text-white mb-1">Jane Smith</h6>
                        <small>Subject Coordinator</small>
                    </div>
                </div>
            </div>
            <div class="testimonial-item bg-transparent border rounded text-white p-4">
                <i class="fa fa-quote-left fa-2x mb-3"></i>
                <p>We have been using JamaJoint for several years now, and it has become an integral part of our examination process. The platform's reliability and the ability to generate comprehensive reports make it an invaluable asset for our educational institution.</p>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0 rounded-circle" src="{{ asset('frontend/img/testimonial-3.jpg') }}" style="width: 50px; height: 50px;" alt="Client Image">
                    <div class="ps-3">
                        <h6 class="text-white mb-1">Robert Johnson</h6>
                        <small>School Administrator</small>
                    </div>
                </div>
            </div>
            <div class="testimonial-item bg-transparent border rounded text-white p-4">
                <i class="fa fa-quote-left fa-2x mb-3"></i>
                <p>JamaJoint has simplified our examination analysis process, allowing us to focus more on enhancing our teaching methods. The user-friendly platform and insightful reports have positively impacted our school's overall academic performance.</p>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0 rounded-circle" src="{{ asset('frontend/img/testimonial-4.jpg') }}" style="width: 50px; height: 50px;" alt="Client Image">
                    <div class="ps-3">
                        <h6 class="text-white mb-1">Maria Rodriguez</h6>
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
                        <img class="img-fluid rounded w-100" src="{{ asset('frontend/img/dancan.jpg') }}" alt="">
                    </div>
                    <div class="px-4 py-3">
                        <h5 class="fw-bold m-0">Dancan Okeyo</h5>
                        <small>Founder</small>
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
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
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
            </div>
        </div>
    </div>
</div>

<!-- Team End -->


@endsection
