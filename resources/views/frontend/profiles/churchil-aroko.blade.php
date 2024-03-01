@extends('frontend.layout.master')

@section('title', 'Cyberspace :: Churchill Aroko Profile')

@section('description', 'Churchill Aroko is an esteemed educator specializing in History and Government. He currently serves as a dedicated teacher at Homa Bay High School, where his profound influence and contributions have left an indelible mark.')

@section('content')

<div class="container-xxl py-6">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <img src="{{ asset('frontend/img/churchil.jpg') }}" alt="Churchill Aroko" class="img-fluid rounded-circle">
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <h1>Churchill Aroko Profile</h1>
                <p>Churchill Aroko is an esteemed educator specializing in History and Government. He currently serves as a dedicated teacher at Homa Bay High School, where his profound influence and contributions have left an indelible mark.</p>
                <p>With over 15 years of unwavering dedication to the teaching profession, Churchill Aroko has risen to prominence as a leading figure in the field. His remarkable journey has seen him take on the pivotal role of heading the Humanities Department at his institution.</p>
                <p>One of Churchill's most notable distinctions lies in his expertise as an examiner for History and Government Paper 2. His extensive knowledge of the subject matter and steadfast commitment to his students consistently yield exceptional academic outcomes.</p>
            </div>
        </div>
    </div>
</div>
@endsection
