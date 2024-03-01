@extends('backend.layout.master')
@section('title', 'Enter OTP')
@section('content')

<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Enter the OTP sent to your email </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('verify-otp') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="otp">Enter OTP</label>
                    <input type="text" name="otp" class="form-control" required>
                </div>
                <!-- Add any additional fields or information needed for OTP verification here -->
                <button type="submit" class="btn btn-sm btn-primary">Submit OTP</button>
            </form>
        </div>
    </div>
</div>

@endsection
