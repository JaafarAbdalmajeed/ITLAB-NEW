<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users Report</title>
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
    <h1>Users Report</h1>
    <p>Report Date: {{ date('Y-m-d') }}</p>
    
    <h2>Statistics</h2>
    <p>Total Users: {{ $total_users }}</p>
    <p>Admins: {{ $admin_users }}</p>
    <p>Regular Users: {{ $regular_users }}</p>
    
    <h2>Users List</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Registration Date</th>
                <th>Quiz Results</th>
                <th>Progress Records</th>
                <th>User Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    <td>{{ $user->quiz_results_count }}</td>
                    <td>{{ $user->progress_count }}</td>
                    <td>{{ $user->is_admin ? 'Admin' : 'Regular User' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
