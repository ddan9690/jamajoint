<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Marksheet for {{ $school->name }}</title>
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

        .main-heading {
            font-weight: bold;
            font-size: 20px; /* Reduced font size */
            margin-bottom: 3px; /* Reduced bottom margin */
            text-transform: uppercase;
        }

        h2 {
            text-decoration: underline;
            font-size: 16px; /* Reduced font size */
            margin-bottom: 10px;
        }

        .stream-table {
            margin-bottom: 40px; /* Increased spacing between stream tables */
        }

        table {
            width: 80%;
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
        <div class="main-heading">
             {{ $school->name }}
        </div>
        @foreach($streams as $stream)
            <div class="stream-table">
                <h2>{{ $stream->name }}</h2>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Adm No</th>
                            <th>Name</th>
                            {{-- <th>Gender</th> --}}
                            <th>PP1</th>
                            <th>PP2</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stream->students as $index => $student)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->adm }}</td>
                                <td>{{ $student->name }}</td>
                                {{-- <td>{{ $student->gender }}</td> --}}
                                <td></td> <!-- PP1 column -->
                                <td></td> <!-- PP2 column -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
        <div style="text-align: center; font-weight: bold;">
            www.jamajoint.co.ke
        </div>
    </div>
</body>

</html>
