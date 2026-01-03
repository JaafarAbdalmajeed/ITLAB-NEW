@extends('admin.layout')

@section('title', 'Track Details - ' . $track->title)
@section('page-title', 'Track Details: ' . $track->title)

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>Track Information</h2>
        <div>
            <a href="{{ route('admin.tracks.index') }}" class="btn btn-secondary" style="margin-left: 10px;">
                <i class="fas fa-arrow-right"></i> Back to List
            </a>
            <a href="{{ route('admin.tracks.edit', $track) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>

    <div style="padding: 20px;">
        <div style="margin-bottom: 20px;">
            <strong>Title:</strong> {{ $track->title }}
        </div>
        <div style="margin-bottom: 20px;">
            <strong>Slug:</strong> <code>{{ $track->slug }}</code>
        </div>
        <div style="margin-bottom: 20px;">
            <strong>Description:</strong> {{ $track->description ?? 'N/A' }}
        </div>
    </div>
</div>

<div class="stats-grid" style="margin-top: 20px;">
    <div class="stat-card">
        <h3>Lessons</h3>
        <div class="stat-value">{{ $track->lessons_count }}</div>
    </div>
    <div class="stat-card">
        <h3>Quizzes</h3>
        <div class="stat-value">{{ $track->quizzes_count }}</div>
    </div>
    <div class="stat-card">
        <h3>Labs</h3>
        <div class="stat-value">{{ $track->labs_count }}</div>
    </div>
    <div class="stat-card">
        <h3>Completed Students</h3>
        <div class="stat-value">{{ $track->completed_students_count ?? 0 }}</div>
    </div>
    <div class="stat-card">
        <h3>Certificates Issued</h3>
        <div class="stat-value">{{ $track->certificates_count ?? 0 }}</div>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Completed Students ({{ $completedStudents->count() }})</h2>
    </div>
    @if($completedStudents->count() > 0)
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Completed Date</th>
                    <th>Certificate</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($completedStudents as $progress)
                    <tr>
                        <td><strong>{{ $progress->user->name }}</strong></td>
                        <td>{{ $progress->user->email }}</td>
                        <td>{{ $progress->updated_at->format('Y-m-d H:i') }}</td>
                        <td>
                            @php
                                $certificate = $track->certificates()->where('user_id', $progress->user_id)->first();
                            @endphp
                            @if($certificate)
                                <span style="color: #28a745; font-weight: bold;">
                                    <i class="fas fa-certificate"></i> {{ $certificate->certificate_number }}
                                </span>
                            @else
                                <span style="color: #ffc107;">No Certificate</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.users.show', $progress->user) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px;">
                                <i class="fas fa-user"></i> View User
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="padding: 20px; text-align: center; color: #666;">
            No students have completed this track yet.
        </div>
    @endif
</div>

@if($inProgressStudents->count() > 0)
<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Students in Progress ({{ $inProgressStudents->count() }})</h2>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Email</th>
                <th>Progress</th>
                <th>Last Updated</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inProgressStudents as $progress)
                <tr>
                    <td><strong>{{ $progress->user->name }}</strong></td>
                    <td>{{ $progress->user->email }}</td>
                    <td>
                        <div style="background: #e0e0e0; border-radius: 5px; height: 20px; position: relative; width: 200px;">
                            <div style="background: var(--admin-secondary); height: 100%; width: {{ $progress->progress_percent }}%; border-radius: 5px;"></div>
                            <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 12px; font-weight: bold;">{{ $progress->progress_percent }}%</span>
                        </div>
                    </td>
                    <td>{{ $progress->updated_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.users.show', $progress->user) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px;">
                            <i class="fas fa-user"></i> View User
                        </a>
                        <form action="{{ route('admin.users.tracks.complete', [$progress->user, $track]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Mark this track as completed for {{ $progress->user->name }}?');">
                            @csrf
                            <button type="submit" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">
                                <i class="fas fa-check"></i> Complete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection

