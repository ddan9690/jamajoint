@extends('backend.layout.master')
@section('title', 'Exam Details')
@section('content')
<style>
    .table-sm td,
    .table-sm th {
        white-space: nowrap;
        padding: 0.5rem;
    }
</style>
<div class="col-lg-12">
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{ $exam->name }} Form {{ $exam->form->name }} Term {{ $exam->term }}-{{ $exam->year }}</h6>
            @if ($exam->published !== 'yes')
            @can('super')
            <a href="{{ route('exams.register', ['exam' => $exam->id]) }}" class="btn btn-sm btn-primary">Register Schools</a>
            @endcan
            @endif
        </div>
        <div class="card-body">
            <h6 class="m-0 font-weight-bold text-primary align-center">Schools Registered for the exam</h6>

            <table class="table table-sm table-responsive table-bordered" id="registeredSchools">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>School Name</th>
                        @can('super')
                        <th>Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exam->schools as $school)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $school->name }}</td>
                            @can('super')
                            <td>
                                <a href="{{ route('exams.unregister', ['exam' => $exam->id, 'schoolId' => $school->id]) }}" class="text-danger" onclick="return confirm('Are you sure you want to unregister this school?')">Unregister</a>
                            </td>
                            @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#registeredSchools').DataTable(); // Initialize DataTable
    });
</script>
@endpush
