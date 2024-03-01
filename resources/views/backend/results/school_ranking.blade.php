@extends('backend.layout.master')

@section('title', 'School Ranking')

@section('content')
<style>
    .table-sm td,
    .table-sm th {
        white-space: nowrap;
        padding: 0.5rem;
        text-transform: uppercase;
    }

    /* Add a custom style for the overall row */
    .overall-row {
        background-color: #c9c9c9; /* Change this color to your desired background color */
        font-weight: bold;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>{{ $exam->name }} Term {{ $exam->term }} {{ $exam->year }} - School Ranking</h5>
                <a href="{{ route('pdf-download.school-ranking', ['id' => $exam->id, 'slug' => $exam->slug]) }}" class="btn btn-sm btn-success">Download</a>
            </div>

            <!-- School Ranking Table -->
            <table id="school-ranking-table" class="table table-sm table-responsive table-sm align-items-center table-flush table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>SCHOOL</th>
                        <th>COUNTY</th>
                        <th>ENTRY</th>
                        <th>MEAN</th>
                    </tr>
                </thead>
                @foreach ($schoolMeans as $index => $schoolData)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $schoolData['school']->name }}</td>
                    <td>{{ $schoolData['school']->county }}</td>
                    <td>{{ $schoolData['ranked_students_count'] }}</td>
                    <td>{{ $schoolData['school_mean'] }}</td>
                </tr>
            @endforeach

            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#school-ranking-table').DataTable({
            "pageLength": 50
        });

    });
</script>
@endpush
