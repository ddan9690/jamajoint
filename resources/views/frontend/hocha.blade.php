@extends('frontend.layout.master')
@section('title', 'Homa Bay County History Association (HOCHA)')

@section('content')
<!-- Page Header Start -->
<section class="page-header">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center">
                    <h1 class="display-4">Homa Bay County History Association (HOCHA): Illuminating the Path of History</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Page Header End -->

<!-- Introduction Start -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p class="lead">In the heart of Homa Bay County, an idea was conceived—an idea that would ignite the study of History and Government in schools across the region. Homa Bay County History Association (HOCHA) emerged as a powerful catalyst for change. What began as a localized initiative has since evolved into an educational force of remarkable proportions.</p>
            </div>
        </div>
    </div>
</section>
<!-- Introduction End -->

<!-- Legacy of Excellence Start -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="mb-4">A Legacy of Excellence</h2>
                <p>HOCHA boasts a legacy that spans over a decade, firmly establishing itself as a prestigious joint examination for Form 4 students. It has garnered a reputation as one of the most trusted History and Government examinations. The association's commitment to academic excellence has consistently guided students and teachers alike towards success.</p>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('frontend/img/hocha/legacy-of-excellnce.png') }}" alt="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>
<!-- Legacy of Excellence End -->

<!-- Uniting Schools Start -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="mb-4">Uniting Schools, Nurturing Collaboration</h2>
                <p>One of HOCHA's distinctive features is its ability to bring schools from diverse regions together. It places a strong emphasis on physical marking sessions, fostering invaluable collaboration among teachers. This unique approach allows educators to exchange insights, ideas, and best practices, enriching the educational experience for all involved.</p>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('frontend/img/hocha/naturing-collaboration.png') }}" alt="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>
<!-- Uniting Schools End -->

<!-- Expanding Horizons Start -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="mb-4">Expanding Horizons</h2>
                <p>As testament to its growth, HOCHA now draws participants from not only Homa Bay County but also the broader regions of Nyanza, Western, and the Rift Valley. The association's reach has expanded exponentially, illuminating the educational landscape with the light of knowledge.</p>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('frontend/img/hocha/globe.png') }}" alt="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>
<!-- Expanding Horizons End -->

<!-- Conclusion Start -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <p>HOCHA is more than just an examination—it's a beacon of educational excellence, uniting schools and students while shaping the future of History and Government studies in the region. Contact us at 0729804932 for more information.</p>
            </div>
        </div>
    </div>
</section>

<!-- Conclusion End -->

@endsection
