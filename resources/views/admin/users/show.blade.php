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
                <th>Actions</th>
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
                    <td>
                        @if($progress->progress_percent < 100)
                            <form action="{{ route('admin.users.tracks.complete', [$user, $progress->track]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Mark this track as completed for {{ $user->name }}? A certificate will be issued automatically.');">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">
                                    <i class="fas fa-check"></i> Complete
                                </button>
                            </form>
                        @else
                            <span style="color: #28a745; font-weight: bold;">Completed</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No progress recorded</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>All Tracks - Complete Track for User</h2>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Track</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($allTracks as $track)
                @php
                    $userProgress = $user->progress->where('track_id', $track->id)->first();
                    $isCompleted = $userProgress && $userProgress->progress_percent >= 100;
                @endphp
                <tr>
                    <td>{{ $track->title }}</td>
                    <td>
                        @if($isCompleted)
                            <span style="color: #28a745; font-weight: bold;">Completed</span>
                        @elseif($userProgress)
                            <span style="color: #ffc107;">In Progress ({{ $userProgress->progress_percent }}%)</span>
                        @else
                            <span style="color: #6c757d;">Not Started</span>
                        @endif
                    </td>
                    <td>
                        @if(!$isCompleted)
                            <form action="{{ route('admin.users.tracks.complete', [$user, $track]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Mark track \"{{ $track->title }}\" as completed for {{ $user->name }}? A certificate will be issued automatically.');">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">
                                    <i class="fas fa-check"></i> Complete Track
                                </button>
                            </form>
                        @else
                            <span style="color: #28a745; font-weight: bold;">✓ Completed</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">No tracks available</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

