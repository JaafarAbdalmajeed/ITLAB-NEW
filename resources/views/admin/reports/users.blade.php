@extends('admin.layout')

@section('title', 'Users Report')
@section('page-title', 'Users Report')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>Filter Data</h2>
    </div>
    <div style="padding: 20px;">
        <form method="GET" action="{{ route('admin.reports.users') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
            <div class="form-group" style="margin: 0;">
                <label>From Date</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="form-group" style="margin: 0;">
                <label>To Date</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="form-group" style="margin: 0;">
                <label>User Type</label>
                <select name="is_admin" class="form-control">
                    <option value="">All</option>
                    <option value="1" {{ request('is_admin') == '1' ? 'selected' : '' }}>Admin</option>
                    <option value="0" {{ request('is_admin') == '0' ? 'selected' : '' }}>Regular User</option>
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.reports.users') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Users</h3>
        <div class="stat-value">{{ $total_users }}</div>
    </div>
    <div class="stat-card">
        <h3>Admins</h3>
        <div class="stat-value">{{ $admin_users }}</div>
    </div>
    <div class="stat-card">
        <h3>Regular Users</h3>
        <div class="stat-value">{{ $regular_users }}</div>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>User Growth (Last 30 Days)</h2>
        <div>
            <a href="{{ route('admin.reports.users', array_merge(request()->all(), ['export' => 'pdf'])) }}" class="btn btn-primary">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <a href="{{ route('admin.reports.users', array_merge(request()->all(), ['export' => 'excel'])) }}" class="btn btn-primary">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
    </div>
    <div style="padding: 20px;">
        <canvas id="userGrowthChart" style="max-height: 300px;"></canvas>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Users by Registration Method</h2>
    </div>
    <div style="padding: 20px;">
        <canvas id="usersByProviderChart" style="max-height: 300px;"></canvas>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Users List</h2>
    </div>
    <table class="admin-table">
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
            @forelse($users as $user)
                <tr>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    <td>{{ $user->quiz_results_count }}</td>
                    <td>{{ $user->progress_count }}</td>
                    <td>{{ $user->is_admin ? 'Admin' : 'Regular User' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">No data available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // User Growth Chart
    const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
    const userGrowthData = @json($user_growth);
    
    new Chart(userGrowthCtx, {
        type: 'line',
        data: {
            labels: userGrowthData.map(item => item.date),
            datasets: [{
                label: 'Number of Users',
                data: userGrowthData.map(item => item.count),
                borderColor: '#04aa6d',
                backgroundColor: 'rgba(4, 170, 109, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Users by Provider Chart
    const usersByProviderCtx = document.getElementById('usersByProviderChart').getContext('2d');
    const usersByProviderData = @json($users_by_provider);
    
    new Chart(usersByProviderCtx, {
        type: 'doughnut',
        data: {
            labels: usersByProviderData.map(item => item.provider || 'Email'),
            datasets: [{
                data: usersByProviderData.map(item => item.count),
                backgroundColor: [
                    '#04aa6d',
                    '#1d1e27',
                    '#6c757d',
                    '#dc3545'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush
