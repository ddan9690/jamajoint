@extends('backend.layout.master')
@section('title', 'Create Invoice')
@section('content')

<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Create Invoice</h6>
            <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-primary">Back to Invoices</a>
        </div>
        <div class="card-body">
            <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm">
                @csrf

                <div class="form-group">
                    <label for="school_id">School</label>
                    <select name="school_id" class="form-control @error('school_id') is-invalid @enderror" required>
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                        @endforeach
                    </select>
                    @error('school_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="exam_id">Exam</label>
                    <select name="exam_id" class="form-control @error('exam_id') is-invalid @enderror" required>

                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}">{{ $exam->name }} Term {{ $exam->term }} ({{ $exam->year }})</option>
                        @endforeach
                    </select>
                    @error('exam_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" required>
                    @error('amount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <button type="button" id="createInvoiceButton" class="btn btn-sm btn-primary">Create Invoice</button>
            </form>

        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
    $(document).ready(function() {
        $('#createInvoiceButton').click(function() {
            // Prevent the default form submission behavior
            event.preventDefault();

            // Collect form data
            var formData = $('#invoiceForm').serialize();

            // Send an AJAX request to create the invoice
            $.ajax({
                type: 'POST',
                url: '{{ route('invoices.store') }}',
                data: formData,
                success: function(data) {
                    swal("Invoice created successfully", {
                        icon: "success",
                    }).then(() => {

                        window.location.href = '{{ route('invoices.index') }}';
                    });
                },
                error: function(xhr, status, error) {
                    console.log("Error status: " + status);
                    console.log("Error message: " + error);
                    swal("Oops! Something went wrong.", {
                        icon: "error",
                    });
                }
            });
        });
    });
</script>
@endpush

@endsection
