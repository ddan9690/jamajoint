@extends('backend.layout.master')

@section('title', 'School Results')

@section('content')
<style>
    .table-sm td,
    .table-sm th {
        white-space: nowrap; /* Prevent wrapping */
        padding: 0.5rem; /* Adjust padding as needed */
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>{{ $exam->name }} Term {{ $exam->term }} {{ $exam->year }} - School Results - {{ $school->name }}</h5>

            </div>

            <!-- School Name -->
            <h6>School: {{ $school->name }}</h6>


            <!-- Main Results Table -->
            <table id="results-table" class="table table-responsive table-sm align-items-center table-flush table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ADM</th>
                        <th>NAME</th>
                        <th>STRM</th>
                        <th>PP1</th>
                        <th>PP2</th>
                        <th>AVG</th>
                        <th>GRD</th>
                        <!-- Add other columns here -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $result)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $result['student']->adm }}</td>
                        <td>{{ $result['student']->name }}</td>
                        <td>{{ $result['student']->stream->name }}</td>
                        <td>{{ $result['subject1Marks'] }}</td>
                        <td>{{ $result['subject2Marks'] }}</td>
                        <td>{{ $result['average'] }}</td>
                        <td>{{ $result['grade'] }}</td>
                        <!-- Add other columns here -->
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Grade Analysis Table (Header and Overall Row Only) -->
            <h5 class="text-info text-decoration-underline">Grade Analysis</h5>
            <table id="analysis-table" class="table table-responsive table-sm align-items-center table-flush table-bordered table-striped">
                <thead>
                    <tr>
                        <th></th>
                        @foreach ($gradingSystem as $grade)
                            <th>{{ $grade->grade }}</th>
                        @endforeach
                        <th>Entry</th>
                        <th>Mean</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-info font-weight-bold">
                        <td>Overall</td>
                        @php
                            $overallGradesCount = array_fill_keys($gradingSystem->pluck('grade')->toArray(), 0);
                            $overallTotalStudents = 0;
                            $overallMean = 0;

                            foreach ($analysis as $item) {
                                $overallTotalStudents += $item['total'];

                                foreach ($gradingSystem as $grade) {
                                    $overallGradesCount[$grade->grade] += $item['grades'][$grade->grade];
                                }
                            }

                            if ($overallTotalStudents > 0) {
                                foreach ($overallGradesCount as $grade => $count) {
                                    $gradePoints = $gradingSystem->where('grade', $grade)->first()->points ?? 0;
                                    $overallMean += ($count * $gradePoints);
                                }
                                $overallMean = round($overallMean / $overallTotalStudents, 4);
                            }
                        @endphp
                        @foreach ($gradingSystem as $grade)
                            <td>{{ $overallGradesCount[$grade->grade] }}</td>
                        @endforeach
                        <td>{{ $overallTotalStudents }}</td>
                        <td>{{ $overallMean }}</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#results-table').DataTable({
            "pageLength": 50
        });
    });
</script>
@endpush
