<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>JamaJoint - Revolutionizing High School Exam Analysis: Joint Exams, CATs, and RATs Simplified</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="JamaJoint, Exam Analysis, Teachers, Departmental Examinations, Joint Examinations, CATs, RATs, Meticulous Analysis, High School, Secondary School">
    <meta name="description" content="JamaJoint - Your platform for comprehensive and quick exam analysis tailored for teachers. Effortlessly analyze student results for joint and internal departmental examinations, CATs, and RATs. Empower teachers with insightful performance analytics, efficient analysis tools, and streamlined processes. Say goodbye to manual tasks and embrace the simplicity of education analysis with JamaJoint.">


    <meta name="msapplication-TileColor" content="#ffffff">

     <!-- Favicon -->
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend/img/favicon/favicon-16x16.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend/img/favicon/favicon-32x32.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/img/favicon/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('frontend/img/favicon/android-chrome-192x192.png') }}">
<link rel="icon" type="image/png" sizes="512x512" href="{{ asset('frontend/img/favicon/android-chrome-512x512.png') }}">
<link rel="icon" type="image/x-icon" href="{{ asset('frontend/img/favicon/favicon.ico') }}">
<link rel="manifest" href="{{ asset('frontend/img/favicon/site.webmanifest') }}">

    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/css/ruang-admin.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

    <!-- Google Tag Manager -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-K2C0JLQK0D"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-K2C0JLQK0D');
    </script>
    <!-- End Google Tag Manager -->

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9496284073317725"
        crossorigin="anonymous"></script>
</head>



<body class="bg-gradient-login">
    <!-- Register Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <a href="/" class="navbar-brand">
                                            <img src="{{ asset('frontend/img/jamajoint-logo.png') }}"
                                                alt="Cyberspace Logo" width="150px">
                                        </a>
                                        <h1 class="h4 text-gray-900 mb-4">Register</h1>

                                    </div>

                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf

                                        <div class="form-group">
                                            <label for="exampleInputName">Name</label>
                                            <input type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                id="exampleInputName" name="name" value="{{ old('name') }}"
                                                placeholder="Enter your names" required autofocus>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputSchool">School</label>
                                            <span style="color: green;">(If your school is not listed, contact
                                                admin)</span>
                                            <select class="form-control" id="exampleInputSchool" name="school_id"
                                                placeholder="Select a school">
                                                <option value="" disabled>Select a school</option>
                                                @foreach ($schools as $school)
                                                    <option value="{{ $school->id }}"
                                                        {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                                        {{ $school->name }}-{{ $school->county }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="exampleInputPhone">Phone</label>
                                            <input type="tel"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                id="exampleInputPhone" name="phone" value="{{ old('phone') }}"
                                                placeholder="Enter your phone number" required>
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail">Email</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                id="exampleInputEmail" name="email" value="{{ old('email') }}"
                                                placeholder="Enter your email address" required>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputPassword">Password</label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="exampleInputPassword" name="password"
                                                placeholder="Enter your password" required
                                                value="{{ old('password') }}">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputPasswordRepeat">Repeat Password</label>
                                            <input type="password"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                id="exampleInputPasswordRepeat" name="password_confirmation"
                                                placeholder="Repeat your password" required
                                                value="{{ old('password_confirmation') }}">

                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                                        </div>

                                        <hr>
                                    </form>



                                    <hr>
                                    <div class="text-center">
                                        <a class="font-weight-bold small" href="{{ route('login') }}">Already have an
                                            account? Login</a>
                                    </div>
                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Content -->
    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('backend/js/ruang-admin.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 on the school select element
            $('#exampleInputSchool').select2({
                placeholder: "Select a school", // Set a placeholder text
                allowClear: true, // Allow clearing the selected option

            });
        });
    </script>
</body>

</html>
