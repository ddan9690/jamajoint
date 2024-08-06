@extends('backend.layout.master')
@section('title', 'Gradings')
@section('content')

<div class="col-lg-12">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Gradings</h6>
            <button type="button" class="btn  btn-sm btn-primary" data-toggle="modal" disabled data-target="#createGradingModal">
                New Grading
            </button>
        </div>
        <div class="table-responsive p-3">
            <table class="table table-sm align-items-center table-flush" id="gradingTable">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Grade</th>
                        <th>Low</th>
                        <th>High</th>
                        <th>Points</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gradings as $index => $grading)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $grading->grade }}</td>
                        <td>{{ number_format($grading->low) }}</td>
                        <td>{{ number_format($grading->high) }}</td>

                        <td>{{ $grading->points }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary" disabled data-toggle="modal" data-target="#editGradingModal{{ $grading->id }}">
                                Edit
                            </button>
                            {{-- <a href="#" class="btn btn-sm btn-danger delete-link" disabled   data-id="{{ $grading->id }}">Delete</a> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Grading Modal -->
<div class="modal fade" id="createGradingModal" tabindex="-1" role="dialog" aria-labelledby="createGradingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createGradingModalLabel">Create New Grading</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createGradingForm" action="{{ route('gradings.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="grade">Grade</label>
                        <input type="text" name="grade" class="form-control" id="grade" placeholder="Enter grade" required>
                    </div>
                    <div class="form-group">
                        <label for="low">Low</label>
                        <input type="number" name="low" class="form-control" id="low" placeholder="Enter low value" required>
                    </div>
                    <div class="form-group">
                        <label for="high">High</label>
                        <input type="number" name="high" class="form-control" id="high" placeholder="Enter high value" required>
                    </div>
                    <div class="form-group">
                        <label for="points">Points</label>
                        <input type="number" name="points" class="form-control" id="points" placeholder="Enter points" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-primary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary" id="submitGrading">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ($gradings as $grading)
<!-- Edit Grading Modal for each grading -->
<div class="modal fade" id="editGradingModal{{ $grading->id }}" tabindex="-1" role="dialog" aria-labelledby="editGradingModalLabel{{ $grading->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGradingModalLabel{{ $grading->id }}">Edit Grading</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editGradingForm{{ $grading->id }}" action="{{ route('gradings.update', ['id' => $grading->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="grade">Grade</label>
                        <input type="text" name="grade" class="form-control" id="grade" value="{{ $grading->grade }}" required>
                    </div>
                    <div class="form-group">
                        <label for="low">Low</label>
                        <input type="number" name="low" class="form-control" id="low" value="{{ number_format($grading->low) }}" required>

                    </div>
                    <div class="form-group">
                        <label for="high">High</label>
                        <input type="number" name="high" class="form-control" id="high" value="{{ number_format($grading->high) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="points">Points</label>
                        <input type="number" name="points" class="form-control" id="points" value="{{ $grading->points }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-primary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary" id="submitGrading">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    // Example AJAX handling for form submissions and deletion
    $(document).ready(function () {
        // Create Grading form submission
        $('#createGradingForm').on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                success: function (data) {
                    toastr.success('Grading created successfully.');
                    $('#createGradingModal').modal('hide');
                    location.reload();

                },
                error: function (xhr) {

                    toastr.error('An error occurred while creating grading.');
                }
            });
        });

        // Edit Grading form submission
        $('[id^=editGradingForm]').on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                type: 'PUT',
                url: $(this).attr('action'),
                data: formData,
                success: function (data) {
                    toastr.success('Grading updated successfully.');
                    var modalId = $(this).closest('.modal').attr('id');
                    $('#' + modalId).modal('hide');
                    // You might need to update the table with the updated data here
                },
                error: function (xhr) {
                    toastr.error('An error occurred while updating grading.');
                }
            });
        });

        // Delete Grading
        $('.delete-link').on('click', function (e) {
            e.preventDefault();
            var gradingId = $(this).data('id');
            var deleteUrl = '{{ route("gradings.destroy", ":id") }}'.replace(':id', gradingId);

            $.ajax({
                type: 'DELETE',
                url: deleteUrl,
                success: function (data) {
                    toastr.success('Grading deleted successfully.');
                    // You might need to update the table to remove the deleted row here
                },
                error: function (xhr) {
                    toastr.error('An error occurred while deleting grading.');
                }
            });
        });
    });
</script>
@endpush

