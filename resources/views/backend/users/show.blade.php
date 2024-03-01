@extends('backend.layout.master')
@section('title', 'User Details')
@section('content')

<div class="col-lg-12">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">User Details</h6>
        </div>
        <div class="card-body">
            <!-- Check for success message and display it -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <ul>
                <li><strong>Name:</strong> {{ $user->name }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Phone:</strong> {{ $user->phone }}</li>
                <li><strong>School:</strong> {{ $user->school ? $user->school->name : '-' }}</li>
            </ul>
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary">Back to User Index</a>

            <!-- Button to reset password -->
            <button
                class="btn btn-sm btn-warning reset-password"
                data-id="{{ $user->id }}"
                data-url="{{ route('users.reset-password', $user->id) }}"
            >
                Reset Password
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
$(document).ready(function () {
    // Handle Reset Password with SweetAlert
    $('.reset-password').click(function () {
        var userId = $(this).data('id');
        var resetUrl = $(this).data('url');

        // Show SweetAlert confirmation
        swal({
            title: 'Are you sure?',
            text: 'This will reset the user\'s password to "cyberspace".',
            icon: 'warning',
            buttons: ['Cancel', 'Reset'],
            dangerMode: true,
        }).then((willReset) => {
            if (willReset) {
                // Send AJAX POST request to reset the user's password
                $.ajax({
                    type: 'POST',
                    url: resetUrl,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        swal('Password reset successfully to "cyberspace"', {
                            icon: 'success',
                        });
                    },
                    error: function (error) {
                        console.log(error);
                        swal('Error!', 'Failed to reset password', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
