<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="JamaJoint, Exam Analysis, High School, Secondary School, Teachers, Departmental Examinations, Joint Examinations, CATs, RATs, Meticulous Analysis">
    <meta name="description" content="JamaJoint - Your platform for comprehensive and quick exam analysis tailored for teachers. Effortlessly analyze student results for joint and internal departmental examinations, CATs, and RATs. Empower teachers with insightful performance analytics, efficient analysis tools, and streamlined processes. Say goodbye to manual tasks and embrace the simplicity of education analysis with JamaJoint.">


        <!-- Favicon -->
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend/img/favicon/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend/img/favicon/favicon-32x32.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/img/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('frontend/img/favicon/android-chrome-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('frontend/img/favicon/android-chrome-512x512.png') }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('frontend/img/favicon/favicon.ico') }}">
        <link rel="manifest" href="{{ asset('frontend/img/favicon/site.webmanifest') }}">

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <title>JamaJoint - Revolutionizing High School Exam Analysis: Joint Exams, CATs, and RATs Simplified</title>

    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/css/ruang-admin.min.css') }}" rel="stylesheet">

    <!-- Google Tag Manager -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-K2C0JLQK0D"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-K2C0JLQK0D');
    </script>
    <!-- End Google Tag Manager -->

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9496284073317725"
        crossorigin="anonymous"></script>
</head>



<body class="bg-gradient-login">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">

                                        <div class="text-center">
                                            <a href="/" class="navbar-brand">
                                                <img src="{{ asset('frontend/img/jamajoint-logo.png') }}"
                                                    alt="Cyberspace Logo" width="150px">
                                            </a>
                                            <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                            @if (session('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif


                                    </div>
                                    <form class="user" method="POST" action="{{ route('login') }}">
                                        @csrf

                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <div class="form-group">

                                            <label for="exampleInputEmail">Email Address</label>

                                            <input type="email" name="email" class="form-control"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address" value="{{ old('email') }}">

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword">Password</label>
                                            <input type="password" name="password" class="form-control"
                                                id="exampleInputPassword" placeholder="Password"
                                                value="{{ old('password') }}">
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small"
                                                style="line-height: 1.5rem;">
                                                <input type="checkbox" class="custom-control-input" id="customCheck"
                                                    name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                                        </div>
                                        <hr>
                                        {{-- <div class="text-center">
                                            @if (Route::has('password.request'))
                                                <a class="text-muted text-sm" href="{{ route('password.request') }}">
                                                    {{ __('Forgot your password?') }}
                                                </a>
                                            @endif
                                        </div> --}}

                                    </form>



                                    <a class="lost-pass" href="{{ route('forget.password.get') }}">
                                        Forgot Password?
                                    </a>


                                    <hr>
                                    <div class="text-center">
                                        <a class="btn btn-success btn-block" href="{{ route('register') }}">Create an
                                            Account</a>
                                    </div>
                                    <div class="text-center">
                                        {{-- <a href="{{ route('login.facebook') }}"
                                            class="btn btn-primary btn-block">Register with Facebook</a> --}}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content -->
    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('backend/js/ruang-admin.min.js') }}"></script>
</body>

</html>
