@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <h3>Tracks</h3>
        <div class="stat-value">{{ $stats['tracks'] }}</div>
    </div>
    <div class="stat-card">
        <h3>Lessons</h3>
        <div class="stat-value">{{ $stats['lessons'] }}</div>
    </div>
    <div class="stat-card">
        <h3>Quizzes</h3>
        <div class="stat-value">{{ $stats['quizzes'] }}</div>
    </div>
    <div class="stat-card">
        <h3>Labs</h3>
        <div class="stat-value">{{ $stats['labs'] }}</div>
    </div>
    <div class="stat-card">
        <h3>Pages</h3>
        <div class="stat-value">{{ $stats['pages'] }}</div>
    </div>
    <div class="stat-card">
        <h3>Users</h3>
        <div class="stat-value">{{ $stats['users'] }}</div>
    </div>
    <div class="stat-card">
        <h3>Quiz Results</h3>
        <div class="stat-value">{{ $stats['quiz_results'] }}</div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h2>Recent Tracks</h2>
        <a href="{{ route('admin.tracks.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Track
        </a>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Slug</th>
                <th>Created Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentTracks as $track)
                <tr>
                    <td>{{ $track->title }}</td>
                    <td><code>{{ $track->slug }}</code></td>
                    <td>{{ $track->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.tracks.edit', $track) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No tracks found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h2>New Users</h2>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Registration Date</th>
                <th>User Type</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentUsers as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    <td>
                        @if($user->is_admin)
                            <span style="color: var(--admin-secondary); font-weight: bold;">Admin</span>
                        @else
                            <span>User</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No users found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

