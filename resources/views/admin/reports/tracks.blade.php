@extends('admin.layout')

@section('title', 'Tracks Report')
@section('page-title', 'Tracks Report')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>Filter Data</h2>
    </div>
    <div style="padding: 20px;">
        <form method="GET" action="{{ route('admin.reports.tracks') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
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
                <a href="{{ route('admin.reports.tracks') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Tracks</h3>
        <div class="stat-value">{{ $total_tracks }}</div>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Top Performing Tracks</h2>
        <div>
            <a href="{{ route('admin.reports.tracks', array_merge(request()->all(), ['export' => 'pdf'])) }}" class="btn btn-primary">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <a href="{{ route('admin.reports.tracks', array_merge(request()->all(), ['export' => 'excel'])) }}" class="btn btn-primary">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
    </div>
    <div style="padding: 20px;">
        <canvas id="topTracksChart" style="max-height: 300px;"></canvas>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Completion Rates</h2>
    </div>
    <div style="padding: 20px;">
        <canvas id="completionRatesChart" style="max-height: 300px;"></canvas>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Tracks List</h2>
    </div>
    <table class="admin-table">
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
            @forelse($tracks as $track)
                <tr>
                    <td><strong>{{ $track->title }}</strong></td>
                    <td>{{ $track->lessons_count }}</td>
                    <td>{{ $track->quizzes_count }}</td>
                    <td>{{ $track->labs_count }}</td>
                    <td>{{ $track->user_progress_count }}</td>
                    <td>{{ $track->certificates_count }}</td>
                    <td>
                        @php
                            $completion = $completion_rates[$track->id]['completion_rate'] ?? 0;
                        @endphp
                        <strong>{{ $completion }}%</strong>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">No data available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Top Tracks Chart
    const topTracksCtx = document.getElementById('topTracksChart').getContext('2d');
    const topTracksData = @json($top_tracks);
    
    new Chart(topTracksCtx, {
        type: 'bar',
        data: {
            labels: topTracksData.map(item => item.title),
            datasets: [{
                label: 'Number of Users',
                data: topTracksData.map(item => item.user_progress_count),
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

    // Completion Rates Chart
    const completionRatesCtx = document.getElementById('completionRatesChart').getContext('2d');
    const completionRatesData = @json($completion_rates);
    const tracks = @json($tracks);
    
    const completionLabels = tracks.slice(0, 10).map(track => track.title);
    const completionValues = tracks.slice(0, 10).map(track => {
        return completionRatesData[track.id]?.completion_rate || 0;
    });
    
    new Chart(completionRatesCtx, {
        type: 'line',
        data: {
            labels: completionLabels,
            datasets: [{
                label: 'Completion Rate (%)',
                data: completionValues,
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
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
</script>
@endpush
