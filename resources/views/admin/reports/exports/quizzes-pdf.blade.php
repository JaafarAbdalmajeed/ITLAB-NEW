<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quizzes Report</title>
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
    <h1>Quizzes Report</h1>
    <p>Report Date: {{ date('Y-m-d') }}</p>
    
    <h2>Statistics</h2>
    <p>Total Quizzes: {{ $total_quizzes }}</p>
    <p>Total Attempts: {{ $total_attempts }}</p>
    <p>Average Score: {{ $avg_score }}%</p>
    
    <h2>Quizzes List</h2>
    <table>
        <thead>
            <tr>
                <th>Quiz</th>
                <th>Track</th>
                <th>Questions</th>
                <th>Total Attempts</th>
                <th>Average Score</th>
                <th>Max Score</th>
                <th>Min Score</th>
                <th>Pass Rate</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quizzes as $quiz)
                @php
                    $performance = $quiz_performance[$quiz->id] ?? null;
                @endphp
                <tr>
                    <td>{{ $quiz->title }}</td>
                    <td>{{ $quiz->track->title ?? 'N/A' }}</td>
                    <td>{{ $quiz->questions_count }}</td>
                    <td>{{ $performance['total_attempts'] ?? 0 }}</td>
                    <td>{{ $performance['avg_score'] ?? 0 }}%</td>
                    <td>{{ $performance['max_score'] ?? 0 }}%</td>
                    <td>{{ $performance['min_score'] ?? 0 }}%</td>
                    <td>{{ $performance['pass_rate'] ?? 0 }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
