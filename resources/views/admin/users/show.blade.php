@extends('admin.layout')

@section('title', 'User Details - ' . $user->name)
@section('page-title', 'User Details')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>User Information</h2>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
    </div>
    <div style="padding: 20px;">
        <div style="margin-bottom: 20px;">
            <strong>Name:</strong> {{ $user->name }}
        </div>
        <div style="margin-bottom: 20px;">
            <strong>Email:</strong> {{ $user->email }}
        </div>
        <div style="margin-bottom: 20px;">
            <strong>User Type:</strong> 
            @if($user->is_admin)
                <span style="color: var(--admin-secondary); font-weight: bold;">Admin</span>
            @else
                <span>User</span>
            @endif
        </div>
        <div style="margin-bottom: 20px;">
            <strong>Registration Date:</strong> {{ $user->created_at->format('Y-m-d H:i') }}
        </div>
    </div>
</div>

<div class="stats-grid" style="margin-top: 20px;">
    <div class="stat-card">
        <h3>Quizzes Taken</h3>
        <div class="stat-value">{{ $stats['total_quizzes_taken'] }}</div>
    </div>
    <div class="stat-card">
        <h3>Average Score</h3>
        <div class="stat-value">{{ number_format($stats['average_score'], 1) }}%</div>
    </div>
    <div class="stat-card">
        <h3>Completed Tracks</h3>
        <div class="stat-value">{{ $stats['completed_tracks'] }}</div>
    </div>
    <div class="stat-card">
        <h3>Tracks in Progress</h3>
        <div class="stat-value">{{ $stats['in_progress_tracks'] }}</div>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Quiz Results</h2>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Quiz</th>
                <th>Track</th>
                <th>Score</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($user->quizResults as $result)
                <tr>
                    <td>{{ $result->quiz->title }}</td>
                    <td>{{ $result->quiz->track->title }}</td>
                    <td><strong>{{ $result->score }}%</strong></td>
                    <td>{{ $result->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No quiz results found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>User Progress</h2>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Track</th>
                <th>Completion Percentage</th>
                <th>Last Updated</th>
            </tr>
        </thead>
        <tbody>
            @forelse($user->progress as $progress)
                <tr>
                    <td>{{ $progress->track->title }}</td>
                    <td>
                        <div style="background: #e0e0e0; border-radius: 5px; height: 20px; position: relative;">
                            <div style="background: var(--admin-secondary); height: 100%; width: {{ $progress->progress_percent }}%; border-radius: 5px;"></div>
                            <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 12px; font-weight: bold;">{{ $progress->progress_percent }}%</span>
                        </div>
                    </td>
                    <td>{{ $progress->updated_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">No progress recorded</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

