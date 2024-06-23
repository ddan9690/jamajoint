@extends('backend.layout.master')

@section('title', 'Overall Student Ranking')

@section('content')
<style>
    .table-sm td,
    .table-sm th {
        white-space: nowrap; /* Prevent wrapping */
        padding: 0.5rem;
        text-transform: uppercase;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <!-- Heading displaying exam and ranking information -->
                <h5>{{ $exam->name }} Form {{ $exam->form->name }} Term {{ $exam->term }} {{ $exam->year }} - Overall Student Ranking</h5>

                <!-- Button group for download options -->
                <div class="btn-group">
                    <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Download
                    </button>
                    <div class="dropdown-menu">
                        {{-- <a href="{{ route('pdf.overall-student-ranking', ['id' => $exam->id, 'slug' => $exam->slug, 'form_id' => $exam->form_id]) }}" class="dropdown-item">
                            <i class="fas fa-file-pdf fa-fw"></i> Overall Student Ranking (PDF)
                        </a> --}}
                        <a href="{{ route('export.overall-student-ranking', ['id' => $exam->id, 'slug' => $exam->slug, 'form_id' => $exam->form_id]) }}" class="dropdown-item">
                            <i class="fas fa-file-excel fa-fw"></i> Overall Student Ranking (Excel)
                        </a>



                    </div>
                </div>
            </div>


            <!-- Main Results Table -->
            <table id="results-table" class="table table-responsive table-sm align-items-center table-flush table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ADM</th>
                        <th>NAME</th>
                        <th>GENDER</th>
                        <th>SCHOOL</th>
                        <th>STRM</th>
                        <th>PP1</th>
                        <th>PP2</th>
                        <th>AVG</th>
                        <th>GRD</th>
                        <th>RNK</th>
                        <!-- Add other columns here -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($studentMeans as $result)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $result['student']->adm }}</td>
                        <td>{{ $result['student']->name }}</td>
                        <td>{{ $result['student']->gender }}</td>
                        <td>{{ $result['student']->school->name }}</td>
                        <td>{{ $result['student']->stream->name }}</td>
                        <td>{{ $result['subject1Marks'] }}</td>
                        <td>{{ $result['subject2Marks'] }}</td>
                        <td>{{ $result['average'] }}</td>
                        <td>{{ $result['grade'] }}</td>
                        <td>{{ $result['rank'] }}</td>
                        <!-- Add other columns here -->
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
    $(document).ready(function () {
        $('#results-table').DataTable({
            "pageLength": 50
        });
    });
</script>
@endpush
