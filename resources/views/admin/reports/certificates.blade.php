@extends('admin.layout')

@section('title', 'Certificates Report')
@section('page-title', 'Certificates Report')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>Filter Data</h2>
    </div>
    <div style="padding: 20px;">
        <form method="GET" action="{{ route('admin.reports.certificates') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
            <div class="form-group" style="margin: 0;">
                <label>Type</label>
                <select name="type" class="form-control">
                    <option value="">All</option>
                    <option value="track" {{ request('type') == 'track' ? 'selected' : '' }}>Track</option>
                    <option value="quiz" {{ request('type') == 'quiz' ? 'selected' : '' }}>Quiz</option>
                </select>
            </div>
            <div class="form-group" style="margin: 0;">
                <label>From Date</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="form-group" style="margin: 0;">
                <label>To Date</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.reports.certificates') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Certificates</h3>
        <div class="stat-value">{{ $total_certificates }}</div>
    </div>
    <div class="stat-card">
        <h3>Track Certificates</h3>
        <div class="stat-value">{{ $certificates_by_type['track'] }}</div>
    </div>
    <div class="stat-card">
        <h3>Quiz Certificates</h3>
        <div class="stat-value">{{ $certificates_by_type['quiz'] }}</div>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Certificates Issued (Last 30 Days)</h2>
        <div>
            <a href="{{ route('admin.reports.certificates', array_merge(request()->all(), ['export' => 'pdf'])) }}" class="btn btn-primary">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <a href="{{ route('admin.reports.certificates', array_merge(request()->all(), ['export' => 'excel'])) }}" class="btn btn-primary">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
    </div>
    <div style="padding: 20px;">
        <canvas id="certificatesOverTimeChart" style="max-height: 300px;"></canvas>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Certificates by Type</h2>
    </div>
    <div style="padding: 20px;">
        <canvas id="certificatesByTypeChart" style="max-height: 300px;"></canvas>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Certificates by Track</h2>
    </div>
    <div style="padding: 20px;">
        <canvas id="certificatesByTrackChart" style="max-height: 300px;"></canvas>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Top Certificate Earners</h2>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Number of Certificates</th>
            </tr>
        </thead>
        <tbody>
            @forelse($top_earners as $earner)
                <tr>
                    <td><strong>{{ $earner['user']->name ?? 'N/A' }}</strong></td>
                    <td>{{ $earner['count'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" style="text-align: center;">No data available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Certificates List</h2>
    </div>
    <table class="admin-table">
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
            @forelse($certificates as $certificate)
                <tr>
                    <td><strong>{{ $certificate->certificate_number }}</strong></td>
                    <td>{{ $certificate->user->name ?? 'N/A' }}</td>
                    <td>{{ $certificate->track->title ?? 'N/A' }}</td>
                    <td>{{ $certificate->quiz->title ?? 'N/A' }}</td>
                    <td>{{ $certificate->type }}</td>
                    <td>{{ $certificate->issued_at->format('Y-m-d') }}</td>
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
    // Certificates Over Time Chart
    const certificatesOverTimeCtx = document.getElementById('certificatesOverTimeChart').getContext('2d');
    const certificatesOverTimeData = @json($certificates_over_time);
    
    new Chart(certificatesOverTimeCtx, {
        type: 'line',
        data: {
            labels: certificatesOverTimeData.map(item => item.date),
            datasets: [{
                label: 'Number of Certificates',
                data: certificatesOverTimeData.map(item => item.count),
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

    // Certificates by Type Chart
    const certificatesByTypeCtx = document.getElementById('certificatesByTypeChart').getContext('2d');
    const certificatesByTypeData = @json($certificates_by_type);
    
    new Chart(certificatesByTypeCtx, {
        type: 'doughnut',
        data: {
            labels: ['Track', 'Quiz'],
            datasets: [{
                data: [certificatesByTypeData.track, certificatesByTypeData.quiz],
                backgroundColor: ['#04aa6d', '#1d1e27']
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

    // Certificates by Track Chart
    const certificatesByTrackCtx = document.getElementById('certificatesByTrackChart').getContext('2d');
    const certificatesByTrackData = @json($certificates_by_track);
    
    new Chart(certificatesByTrackCtx, {
        type: 'bar',
        data: {
            labels: certificatesByTrackData.map(item => item.track?.title || 'N/A'),
            datasets: [{
                label: 'Number of Certificates',
                data: certificatesByTrackData.map(item => item.count),
                backgroundColor: '#04aa6d'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
