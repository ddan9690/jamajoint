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

    <title>JamJoint- Verify Email</title>
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('backend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"
        type="text css">
    <link href="{{ asset('backend/css/ruang-admin.min.css') }}" rel="stylesheet">

    <!-- Google Tag Manager -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-K2C0JLQK0D"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-K2C0JLQK0D');
    </script>
    <!-- End Google Tag Manager -->

    <script async
        src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9496284073317725"
        crossorigin="anonymous"></script>
</head>

<body class="bg-gradient-login">
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
                                            <h1 class="h4 text-gray-900 mb-4">Email Verification</h1>
                                        </div>
                                    </div>

                                    <div class="mb-4 text-sm text-gray-600">
                                        {{ __('Thanks for joining JamaJoint. Please verify your email address by clicking on
                                        the link we just emailed to you. If you didn\'t receive the email, we will gladly
                                        send you another.') }}
                                    </div>

                                    <div class="mt-4 flex items-center justify-between">
                                        <form method="POST" action="{{ route('verification.send') }}">
                                            @csrf
                                            <div>
                                                <button type="submit" class="btn btn-primary btn-block">
                                                    {{ __('Resend Verification Email') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('backend/js/ruang-admin.min.js') }}"></script>
</body>

</html>
