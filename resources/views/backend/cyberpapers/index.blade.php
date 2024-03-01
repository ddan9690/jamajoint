@extends('backend.layout.master')
@section('title', 'Cyber Space Joint Examination Exam Papers')
@section('content')

    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">CyberSpace Archive</h3>
            </div>
            <div class="card-body">
                @can('super')
                    <a href="{{ route('cyberpapers.create') }}" class="btn btn-sm btn-primary mb-3">Upload Cyber Document</a>
                @endcan

                @if ($cyberpapers->isEmpty())
                    <div class="alert alert-info">
                        No document found.
                    </div>
                @else
                    <div class="table-responsive">
                        <style>
                            /* Prevent text wrapping */
                            .table td,
                            .table th {
                                white-space: nowrap;
                            }
                        </style>
                        <table class="table table-sm table-bordered table-hover">
                            <thead>
                                <tr>


                                    <th>Exam</th>
                                    <th>Date Created</th>
                                    @can('super')
                                        <th>Actions</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cyberpapers as $index => $cyberpaper)
                                    <tr>

                                        <td> <a href="{{ route('cyberpapers.download', $cyberpaper->id) }}">
                                            <i class="fas fa-fw fa-download"></i>
                                        </a> {{ $cyberpaper->name }}</td>
                                        <td>{{ $cyberpaper->created_at->format('d-m-Y') }}</td>

                                        @can('super')
                                            <td>
                                                <form action="{{ route('cyberpapers.destroy', $cyberpaper->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger delete-cyberpaper"
                                                        data-id="{{ $cyberpaper->id }}">
                                                        <i class="fas fa-fw fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>

                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.delete-cyberpaper').on('click', function(e) {
                e.preventDefault();
                var cyberpaperId = $(this).data('id');

                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this paper!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            // User confirmed the delete action
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('cyberpapers.destroy', '') }}" + "/" +
                                    cyberpaperId,
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    _method: "DELETE"
                                },
                                success: function(data) {
                                    swal("Poof! The paper has been deleted!", {
                                        icon: "success",
                                    });
                                    // You can also remove the table row representing the deleted paper
                                    // For example: $(this).closest('tr').remove();
                                    location
                                        .reload(); // Reload the page to update the table
                                },
                                error: function(data) {
                                    swal("Oops! Something went wrong.", {
                                        icon: "error",
                                    });
                                }
                            });
                        } else {
                            swal("The paper is safe!");
                        }
                    });
            });
        });
    </script>
@endpush
