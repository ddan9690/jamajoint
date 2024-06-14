<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        {{ $exam->name }} - Overall Student Ranking PDF
    </title>
    <style>
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
            text-align: left;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 4px;
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table th:nth-child(4),
        .table td:nth-child(4) {
            width: 40px; /* Adjust the width as needed */
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
            text-decoration: underline;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h5 class="exam-details">
            {{ $exam->name }} Term {{ $exam->term }} {{ $exam->year }} - Overall Student Ranking
        </h5>
        <table class="table">
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
                    <td>{{ $result['subjectMarks'][1] }}</td>
                    <td>{{ $result['subjectMarks'][2] }}</td>
                    <td>{{ $result['average'] }}</td>
                    <td>{{ $result['grade'] }}</td>
                    <td>{{ $result['rank'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
