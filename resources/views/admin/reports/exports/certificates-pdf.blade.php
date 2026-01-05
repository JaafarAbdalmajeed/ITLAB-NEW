<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificates Report</title>
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
    <h1>Certificates Report</h1>
    <p>Report Date: {{ date('Y-m-d') }}</p>
    
    <h2>Statistics</h2>
    <p>Total Certificates: {{ $total_certificates }}</p>
    <p>Track Certificates: {{ $certificates_by_type['track'] }}</p>
    <p>Quiz Certificates: {{ $certificates_by_type['quiz'] }}</p>
    
    <h2>Certificates List</h2>
    <table>
        <thead>
            <tr>
                <th>Certificate Number</th>
                <th>User</th>
                <th>Track</th>
                <th>Quiz</th>
                <th>Type</th>
                <th>Issued Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($certificates as $certificate)
                <tr>
                    <td>{{ $certificate->certificate_number }}</td>
                    <td>{{ $certificate->user->name ?? 'N/A' }}</td>
                    <td>{{ $certificate->track->title ?? 'N/A' }}</td>
                    <td>{{ $certificate->quiz->title ?? 'N/A' }}</td>
                    <td>{{ $certificate->type }}</td>
                    <td>{{ $certificate->issued_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
