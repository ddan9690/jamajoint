@extends('backend.layout.master')

@section('title', 'Forms')

@section('content')
<style>
    .table-sm td,
    .table-sm th {
        white-space: nowrap;
        padding: 0.5rem;
    }

    .add-stream-button {
        display: inline-block;
        margin-left: 10px;
    }
</style>

<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{ $school->name }} Form {{ $form->name }}</h6>
            <button type="button" class="btn btn-sm btn-primary add-stream-button" data-toggle="modal"
                data-target="#createStreamModal">
                Add Stream
            </button>
        </div>
        <div class="card-body">
            <h6 class="m-0 font-weight-bold text-primary">Streams</h6>
            @if ($streams->isNotEmpty())
            <table class="table table-responsive table-sm table-flush">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Students</th>
                        @can('super')
                        <th>Edit</th>
                        <th>Delete</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($streams as $stream)
                    <tr>
                        <td>
                            <a href="{{ route('streams.show', ['schoolId' => $school->id, 'streamId' => $stream->id,'form' => $form->id]) }}">{{ $stream->name }}</a>
                        </td>
                        <td>{{ $stream->students->count() }}</td>
                        @can('super')
                        <td>
                            <a href="{{ route('streams.edit', ['id' => $stream->id]) }}" class="btn btn-sm btn-success">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('streams.destroy', ['id' => $stream->id]) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this stream?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>No streams associated with this form.</p>
            @endif
        </div>
    </div>
</div>

<div class="card mb-4">
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
                        <input type="hidden" name="form_id" value="{{ $form->id }}">

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-sm btn-primary">Add Stream</button>
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
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
