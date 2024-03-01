@extends('backend.layout.master')
@section('title', 'User Index')
@section('content')

<div class="col-lg-12">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Manage Users ({{$users->count()}})</h6>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <style>
                    /* Prevent text wrapping */
                    .table td, .table th {
                        white-space: nowrap;
                    }
                </style>
            <table class="table table-sm table-bordered table-hover" id="userTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>School Name</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>D.O.R</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a>
                        </td>
                        <td>
                            @if ($user->school)
                            <a href="{{ route('schools.show', ['slug' => $user->school->slug, 'id' => $user->school->id]) }}">{{ $user->school->name }}</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            <form action="{{ route('users.updateRole', ['user' => $user->id]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="edit_role" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="super" {{ $user->role === 'super' ? 'selected' : '' }}>Super</option>
                                </select>
                            </form>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($user->created_at)->format('m-d-y') }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-success">Edit</a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger delete-user" data-id="{{ $user->id }}">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>


            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
$(document).ready(function () {

    $('#userTable').DataTable({
        "pageLength": 50
    });
    // Handle Delete User with AJAX and SweetAlert
    $('.delete-user').click(function () {
        var userId = $(this).data('id');
        var deleteUrl = '{{ route('users.destroy', '') }}/' + userId;

        // Show SweetAlert confirmation
        swal({
            title: 'Are you sure?',
            text: 'You will not be able to recover this user!',
            icon: 'warning',
            buttons: ['Cancel', 'Delete'],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                // Send AJAX DELETE request to delete the user
                $.ajax({
                    type: 'DELETE',
                    url: deleteUrl,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        // Remove the deleted user row from the table
                        $('tr[data-id="' + userId + '"]').remove();
                        swal('User deleted successfully! Refresh the Page', {
                            icon: 'success',
                        });
                        // location.reload();
                    },
                    error: function (error) {
                        swal('Error!', error.responseJSON.message, 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
