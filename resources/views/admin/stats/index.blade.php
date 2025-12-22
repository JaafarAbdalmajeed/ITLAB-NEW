@extends('admin.layout')

@section('title', 'Advanced Statistics')
@section('page-title', 'Advanced Statistics')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Tracks</h3>
        <div class="stat-value">{{ $stats['tracks'] }}</div>
    </div>
    <div class="stat-card">
        <h3>Total Lessons</h3>
        <div class="stat-value">{{ $stats['lessons'] }}</div>
    </div>
    <div class="stat-card">
        <h3>Total Quizzes</h3>
        <div class="stat-value">{{ $stats['quizzes'] }}</div>
    </div>
    <div class="stat-card">
        <h3>Total Labs</h3>
        <div class="stat-value">{{ $stats['labs'] }}</div>
    </div>
    <div class="stat-card">
        <h3>Total Users</h3>
        <div class="stat-value">{{ $stats['users'] }}</div>
    </div>
    <div class="stat-card">
        <h3>Total Quiz Results</h3>
        <div class="stat-value">{{ $stats['quiz_results'] }}</div>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Advanced Statistics</h2>
    </div>
    <div style="padding: 20px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div>
                <strong>Total Quiz Attempts:</strong>
                <div style="font-size: 24px; color: var(--admin-secondary); margin-top: 5px;">{{ $advancedStats['total_quiz_attempts'] }}</div>
            </div>
            <div>
                <strong>Average Quiz Score:</strong>
                <div style="font-size: 24px; color: var(--admin-secondary); margin-top: 5px;">{{ $advancedStats['average_quiz_score'] }}%</div>
            </div>
            <div>
                <strong>Active Users:</strong>
                <div style="font-size: 24px; color: var(--admin-secondary); margin-top: 5px;">{{ $advancedStats['users_with_progress'] }}</div>
            </div>
            <div>
                <strong>Completed Tracks:</strong>
                <div style="font-size: 24px; color: var(--admin-secondary); margin-top: 5px;">{{ $advancedStats['completed_tracks'] }}</div>
            </div>
        </div>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Top Performing Tracks</h2>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Track</th>
                <th>Number of Users</th>
                <th>Lessons</th>
                <th>Quizzes</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topTracks as $track)
                <tr>
                    <td><strong>{{ $track->title }}</strong></td>
                    <td>{{ $track->user_progress_count }}</td>
                    <td>{{ $track->lessons_count }}</td>
                    <td>{{ $track->quizzes_count }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No tracks found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Quiz Performance by Track</h2>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Track</th>
                <th>Average Score</th>
                <th>Number of Attempts</th>
            </tr>
        </thead>
        <tbody>
            @forelse($quizPerformance as $performance)
                <tr>
                    <td><strong>{{ $performance->track->title ?? 'N/A' }}</strong></td>
                    <td><strong>{{ number_format($performance->avg_score, 1) }}%</strong></td>
                    <td>{{ $performance->attempts }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">No data available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Recent Activities</h2>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Quiz</th>
                <th>Track</th>
                <th>Score</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentQuizResults as $result)
                <tr>
                    <td>{{ $result->user->name }}</td>
                    <td>{{ $result->quiz->title }}</td>
                    <td>{{ $result->quiz->track->title }}</td>
                    <td><strong>{{ $result->score }}%</strong></td>
                    <td>{{ $result->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No recent activities</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

