@extends('admin.layout')

@section('title', 'Quizzes Report')
@section('page-title', 'Quizzes Report')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>Filter Data</h2>
    </div>
    <div style="padding: 20px;">
        <form method="GET" action="{{ route('admin.reports.quizzes') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
            <div class="form-group" style="margin: 0;">
                <label>Track</label>
                <select name="track_id" class="form-control">
                    <option value="">All</option>
                    @foreach($tracks as $track)
                        <option value="{{ $track->id }}" {{ request('track_id') == $track->id ? 'selected' : '' }}>
                            {{ $track->title }}
                        </option>
                    @endforeach
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
                <a href="{{ route('admin.reports.quizzes') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Quizzes</h3>
        <div class="stat-value">{{ $total_quizzes }}</div>
    </div>
    <div class="stat-card">
        <h3>Total Attempts</h3>
        <div class="stat-value">{{ $total_attempts }}</div>
    </div>
    <div class="stat-card">
        <h3>Average Score</h3>
        <div class="stat-value">{{ $avg_score }}%</div>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Quiz Attempts (Last 30 Days)</h2>
        <div>
            <a href="{{ route('admin.reports.quizzes', array_merge(request()->all(), ['export' => 'pdf'])) }}" class="btn btn-primary">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <a href="{{ route('admin.reports.quizzes', array_merge(request()->all(), ['export' => 'excel'])) }}" class="btn btn-primary">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
    </div>
    <div style="padding: 20px;">
        <canvas id="quizAttemptsChart" style="max-height: 300px;"></canvas>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Average Scores by Track</h2>
    </div>
    <div style="padding: 20px;">
        <canvas id="avgScoresByTrackChart" style="max-height: 300px;"></canvas>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Quizzes List</h2>
    </div>
    <table class="admin-table">
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
            @forelse($quizzes as $quiz)
                @php
                    $performance = $quiz_performance[$quiz->id] ?? null;
                @endphp
                <tr>
                    <td><strong>{{ $quiz->title }}</strong></td>
                    <td>{{ $quiz->track->title ?? 'N/A' }}</td>
                    <td>{{ $quiz->questions_count }}</td>
                    <td>{{ $performance['total_attempts'] ?? 0 }}</td>
                    <td><strong>{{ $performance['avg_score'] ?? 0 }}%</strong></td>
                    <td>{{ $performance['max_score'] ?? 0 }}%</td>
                    <td>{{ $performance['min_score'] ?? 0 }}%</td>
                    <td>
                        <strong style="color: {{ ($performance['pass_rate'] ?? 0) >= 70 ? '#04aa6d' : '#dc3545' }}">
                            {{ $performance['pass_rate'] ?? 0 }}%
                        </strong>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">No data available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Quiz Attempts Chart
    const quizAttemptsCtx = document.getElementById('quizAttemptsChart').getContext('2d');
    const quizAttemptsData = @json($quiz_attempts_over_time);
    
    new Chart(quizAttemptsCtx, {
        type: 'line',
        data: {
            labels: quizAttemptsData.map(item => item.date),
            datasets: [{
                label: 'Number of Attempts',
                data: quizAttemptsData.map(item => item.count),
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

    // Average Scores by Track Chart
    const avgScoresByTrackCtx = document.getElementById('avgScoresByTrackChart').getContext('2d');
    const avgScoresByTrackData = @json($avg_scores_by_track);
    
    new Chart(avgScoresByTrackCtx, {
        type: 'bar',
        data: {
            labels: avgScoresByTrackData.map(item => item.track?.title || 'N/A'),
            datasets: [{
                label: 'Average Score (%)',
                data: avgScoresByTrackData.map(item => item.avg_score),
                backgroundColor: '#04aa6d'
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
