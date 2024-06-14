<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        {{ $exam->name }} - Overall Student Ranking PDF
    </title>
    <style>
        /* Include styles from the Paper 1 template for consistent design */
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
            font-size: 10px; /* Set the font size */
            text-align: left;
        }

        .table,
        th,
        td {
            border: 1px solid #000;
            padding: 4px; /* Set the padding */
        }

        th,
        td {
            white-space: nowrap;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
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
            font-size: 16px; /* Set the font size */
            text-decoration: underline;
            margin-bottom: 5px; /* Adjust spacing between exam details and table */
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
                    <td>{{ $result['subject1Marks'] }}</td>
                    <td>{{ $result['subject2Marks'] }}</td>
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
