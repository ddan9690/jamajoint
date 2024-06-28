<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $exam->name }} Form {{ $exam->form->name }} Term {{ $exam->term }} {{ $exam->year }} Overall Student Ranking</title>
    <style>
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
            max-width: 150px;
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
    </style>
</head>
<body>
    <div class="container">
        @if ($exam->form->name == '3')
            <img src="{{ public_path('backend/img/logo/cyberspace-national-joint-logo.png') }}" alt="Logo" class="logo">
        @endif
        <div class="exam-details">
            {{ $exam->name }} Form {{ $exam->form->name }} Term {{ $exam->term }} {{ $exam->year }}
            <div>Overall Student Ranking</div>
        </div>
        <table>
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
        <div style="text-align: center; font-weight: bold;">
            www.jamajoint.co.ke
        </div>
    </div>
</body>
</html>
