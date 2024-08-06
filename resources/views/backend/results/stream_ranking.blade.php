@extends('backend.layout.master')

@section('title', 'Stream Ranking')

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
                <h5>{{ $exam->name }} Form {{ $exam->form->name }} Term {{ $exam->term }}-{{ $exam->year }}: <strong>Stream Ranking</strong></h5>
                <a href="{{ route('pdf-download.stream-ranking', ['id' => $exam->id, 'form_id' => $exam->form->id, 'slug' => $exam->slug]) }}" class="btn btn-sm btn-success">Download</a>

                {{-- <div class="btn-group">
                    <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Download
                    </button>
                    <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -2px, 0px);">
                        <a href="{{ route('pdf-download.stream-ranking', ['id' => $exam->id, 'form_id' => $exam->form->id, 'slug' => $exam->slug]) }}" class="dropdown-item">
                            <i class="fas fa-file-pdf fa-fw"></i> Stream Ranking (PDF)
                        </a>

                        <a href="{{ route('excel-download.stream-ranking', ['id' => $exam->id, 'form_id' => $exam->form->id, 'slug' => $exam->slug]) }}" class="dropdown-item">
                            <i class="fas fa-file-excel fa-fw"></i> Stream Ranking (Excel)
                        </a>
                    </div>

                </div> --}}
            </div>

            <!-- Stream Ranking Table -->
            <table id="stream_ranking" class="table table-responsive table-sm align-items-center table-flush table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Stream</th>
                        <th>School</th>
                        {{-- <th>County</th> --}}
                        <th>Entry</th>
                        <th>Mean</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($streamMeans as $index => $result)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $result['stream']->name }}</td>
                        <td>{{ $result['school']->name }}</td>
                        {{-- <td>{{ $result['school']->county->name }}</td> --}}
                        <td>{{ $result['stream']->students->count() }}</td>
                        <td>{{ $result['stream_mean'] }}</td>
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
        $('#stream_ranking').DataTable({
            "pageLength": 50
        });

    });
</script>
@endpush
