@extends('backend.layout.master')
@section('title', 'New School')
@section('content')
    <style>
        .table-sm td,
        .table-sm th {
            white-space: nowrap;
            /* Prevent wrapping */
            padding: 0.5rem;
            /* Adjust padding as needed */
        }
    </style>
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Schools</h6>

                @can('super')
                    <!-- Add a link to create a new school -->
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal"
                        id="#myBtn">
                        New School
                    </button>
                @endcan
            </div>
            <div class="table-responsive p-3">
                <!-- Table for displaying schools -->
                <table class="table table-sm align-items-center table-flush table-bordered table-striped" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Level</th>
                            <th>Type</th>
                            <th>County</th>

                            @can('super')
                                <th>Edit</th>
                                <th>Delete</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schools as $index => $school)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @can('view-school', $school)
                                        <a
                                            href="{{ route('schools.show', ['id' => $school->id, 'slug' => $school->slug]) }}">{{ $school->name }}</a>
                                    @else
                                        {{ $school->name }}
                                    @endcan
                                </td>
                                <td>{{ $school->level }}</td>
                                <td>{{ $school->type }}</td>
                                <td>{{ $school->county->name }}</td>
                                @can('super')
                                    <td>
                                        <a href="{{ route('schools.edit', ['id' => $school->id]) }}"
                                            class="text-success">Edit</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-danger delete-link"
                                            data-id="{{ $school->id }}">Delete</a>
                                    </td>
                                @endcan

                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- Modal for creating a new school -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New School</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createSchoolForm" action="{{ route('schools.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">School Name</label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Enter school name" required>
                        </div>

                        <div class="form-group">
                            <label for="level">Level</label>
                            <select name="level" class="form-control mb-3" required>
                                <option value="">Select Level</option>
                                <option value="National">National</option>
                                <option value="Extra-County">Extra-County</option>
                                <option value="County">County</option>
                                <option value="Sub-County">Sub-County</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" class="form-control mb-3" required>
                                <option value="">Select Type</option>
                                <option value="Boys">Boys</option>
                                <option value="Girls">Girls</option>
                                <option value="Mixed">Mixed</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="county_id">County</label>
                            <select name="county_id" class="form-control mb-3" required>
                                <option value="">Select County</option>
                                @foreach ($counties as $county)
                                    <option value="{{ $county->id }}">{{ $county->name }}</option>
                                @endforeach
                            </select>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-primary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary" id="submitSchool">Create</button>
                </div>
                </form>
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
            $('#dataTable').DataTable();

            $('#exampleModal form').submit(function(e) {
                e.preventDefault();

                var form = $(this); // Reference to the form

                $.ajax({
                    type: 'POST',
                    url: '{{ route('schools.store') }}', // Update to the appropriate route for school store
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Include the CSRF token in headers
                    },
                    success: function(response) {
                        $('#exampleModal').modal('hide');
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

                var schoolId = $(this).data('id');
                var deleteUrl = '{{ route('schools.destroy', '') }}/' +
                    schoolId; // Update to the appropriate route for school delete

                if (confirm('Are you sure you want to delete this school?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: deleteUrl,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // Include the CSRF token in headers
                        },
                        success: function(response) {
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
                }
            });
        });
    </script>
@endpush
