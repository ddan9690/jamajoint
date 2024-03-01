@extends('backend.layout.master')
@section('title', 'Register Schools for Exam')
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
            <h6 class="m-0 font-weight-bold text-primary">Register Schools for Exam: {{ $exam->name }}</h6>
        </div>
        <div class="table-responsive p-3">
            @if ($schools->isEmpty())
                <p>No schools available for registration.</p>
            @else
                <form action="{{ route('exams.storeSchools', ['exam' => $exam->id]) }}" method="POST">
                    @csrf
                    <table class="table table-sm align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th>School</th>
                                <th>County</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schools as $index => $school)
                            <tr>
                                <td>
                                    <input type="checkbox" name="schools[]" value="{{ $school->id }}">
                                </td>
                                <td>{{ $school->name }}</td>
                                <td>{{ $school->county }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="btn mt-3 btn-sm btn-primary">Register Schools</button>
                </form>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Toggle state of all checkboxes when "Select All" checkbox is clicked
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="schools[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
@endpush
