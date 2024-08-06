<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $exam->name }} Term {{ $exam->term }} {{ $exam->year }} Top Performers</title>
    <style>
        /* Page styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px; /* Reduced font size */
        }

        /* Landscape orientation */
        @page {
            size: landscape;
            margin: 20px;
        }

        /* Container styles */
        .container {
            max-width: 100%;
            margin: 10px auto; /* Reduced margin */
            padding: 10px; /* Reduced padding */
            text-align: center;
        }

        /* Logo styles */
        .logo {
            max-width: 150px;
            margin: 0 auto 5px; /* Reduced bottom margin */
            display: block;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px; /* Reduced bottom margin */
        }

        table, th, td {
            border: 1px solid #000;
            padding: 4px;
            text-transform: uppercase; /* Convert text to uppercase */
            white-space: nowrap;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Exam details and school name styles */
        .exam-details {
            text-transform: uppercase;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px; /* Reduced bottom margin */
        }

        /* Additional styles for h6 headings */
        h6 {
            margin: 5px 0; /* Reduced top and bottom margin */
            font-size: 14px; /* Reduced font size */
            font-weight: bold;
        }

        .mt-2 {
            margin-top: 2px;
        }
    </style>
</head>
<body>
    <div class="container">
        @if ($exam->form->name == '3')
            <img src="{{ public_path('backend/img/logo/cyberspace-national-joint-logo.png') }}" alt="Logo" class="logo">
        @endif
        <div class="exam-details">
            {{ $exam->name }} Term {{ $exam->term }} {{ $exam->year }} - Top Performers
        </div>

        <!-- Top Performers - Boys -->
        <h6 class="mt-2">Top 10 Boys</h6>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>ADM</th>
                    <th>School</th>
                    <th>STRM</th>
                    <th>PP1</th>
                    <th>PP2</th>
                    <th>AVG</th>
                    <th>GRD</th>
                    <th>POS</th>
                </tr>
            </thead>
            <tbody>
                @php $currentRank = 1; @endphp
                @foreach ($topBoys as $index => $result)
                    @php
                        $isNewRank = ($index === 0 || $result['average'] !== $topBoys[$index - 1]['average']);
                        if ($isNewRank) {
                            $currentRank = $index + 1;
                        }
                    @endphp
                    <tr>
                        <td>{{ strtoupper($result['student']->name) }}</td>
                        <td>{{ strtoupper($result['student']->adm) }}</td>
                        <td>{{ strtoupper($result['student']->school->name) }}</td>
                        <td>{{ strtoupper($result['student']->stream->name) }}</td>
                        <td>{{ strtoupper($result['subject1Marks']) }}</td>
                        <td>{{ strtoupper($result['subject2Marks']) }}</td>
                        <td>{{ strtoupper($result['average']) }}</td>
                        <td>{{ strtoupper($result['grade']) }}</td>
                        <td>{{ $currentRank }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Top Performers - Girls -->
        <h6 class="mt-2">Top 10 Girls</h6>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>ADM</th>
                    <th>School</th>
                    <th>STRM</th>
                    <th>PP1</th>
                    <th>PP2</th>
                    <th>AVG</th>
                    <th>GRD</th>
                    <th>POS</th>
                </tr>
            </thead>
            <tbody>
                @php $currentRank = 1; @endphp
                @foreach ($topGirls as $index => $result)
                    @php
                        $isNewRank = ($index === 0 || $result['average'] !== $topGirls[$index - 1]['average']);
                        if ($isNewRank) {
                            $currentRank = $index + 1;
                        }
                    @endphp
                    <tr>
                        <td>{{ strtoupper($result['student']->name) }}</td>
                        <td>{{ strtoupper($result['student']->adm) }}</td>
                        <td>{{ strtoupper($result['student']->school->name) }}</td>
                        <td>{{ strtoupper($result['student']->stream->name) }}</td>
                        <td>{{ strtoupper($result['subject1Marks']) }}</td>
                        <td>{{ strtoupper($result['subject2Marks']) }}</td>
                        <td>{{ strtoupper($result['average']) }}</td>
                        <td>{{ strtoupper($result['grade']) }}</td>
                        <td>{{ $currentRank }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
