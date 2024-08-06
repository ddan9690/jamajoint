<!-- resources/views/backend/users/edit.blade.php -->

@extends('backend.layout.master')
@section('title', 'Edit User')
@section('content')

<div class="col-lg-8">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="edit_name">Name</label>
                    <input type="text" name="edit_name" id="edit_name" class="form-control" required value="{{ $user->name }}">
                </div>

                <div class="form-group">
                    <label for="edit_phone">Phone</label>
                    <input type="text" name="edit_phone" id="edit_phone" class="form-control" required value="{{ $user->phone }}">
                </div>

                <div class="form-group">
                    <label for="edit_school">School</label>
                    <select name="edit_school" id="edit_school" class="form-control">
                        <option value="">Select School</option>
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}" {{ $school->id == $user->school_id ? 'selected' : '' }}>{{ $school->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="edit_role">Role</label>
                    <select name="edit_role" id="edit_role" class="form-control">
                        <option value="user" @if ($user->role === 'user') selected @endif>User</option>
                        <option value="admin" @if ($user->role === 'admin') selected @endif>Admin</option>
                        <option value="super" @if ($user->role === 'super') selected @endif>Super</option>
                    </select>

                </div>

                <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
</div>

@endsection
