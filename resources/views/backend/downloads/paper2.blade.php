<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>
        Paper 2 Results - My School
    </title>
    <style>
        /* Include styles from the first template for consistent design */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 100%;
            margin: 10px auto;
            padding: 10px;
            text-align: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            margin-bottom: 10px;
            font-family: Arial, sans-serif;
            font-size: 10px;
            /* Set the font size */
        }

        .table,
        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            /* Set the padding */
            text-align: left;
        }

        th,
        td {
            white-space: nowrap;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
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

        .exam-details {
            text-transform: uppercase;
            font-weight: bold;
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 16px;
            /* Set the font size */
            text-decoration: underline;
            margin-bottom: 5px; /* Adjust spacing between exam details and Paper 2 */
        }

        .subheading-paper-2 {
            text-align: center;
            margin-top: 0; /* Remove default margin */
            margin-bottom: 5px; /* Adjust spacing between Paper 2 and table */
        }

        .subheading-paper-2 strong {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h5 class="exam-details">
            {{ $exam->name }} Form {{ $exam->form->name }} Term {{ $exam->term }} {{ $exam->year }}
        </h5>

        <h4 class="subheading-paper-2">
            <strong><u>PAPER 2 - {{ $school->name }}</u></strong>
        </h4>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ADM</th>
                    <th>NAME</th>
                    <th>STRM</th>
                    <th>PP2</th>
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
                        <td>{{ $result['paper2Marks'] }}</td>
                        <td>{{ $result['grade'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

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
                @foreach ($analysis as $item)
                    <tr>
                        <td>{{ $item['stream'] }}</td>
                        @foreach ($gradingSystem as $grade)
                            <td>{{ $item['grades'][$grade->grade] }}</td>
                        @endforeach
                        <td>{{ $item['total'] }}</td>
                        <td>{{ $item['mean'] }}</td>
                    </tr>
                @endforeach

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
                                foreach ($analysis as $item) {
                                    $gradeCount += $item['grades'][$grade->grade];
                                }
                                echo $gradeCount;
                                $overallTotal += $gradeCount;
                                $gradePoints = $gradingSystem->where('grade', $grade->grade)->first()->points ?? 0;
                                $overallMean += $gradeCount * $gradePoints;
                            @endphp
                        </td>
                    @endforeach
                    <td>{{ $overallTotal }}</td>
                    <td>{{ $overallTotal > 0 ? round($overallMean / $overallTotal, 4) : 0 }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
