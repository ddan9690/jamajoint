<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grade Analysis</title>
    <style>
        /* Include styles from the first template for consistent design */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 100%;
            margin: 20px auto;
            padding: 20px;
            text-align: center;
        }
        .logo {
            max-width: 200px;
            margin: 0 auto 10px;
            display: block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            margin-bottom: 20px;
            font-family: Arial, sans-serif;
        }
        table, th, td {
            border: 1px solid #000;
            font-size: 10px;
        }
        th, td {
            padding: 4px;
            text-transform: uppercase;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        th, td {
            white-space: nowrap;
        }
        .exam-details {
            text-transform: uppercase;
            font-weight: bold;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .text-info {
            color: blue;
        }
        .text-decoration-underline {
            text-decoration: underline;
        }
        /* Style for the overall row */
        .overall-row {
            background-color: #a6a3a3; /* A milder background color */
        }
    </style>
</head>
<body>
    <div class="container">


        <h5 class="text-info text-decoration-underline">Grade Analysis</h5>
        <table>
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

                <!-- Add the overall analysis row for Two Subjects with milder background color -->
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
        <div style="text-align: center; font-weight: bold;">
            www.jamajoint.co.ke
        </div>
    </div>
</body>
</html>
