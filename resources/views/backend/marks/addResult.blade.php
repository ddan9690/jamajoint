@extends('backend.layout.master')

@section('title', 'Add Result')

@section('content')
<div class="container">
    <h5 class="text-warning">{{ $exam->name }}</h5>
    <p>School: {{ $stream->school->name }}</p>
    <p>Stream: {{ $stream->name }}</p>
    <p>Subject: {{ $subject->name }}</p>

    <form id="marks-form" method="POST" action="{{ route('marks.storeAddedMark', ['exam' => $exam->id, 'stream' => $stream->id, 'subject' => $subject->id]) }}">
        @csrf

        <input type="hidden" name="exam_id" value="{{ $exam->id }}">
        <input type="hidden" name="stream_id" value="{{ $stream->id }}">
        <input type="hidden" name="subject_id" value="{{ $subject->id }}">

        @if ($studentsWithoutMarks->isEmpty())
            <p class="alert alert-info">No students found without marks from this stream {{ $stream->name }} </p>
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ADM</th>
                                    <th>Name</th>
                                    <th>Marks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($studentsWithoutMarks as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->adm }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>
                                            <input type="number" name="marks[{{ $student->id }}]" min="0" max="100" class="form-control marks-input">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-sm btn-primary" id="submit-marks">Submit Marks</button>
                </div>
            </div>
        @endif
    </form>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

<script>
    $(document).ready(function() {
        // Handle Enter key press to navigate to the next input
        $('.marks-input').on('keypress', function(e) {
            if (e.key === "Enter") {
                e.preventDefault();
                var inputs = $('.marks-input');
                var currentIndex = inputs.index(this);
                if (currentIndex < inputs.length - 1) {
                    inputs[currentIndex + 1].focus();
                }
            }
        });

        // Handle form submission using AJAX
        $('#submit-marks').click(function() {
            // Filter out empty marks inputs before serialization
            $('.form-control').each(function() {
                if ($(this).val() === "") {
                    $(this).removeAttr("name"); // Remove the name attribute for empty inputs
                }
            });

            $(this).prop('disabled', true);

            $.ajax({
                type: 'POST',
                url: $('#marks-form').attr('action'),
                data: $('#marks-form').serialize(),
                success: function(response) {
                    $('#submit-marks').prop('disabled', false);
                    swal("Success!", "Marks have been submitted successfully!", "success").then(function() {
                        // Redirect to a new page or perform any other action as needed
                        window.location.href = "{{ route('marks.index', ['exam' => $exam->id, 'stream' => $stream->id, 'subject' => $subject->id]) }}";
                    });
                },
                error: function(xhr) {
                    console.log(xhr);
                    $('#submit-marks').prop('disabled', false);
                    swal("Oops! Something went wrong.", "Please try again later.", "error");
                }
            });
        });
    });
</script>
@endpush
@endsection
