<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="JamaJoint, Exam Analysis, High School, Secondary School, Teachers, Departmental Examinations, Joint Examinations, CATs, RATs, Meticulous Analysis">
    <meta name="description" content="JamaJoint - Your platform for comprehensive and quick exam analysis tailored for teachers. Effortlessly analyze student results for joint and internal departmental examinations, CATs, and RATs. Empower teachers with insightful performance analytics, efficient analysis tools, and streamlined processes. Say goodbye to manual tasks and embrace the simplicity of education analysis with JamaJoint.">


    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend/img/favicon/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend/img/favicon/favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('frontend/img/favicon/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('frontend/img/favicon/android-chrome-512x512.png') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend/img/favicon/favicon.ico') }}">
    <link rel="manifest" href="{{ asset('frontend/img/favicon/site.webmanifest') }}">

    <title>@yield('title', 'JamaJoint:: Analysis Portal')</title>
    <link href="{{ asset('backend/vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/css/ruang-admin.min.css') }}" rel="stylesheet">
    <link href="{{ asset("backend/vendor/datatables/dataTables.bootstrap4.min.css") }}" rel="stylesheet">

    @stack('styles')

    <!-- Google Analytics Tag -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-K2C0JLQK0D"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-K2C0JLQK0D');
    </script>
    <!-- End Google Analytics Tag -->

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9496284073317725"
     crossorigin="anonymous"></script>
</head>

