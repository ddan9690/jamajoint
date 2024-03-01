<!DOCTYPE html>
<html>
<head>
    <style>
        /* Add your custom CSS styles for PDF here */
        body {
            font-family: Arial, sans-serif;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table td, .table th {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: center;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .overall-row {
            background-color: #c9c9c9;
            font-weight: bold;
        }
        .text-info {
            color: blue;
        }
        .text-decoration-underline {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h5>{{ $exam->name }} Term {{ $exam->term }} {{ $exam->year }} Two Subjects Results - {{ $school->name }}</h5>

    <!-- Main Results Table for Two Subjects (without Average) -->
    <table class="table">
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
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Grade Analysis Table for Two Subjects -->
    <h5 class="text-info text-decoration-underline">Grade Analysis</h5>
    <table class="table">
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

            <!-- Add the overall analysis row for Two Subjects -->
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
</body>
</html>
