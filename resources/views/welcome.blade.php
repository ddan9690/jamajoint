@extends('frontend.layout.master')
@section('title', 'Cyberspace :: Home')

@section('content')

<div class="container-xxl py-6">
    <div class="container text-center">
        @guest
            <!-- Display message for not logged in users -->
            <h1 class="display-4 mb-4">You are not logged in</h1>
            <p class="lead mb-4">Click here to <a href="{{ route('login') }}">log in</a> or <a href="{{ route('register') }}">create an account</a>.</p>
        @else
            <!-- Display link to dashboard for logged in users -->
            <h1 class="display-4 mb-4">Welcome, <strong>{{ Auth::user()->name }}</strong></h1>
            <p class="lead mb-4">Click <a href="{{ route('dashboard') }}">here</a> to go to Exams.</p>
        @endguest
    </div>
</div>

<!-- Copyright statement -->
<footer class="container text-center mt-4">
    <p>&copy; 2024 <span class="text-info">Jamadata</span>. All rights reserved.</p>
</footer>

@endsection
