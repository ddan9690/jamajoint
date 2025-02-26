<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="history, login, government, education, teachers, students, KCSE preparation, joint, form 3,analysis, hocha" name="keywords">
    <meta content="CyberSpace offers a platform for teachers to assess their History and Government students, providing valuable insights and performance comparisons with other schools. Our comprehensive examination analysis helps prepare candidates for their upcoming KCSE exams." name="description">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('backend/img/logo/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('backend/img/logo/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('backend/img/logo/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('backend/img/logo/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('backend/img/logo/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <title>CyberSpace History National Joint - Forgot Password</title>
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/css/ruang-admin.min.css') }}" rel="stylesheet">

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

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9496284073317725" crossorigin="anonymous"></script>
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
                                                <img src="{{ asset('backend/img/logo/cyberspace-national-joint-logo.png') }}" alt="Cyberspace Logo" width="100px">
                                            </a>
                                            <h1 class="h4 text-gray-900 mb-4">Forgot Password</h1>
                                        </div>
                                    </div>

                                    <div class="mb-4 text-sm text-gray-600">
                                        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                                    </div>

                                    <!-- Session Status -->
                                    <x-auth-session-status class="mb-4" :status="session('status')" />

                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf

                                        <!-- Email Address -->
                                        <div class="form-group">
                                            <label for="email">{{ __('Email') }}</label>
                                            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                                            @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="flex items-center justify-end mt-4">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                {{ __('Email Password Reset Link') }}
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
    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('backend/js/ruang-admin.min.js') }}"></script>
</body>

</html>
