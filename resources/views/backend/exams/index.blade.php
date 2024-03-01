@extends('backend.layout.master')
@section('title', 'Exams')
@section('content')
<style>
    .table-sm td,
    .table-sm th {
        white-space: nowrap; /* Prevent wrapping */
        padding: 0.5rem; /* Adjust padding as needed */
    }
</style>
<div class="col-lg-12">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Manage Exams</h6>
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal" id="#myBtn">
                New Exam
              </button>
        </div>
        <div class="table-responsive p-3">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <table class="table table-sm align-items-center table-flush" id="dataTable">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        {{-- <th>Term</th>
                        <th>Year</th> --}}
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exams as $index => $exam)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><a href="{{ route('exams.show', ['id' => $exam->id, 'slug' => $exam->slug]) }}">{{ $exam->name }} Form {{ $exam->form->name }}  Term {{ $exam->term }} {{ $exam->year }}</a></td>
                        {{-- <td>{{ $exam->term }}</td>
                        <td>{{ $exam->year }}</td> --}}
                        <td>
                            <form action="{{ route('exams.updatePublished', ['id' => $exam->id]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="published" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="yes" {{ $exam->published === 'yes' ? 'selected' : '' }}>Published</option>
                                    <option value="no" {{ $exam->published === 'no' ? 'selected' : '' }}>Unpublished</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('exams.edit', ['id' => $exam->id, 'slug' => $exam->slug]) }}" class="text-success">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('exams.destroy', ['id' => $exam->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this exam?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>






        </div>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Exam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createExamForm">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputText">Exam Name</label>
                        <input type="text" name="name" class="form-control" id="exampleInputText">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputForm">Form</label>
                        <select name="form_id" class="form-control mb-3">

                            @foreach ($forms as $form)
                                <option value="{{ $form->id }}">Form {{ $form->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputTerm">Term</label>
                        <select name="term" class="form-control mb-3">

                            <option value="1">Term 1</option>
                            <option value="2">Term 2</option>
                            <option value="3">Term 3</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputYear">Year</label>
                        <input type="number" name="year" class="form-control" id="exampleInputYear">
                    </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-primary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-primary" id="submitSubject">Create</button>
                </form>
            </div>
        </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(document).ready(function () {
    $('#dataTable').DataTable();

    $('#exampleModal form').submit(function (e) {
    e.preventDefault();

    var form = $(this); // Reference to the form

    $.ajax({
        type: 'POST',
        url: '{{ route('exams.store') }}',
        data: form.serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token in headers
        },
        success: function (response) {
            $('#exampleModal').modal('hide');
            toastr.success(response.message, '', { timeOut: 3000 });
            location.reload();

        },
        error: function (error) {
            console.log('Error:', error);
            toastr.error(error.responseJSON.message, '', { timeOut: 3000 });
        }
    });
});


    $('.delete-link').click(function (e) {
        e.preventDefault();

        var examId = $(this).data('id');
        var deleteUrl = '{{ route('exams.destroy', '') }}/' + examId;

        if (confirm('Are you sure you want to delete this subject?')) {
            $.ajax({
                type: 'DELETE',
                url: deleteUrl,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token in headers
                },
                success: function (response) {
                    toastr.success(response.message, '', { timeOut: 3000 });
                    location.reload();
                },
                error: function (error) {
                    toastr.error(error.responseJSON.message, '', { timeOut: 3000 });
                }
            });
        }
    });
});




</script>
@endpush

