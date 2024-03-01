@extends('backend.layout.master')
@section('title', 'Stream Details')
@section('content')
<style>
    .table-sm td,
    .table-sm th {
        white-space: nowrap;
        padding: 0.5rem;
    }
</style>
<div class="col-12 col-sm-12">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Form {{ $form->name }} {{ $school->name }} -{{ $stream->name }}</h6>
            <a href="{{ route('students.create', ['schoolId' => $school->id, 'streamId' => $stream->id, 'form' => $form->id]) }}" class="btn btn-sm btn-success">Add New Student</a>
        </div>
        <div class="card-body">
            @can('super')
            <form id="importForm" action="{{ route('students.imports', ['schoolId' => $school->id, 'streamId' => $stream->id,'form' => $form->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" name="import" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Import Students</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm mb-3 btn-primary">Import</button>
            </form>
            @endcan

            <form id="deleteForm" action="{{ route('students.deleteSelected', ['schoolId' => $school->id, 'streamId' => $stream->id, 'form' => $form->id]) }}" method="POST">
                @csrf
                @method('DELETE')


                <table class="table table-sm table-striped table-responsive  table-bordered align-items-center table-flush">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th>Adm</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $index => $student)
                            <tr>
                                <td>
                                    <input type="checkbox" class="delete-checkbox" name="selectedStudents[]" value="{{ $student->id }}">
                                </td>
                                <td>{{ $student->adm }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->gender }}</td>
                                <td>
                                    <form action="{{ route('students.destroy', ['schoolId' => $school->id, 'streamId' => $stream->id, 'id' => $student->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-student">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <button type="button" class="btn btn-sm btn-danger mb-3" id="deleteSelected" disabled>Delete Selected</button>

            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    $(document).ready(function () {
        $('.delete-student').click(function () {
            var form = $(this).closest('form');

            swal({
                title: "Are you sure?",
                icon: "warning",
                buttons: ["Cancel", "Delete"],
                dangerMode: true,
            }).then(function (willDelete) {
                if (willDelete) {
                    form.submit();
                }
            });
        });

        $('#importForm').submit(function (e) {
            e.preventDefault();

            var fileInput = $('#customFile')[0];
            var formData = new FormData(this);

            if (fileInput.files.length === 0) {
                swal('Error', 'Please select a file to import.', 'error');
                return;
            }

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    swal('Success', response.message, 'success');
                    location.reload();
                },
                error: function (error) {
                    swal('Error', error.responseJSON.message, 'error');
                    console.log(error.responseJSON.message);
                }
            });
        });

        // Enable/Disable delete button based on checkbox selection
        $('#selectAll').click(function () {
            $('.delete-checkbox').prop('checked', $(this).prop('checked'));
            $('#deleteSelected').prop('disabled', !$(this).prop('checked'));
        });

        $('.delete-checkbox').click(function () {
            $('#deleteSelected').prop('disabled', $('.delete-checkbox:checked').length === 0);
        });

        // Handle delete selected form submission
        $('#deleteSelected').click(function () {
            var form = $('#deleteForm');

            swal({
                title: "Are you sure you want to delete selected students?",
                icon: "warning",
                buttons: ["Cancel", "Delete"],
                dangerMode: true,
            }).then(function (willDelete) {
                if (willDelete) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
