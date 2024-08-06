@extends('backend.layout.master')

@section('title', 'Top Performances')

@section('content')
<style>
    .table-sm td,
    .table-sm th {
        white-space: nowrap;
        padding: 0.5rem;
    }

    .table-scroll {
        overflow-x: auto;
    }
</style>
<div class="container">
    <h5 class="text-warning text-uppercase">{{ $exam->name }} Form {{ $exam->form->name }} Term {{ $exam->term }} {{ $exam->year }}</h5>
    <div class="text-right mb-4">
        <a href="{{ route('pdf-download.top-performers', ['id' => $exam->id, 'form_id' => $exam->form->id, 'slug' => $exam->slug]) }}" class="btn btn-success btn-sm">
            Download
        </a>

    </div>
    <h6 class="mt-4">Top Performers - Boys</h6>
    <div class="table-scroll">
        <table class="table table-sm table-responsive align-items-center table-flush table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-uppercase">Name</th>
                    <th class="text-uppercase">ADM</th>
                    <th class="text-uppercase">School</th>
                    <th class="text-uppercase">STRM</th>
                    <th class="text-uppercase">PP1</th>
                    <th class="text-uppercase">PP2</th>
                    <th class="text-uppercase">AVG</th>
                    <th class="text-uppercase">GRD</th>
                    <th class="text-uppercase">POS</th> <!-- Move "#" column to be the last -->
                </tr>
            </thead>
            <tbody>
                @php $currentRank = 1; @endphp
                @foreach ($topBoys as $index => $result)
                    @php
                        // Check if it's a new rank or tie
                        $isNewRank = ($index === 0 || $result['average'] !== $topBoys[$index - 1]['average']);
                        if ($isNewRank) {
                            $currentRank = $index + 1;
                        }
                    @endphp
                    <tr>
                        <td class="text-uppercase">{{ $result['student']->name }}</td>
                        <td class="text-uppercase">{{ $result['student']->adm }}</td>
                        <td class="text-uppercase">{{ $result['student']->school->name }}</td>
                        <td class="text-uppercase">{{ $result['student']->stream->name }}</td>
                        <td class="text-uppercase">{{ $result['subject1Marks' ]}}</td>
                        <td class="text-uppercase">{{ $result['subject2Marks' ]}}</td>
                        <td class="text-uppercase">{{ $result['average'] }}</td>
                        <td class="text-uppercase">{{ $result['grade'] }}</td>
                        <td class="text-uppercase">{{ $currentRank }}</td> <!-- Move "#" to the last position -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <h6 class="mt-4">Top Performers - Girls</h6>
    <div class="table-scroll">
        <table class=" table-sm align-items-center table-flush table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-uppercase">Name</th>
                    <th class="text-uppercase">ADM</th>
                    <th class="text-uppercase">School</th>
                    <th class="text-uppercase">STRM</th>
                    <th class="text-uppercase">PP1</th>
                    <th class="text-uppercase">PP2</th>
                    <th class="text-uppercase">AVG</th>
                    <th class="text-uppercase">GRD</th>
                    <th class="text-uppercase">POS</th> <!-- Move "#" column to be the last -->
                </tr>
            </thead>
            <tbody>
                @php $currentRank = 1; @endphp
                @foreach ($topGirls as $index => $result)
                    @php
                        // Check if it's a new rank or tie
                        $isNewRank = ($index === 0 || $result['average'] !== $topGirls[$index - 1]['average']);
                        if ($isNewRank) {
                            $currentRank = $index + 1;
                        }
                    @endphp
                    <tr>
                        <td class="text-uppercase">{{ $result['student']->name }}</td>
                        <td class="text-uppercase">{{ $result['student']->adm }}</td>
                        <td class="text-uppercase">{{ $result['student']->school->name }}</td>
                        <td class="text-uppercase">{{ $result['student']->stream->name }}</td>
                        <td class="text-uppercase">{{ $result['subject1Marks' ]}}</td>
                        <td class="text-uppercase">{{ $result['subject2Marks' ]}}</td>
                        <td class="text-uppercase">{{ $result['average'] }}</td>
                        <td class="text-uppercase">{{ $result['grade'] }}</td>
                        <td class="text-uppercase">{{ $currentRank }}</td> <!-- Move "#" to the last position -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
