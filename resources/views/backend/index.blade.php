@extends('backend.layout.master')
@section('title', 'JamaJoint : : Dashboard')
@section('content')
<div class="container">
    @if (count($exams) > 0)
        <div class="row">
            @foreach ($exams as $exam)
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="font-weight-bold text-uppercase mb-1">{{ $exam->name }} Form {{ $exam->form->name }}</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Term {{ $exam->term }} - {{ $exam->year }}
                                    </div>
                                    <div class="mt-2 mb-0 text-muted text-xs">
                                        @if ($exam->published === 'yes')
                                            <a href="{{ route('results.index', ['id' => $exam->id, 'slug' => $exam->slug]) }}" class="btn btn-sm btn-success btn-block">View Results</a>
                                        @else
                                            <a href="" data-exam-id="{{ $exam->id }}" class="btn btn-sm btn-primary btn-block check-registration">Submit Marks</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">

            </div>
        </div>
    @else
        <div class="text-center">
            <h3></h3>
            <div class="alert alert-light" role="alert">
                No active or processed exam...
              </div>
        </div>
    @endif
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-KyZXEAg3QhqLMpG8r+pdLy5Brj0cug3gykgzJsTp4Pw/uh9mdQ6oSYsU4sLYFvcw5kg2P0coT+Lqk0Oa9CoC1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {

            toastr.options = {
                positionClass: 'toast-top-center', // Set the position to top center
            };
            $('.check-registration').on('click', function(e) {
                e.preventDefault();
                var examId = $(this).data('exam-id');

                // Send an Ajax request to check if the school is registered for the exam
                $.ajax({
                    type: 'GET',
                    url: '{{ route('checkRegistrationStatus', ['exam' => ':examId']) }}'.replace(
                        ':examId', examId),
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.registered) {
                            // If registered, proceed to the marks index page
                            window.location.href =
                                '{{ route('marks.index', ['exam' => ':examId']) }}'.replace(
                                    ':examId', examId);
                        } else {
                            // If not registered, show a Toastr alert
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Log the error message to the console
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endpush
