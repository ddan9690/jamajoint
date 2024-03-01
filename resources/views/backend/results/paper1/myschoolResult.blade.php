@extends('backend.layout.master')

@section('title', 'Paper 1 Results - My School')

@section('content')
<style>
    .table-sm td,
    .table-sm th {
        white-space: nowrap;
        padding: 0.5rem;
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
            @if(count($results) > 0)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>{{ $exam->name }} Form {{ $exam->form->name }} Term {{ $exam->term }} {{ $exam->year }} - {{ $school->name }}</h5>
                    <a href="{{ route('pdf-download.paper1', ['exam_id' => $exam->id, 'form_id' => $exam->form_id, 'slug' => $school->slug]) }}" class="btn btn-success btn-sm">
                        Download
                    </a>
                </div>

                <!-- Main Results Table for Paper 1 (with DataTable) -->
                <table id="paper1-results-table" class="table table-sm align-items-center table-responsive table-flush table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ADM</th>
                            <th>NAME</th>
                            <th>STRM</th>
                            <th>PP1</th>
                            <th>GRD</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $result)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $result['student']->adm }}</td>
                                <td>{{ $result['student']->name }}</td>
                                <td>{{ $result['student']->stream->name }}</td>
                                <td>{{ $result['paper1Marks'] }}</td>
                                <td>{{ $result['grade'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Grade Analysis Table for Paper 1 -->
                <h5 class="text-info text-decoration-underline">Grade Analysis</h5>
                <table id="paper1-analysis-table" class="table table-sm table-responsive align-items-center table-flush table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Stream</th>
                            @foreach ($gradingSystem as $grade)
                                <th>{{ $grade->grade }}</th>
                            @endforeach
                            <th>Total</th>
                            <th>Mean</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // Sort $analysis by 'mean' in descending order
                            $sortedAnalysis = collect($analysis)->sortByDesc('mean');
                        @endphp

                        @foreach ($sortedAnalysis as $item)
                            <tr>
                                <td>{{ $item['stream'] }}</td>
                                @foreach ($gradingSystem as $grade)
                                    <td>{{ $item['grades'][$grade->grade] }}</td>
                                @endforeach
                                <td>{{ $item['total'] }}</td>
                                <td>{{ $item['mean'] }}</td>
                            </tr>
                        @endforeach

                        <!-- Add the overall analysis row for Paper 1 at the bottom -->
                        <tr class="overall-row">
                            <td>Overall</td>
                            @php
                                $overallTotal = 0;
                                $overallMean = 0;
                            @endphp
                            @foreach ($gradingSystem as $grade)
                                <td>
                                    @php
                                        $gradeCount = 0;
                                        foreach ($sortedAnalysis as $item) {
                                            $gradeCount += $item['grades'][$grade->grade];
                                        }
                                        echo $gradeCount;
                                        $overallTotal += $gradeCount;
                                        $gradePoints = $gradingSystem->where('grade', $grade->grade)->first()->points ?? 0;
                                        $overallMean += ($gradeCount * $gradePoints);
                                    @endphp
                                </td>
                            @endforeach
                            <td>{{ $overallTotal }}</td>
                            <td>{{ $overallTotal > 0 ? round($overallMean / $overallTotal, 4) : 0 }}</td>
                        </tr>
                    </tbody>
                </table>
            @else
                <div class="alert alert-danger" role="alert">
                    Sorry, no results to show.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.23/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        // DataTable for Paper 1 results
        $('#paper1-results-table').DataTable();
    });
</script>
@endpush
