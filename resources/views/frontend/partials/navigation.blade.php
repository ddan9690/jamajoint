<!-- Navbar & Hero Start -->
<div class="container-xxl position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
        <a href="" class="navbar-brand p-0">
            <h1 class="m-0"><i class="fa fa-graduation-cap me-2"></i>Jama<span>Joint</span></h1>
            <!-- <img src="img/logo.png" alt="Logo"> -->

        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="#" class="nav-item nav-link active">Home</a>
                <a href="#" class="nav-item nav-link">About</a>
                <a href="#" class="nav-item nav-link">Features</a>
                <a href="#" class="nav-item nav-link">Analysis</a>
                <a href="#" class="nav-item nav-link">Contact</a>
            </div>
            <button type="button" class="btn text-secondary ms-3" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fa fa-search"></i></button>
            <a href="#" class="btn btn-secondary text-light rounded-pill py-2 px-4 ms-3">Free Demo</a>
        </div>
    </nav>

    <div class="container-xxl py-5 bg-primary hero-header mb-5">
        <div class="container my-5 py-5 px-lg-5">
            <div class="row g-5 py-5">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="text-white mb-4 animated zoomIn">Revolutionizing Joint Exam Analysis for High School Teachers</h1>
                    <p class="text-white pb-3 animated zoomIn">Empower your teaching with JamaJoint - the all-in-one solution for meticulous examination analysis. Say goodbye to manual processes and Excel headaches.</p>
                    <a href="{{route('dashboard')}}" class="btn btn-light py-sm-3 px-sm-5 rounded-pill me-3 animated slideInLeft">Get Started</a>
                    <a href="#" class="btn btn-outline-light py-sm-3 px-sm-5 rounded-pill animated slideInRight">Contact Us</a>
                </div>
                <div class="col-lg-6 text-center text-lg-start">
                    <img class="img-fluid" src="{{ asset('path/to/jamajoint-hero-image.png') }}" alt="JamaJoint Image">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Navbar & Hero End -->

<!-- Full Screen Search Start -->
<div class="modal fade" id="searchModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content" style="background: rgba(29, 29, 39, 0.7);">
            <div class="modal-header border-0">
                <button type="button" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center justify-content-center">
                <div class="input-group" style="max-width: 600px;">
                    <input type="text" class="form-control bg-transparent border-light p-3" placeholder="Type search keyword">
                    <button class="btn btn-light px-4"><i class="bi bi-search"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Full Screen Search End -->
