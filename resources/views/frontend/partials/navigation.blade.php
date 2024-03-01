<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0">
    <a href="/" class="navbar-brand d-flex align-items-center border-end px-4 px-lg-5">
        <img src="{{ asset('frontend/img/cyberspace-national-joint-logo.png') }}" alt="Cyberspace Logo" width="50" height="50">
        {{-- <h2 class="m-0">CYBERSPACE</h2> --}}

    </a>
    <img src="{{ asset('frontend/img/kenya.gif') }}" alt="Kenya GIF" class="mr-2" width="50" height="50">

    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="/" class="nav-item nav-link active">Home</a>



            {{-- <a href="/blog" class="nav-item nav-link">Blog</a> --}}
            <a href="/hocha" class="nav-item nav-link">Hocha</a>
            <a href="{{ route('cyberspace.news') }}" class="nav-item nav-link">News</a>
            @if(auth()->check()) <!-- Check if the user is logged in -->
                <a href="{{ route('dashboard') }}" class="nav-item nav-link">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-sm btn-primary py-4 px-lg-5 ">Log In<i class="fa fa-arrow-right ms-3"></i></a>
            @endif
        </div>
    </div>
</nav>
<!-- Navbar End -->
