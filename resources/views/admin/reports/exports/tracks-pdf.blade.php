<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tracks Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: ltr;
            text-align: left;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #04aa6d;
            color: white;
        }
        h1 {
            color: #1d1e27;
        }
    </style>
</head>
<body>
    <h1>Tracks Report</h1>
    <p>Report Date: {{ date('Y-m-d') }}</p>
    
    <h2>Statistics</h2>
    <p>Total Tracks: {{ $total_tracks }}</p>
    
    <h2>Tracks List</h2>
    <table>
        <thead>
            <tr>
                <th>Track</th>
                <th>Lessons</th>
                <th>Quizzes</th>
                <th>Labs</th>
                <th>Users with Progress</th>
                <th>Certificates</th>
                <th>Completion Rate</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tracks as $track)
                @php
                    $completion = $completion_rates[$track->id]['completion_rate'] ?? 0;
                @endphp
                <tr>
                    <td>{{ $track->title }}</td>
                    <td>{{ $track->lessons_count }}</td>
                    <td>{{ $track->quizzes_count }}</td>
                    <td>{{ $track->labs_count }}</td>
                    <td>{{ $track->user_progress_count }}</td>
                    <td>{{ $track->certificates_count }}</td>
                    <td>{{ $completion }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
