@extends('backend.layout.master')

@section('title', 'Submit Marks')

@section('content')
<div class="container">
    <h5 class="text-warning">{{ $exam->name }}</h5>

    <form id="marks-form" method="POST" action="{{ route('marks.submit', ['exam' => $exam->id, 'stream' => $stream->id, 'subject' => $subject->id]) }}">
        @csrf

        <input type="hidden" name="exam_id" value="{{ $exam->id }}">
        <input type="hidden" name="stream_id" value="{{ $stream->id }}">
        <input type="hidden" name="subject_id" value="{{ $subject->id }}">

        <div class="row">
            <div class="col-md-6">
                <p>School: {{ $stream->school->name }}</p>
                <p>Stream: {{ $stream->name }}</p>
                <p>Subject: {{ $subject->name }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-sm table-bordered table-hover table-auto">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ADM</th>
                                <th>Name</th>
                                <th>Marks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                @if (!empty($student->marks))
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->adm }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>
                                            <input type="number" name="marks[{{ $student->id }}]" min="0"
                                                max="100" class="form-control marks-input">
                                            <input type="hidden" name="student_ids[]" value="{{ $student->id }}">
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-right">
                <p class="text-muted small">* If a student is missing from this list, submit the already entered marks and contact admin to add the student to the correct school and stream. You can then use the add result link later.</p>
                <button type="button" id="submit-marks" class="btn btn-sm btn-primary">Submit Marks</button>
            </div>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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

        // Handle form submission using AJAX with confirmation
        $('#submit-marks').click(function() {
            // Show confirmation alert
            swal({
                title: "Are you sure?",
                // text: "Once submitted, you will not be able to change the marks!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willSubmit) => {
                if (willSubmit) {
                    // Filter out empty marks inputs before serialization
                    $('.marks-input').each(function() {
                        if ($(this).val() === "") {
                            $(this).removeAttr("name"); // Remove the name attribute for empty inputs
                        }
                    });

                    $(this).prop('disabled', true); // Disable button to prevent multiple submissions

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
                } else {
                    swal("Submission cancelled!");
                }
            });
        });
    });
</script>
@endpush
