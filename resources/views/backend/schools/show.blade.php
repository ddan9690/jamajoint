@extends('backend.layout.master')
@section('title', 'School Details')
@section('content')
    <style>
        .table-sm td,
        .table-sm th {
            white-space: nowrap;
            padding: 0.5rem;
        }
    </style>
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">School Details</h6>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $school->name }}</p>



                <table class="table table-responsive table-sm table-flush">
                    <thead>
                        <tr>
                            <th>Form</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($forms as $form)
                            <tr>
                                <td>Form {{ $form->name }}</td>
                                <td>

                                    <a href="{{ route('forms.show', ['schoolId' => $school->id, 'form' => $form->id]) }} " class="btn btn-sm btn-success">View</a>
                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>


                <!-- School Users -->
                @if ($school->users->isNotEmpty())
                    <div class="mt-4">
                        <h6 class="font-weight-bold text-primary">School Teachers</h6>
                        <table class="table table-responsive table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    @can('admin')
                                        <th>Phone</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($school->users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        @can('admin')
                                            <td>{{ $user->phone }}</td>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No teachers found for this school.</p>
                @endif
            </div>
        </div>
    </div>


    <!-- Add Stream Modal -->
    <div class="modal fade" id="createStreamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Stream</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createStreamForm">
                        @csrf

                        <div class="form-group">
                            <label for="name">Stream Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <input type="hidden" name="school_id" value="{{ $school->id }}">

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-primary">Add Stream</button>
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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

    <script>
        $(document).ready(function() {
            $('#createStreamForm').submit(function(e) {
                e.preventDefault();

                var form = $(this);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('streams.store') }}',
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#createStreamModal').modal('hide');
                        toastr.success(response.message, '', {
                            timeOut: 3000
                        });
                        location.reload();

                    },
                    error: function(error) {
                        toastr.error(error.responseJSON.message, '', {
                            timeOut: 3000
                        });

                    }
                });
            });

            $('.delete-link').click(function(e) {
                e.preventDefault();

                var streamId = $(this).data('id');
                var deleteUrl = '{{ route('streams.destroy', '') }}/' + streamId;

                if (confirm('Are you sure you want to delete this stream?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: deleteUrl,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            toastr.success(response.message, '', {
                                timeOut: 3000
                            });

                        },
                        error: function(error) {
                            toastr.error(error.responseJSON.message, '', {
                                timeOut: 3000
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
