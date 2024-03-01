@extends('frontend.layout.master')
@section('title', 'Homa Bay County History Association (HOCHA)')

@section('content')
<!-- Page Header Start -->
<section class="page-header">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center">
                    <h1 class="display-4"></h1>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Page Header End -->



<!-- Legacy of Excellence Start -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="mb-4">News Center</h2>
                <ul class="list-group">
                    @foreach ($news as $item)
                        <li class="list-group-item">
                            <a class="text-decoration-none" href="{{ route('news.show', ['id' => $item->id, 'slug' => $item->slug]) }}">{{ $item->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Legacy of Excellence End -->





<!-- Conclusion Start -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <img src="{{ asset('frontend/img/ads/advert.png') }}" alt="Advertisement Image" style="width: 250px" class="animate__animated animate__pulse animate__infinite	infinite">
                <p>For Advertising Inquiries, Contact: <a href="mailto:ddan9690@gmail.com" class="text-white">ddan9690@gmail.com</a></p>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
@endpush
