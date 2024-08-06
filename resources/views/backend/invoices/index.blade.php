@extends('backend.layout.master')
@section('title', 'Invoice List')
@section('content')
<style>
    .table-sm td,
    .table-sm th {
        white-space: nowrap !important;
        padding: 0.5rem;
    }
</style>

<div class="col">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Invoice List</h6>
            <a href="{{ route('invoices.create') }}" class="btn btn-sm btn-primary">Create Invoice</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type of="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <table class="table table-sm align-items-center table-responsive" id="invoices">
                <thead>
                    <tr>
                        <th>Invoice No.</th>
                        <th>School</th>
                        <th>Exam</th>
                        <th>Amount</th>
                        <th>Delete</th>
                        <!-- Add more table headers for other invoice attributes if needed -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                        <tr>
                            <td> <a href="{{ route('invoice.pdf', $invoice->id) }}">
                                <i class="fas fa-download"></i>
                            </a>{{ $invoice->invoice_number }}</td>
                            <td>{{ $invoice->school->name }}</td>
                            <td>{{ $invoice->exam->name }} T{{ $invoice->exam->term }}-{{ $invoice->exam->year }}</td>
                            <td>KSh {{ number_format($invoice->amount) }}</td>
                            <td>
                                <!-- "Delete" button with SweetAlert confirmation -->
                                <button class="btn btn-danger btn-sm delete-invoice" data-id="{{ $invoice->id }}">Delete</button>
                            </td>
                            <!-- Add more table data cells for other invoice attributes if needed -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        $('#invoices').DataTable();


        $('.delete-invoice').click(function() {
            var invoiceId = $(this).data('id');

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this invoice!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {

                    var deleteUrl = '/manage/invoices/' + invoiceId;

                    $.ajax({
                        type: 'POST',
                        url: deleteUrl,
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE',
                        },
                        success: function(data) {
                            swal("The invoice has been deleted successfully", {
                                icon: "success",
                            });

                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.log("Error status: " + status);
                            console.log("Error message: " + error);
                            swal("Oops! Something went wrong.", {
                                icon: "error",
                            });
                        }
                    });
                } else {
                    swal("The invoice is safe!");
                }
            });
        });
    });
</script>

@endpush





