<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $exam->name }} Term {{ $exam->term }} {{ $exam->year }} Stream Ranking</title>
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
            <img src="{{ public_path('backend/img/logo/cyberspace-national-joint-logo.png') }}" alt="Logo"
                class="logo">
        @endif
        <div class="exam-details">
            {{ $exam->name }} Form {{ $exam->form->name }}  Term {{ $exam->term }} {{ $exam->year }}
            <div>Stream Ranking</div>
        </div>


        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Stream</th>
                    <th>School</th>
                    <th>County</th>
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
                    <td>{{ $result['school']->county }}</td>
                    <td>{{ $result['stream']->students->count() }}</td>
                    <td>{{ $result['stream_mean' ] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <div style="text-align: center; font-weight: bold;">
            www.cyberspace.co.ke
        </div>
    </div>
</body>
</html>
