<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta
        content="CyberSpace offers a platform for teachers to assess their History and Government students, providing valuable insights and performance comparisons with other schools. Our comprehensive examination analysis helps prepare candidates for their upcoming KCSE exams."
        name="description">

    <meta content="history, government, education, teachers, students, KCSE preparation, joint, form 3,analysis, hocha"
        name="keywords">

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('backend/img/logo/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('backend/img/logo/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('backend/img/logo/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('backend/img/logo/site.webmanifest') }}">
        <link rel="mask-icon" href="{{ asset('backend/img/logo/safari-pinned-tab.svg') }}" color="#5bbad5">

  <title>@yield('title', 'JamaJoint')</title>
  <link href="{{ asset('backend/vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('backend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('backend/css/ruang-admin.min.css') }}" rel="stylesheet">
  <link href="{{ asset("backend/vendor/datatables/dataTables.bootstrap4.min.css") }}" rel="stylesheet">


  @stack('styles')

<!-- Google Analytics Tag -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-1J9G6J28CV"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-1J9G6J28CV');
</script>
<!-- End Google Analytics Tag -->

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9496284073317725"
     crossorigin="anonymous"></script>
</head>
