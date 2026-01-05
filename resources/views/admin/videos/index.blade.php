@extends('admin.layout')

@section('title', 'Manage Videos')
@section('page-title', 'Videos: ' . $track->title)

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>All Videos</h2>
        <div>
            <a href="{{ route('admin.tracks.index') }}" class="btn btn-secondary" style="margin-left: 10px;">
                <i class="fas fa-arrow-right"></i> Back to Tracks
            </a>
            <a href="{{ route('admin.tracks.videos.create', $track) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Video
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <table class="admin-table">
        <thead>
            <tr>
                <th>Order</th>
                <th>Title</th>
                <th>Video ID</th>
                <th>Color</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($videos as $video)
                <tr>
                    <td><strong>{{ $video->order }}</strong></td>
                    <td><strong>{{ $video->title }}</strong></td>
                    <td>{{ $video->video_id ?? $video->url ?? 'N/A' }}</td>
                    <td>
                        <span style="display: inline-block; width: 30px; height: 20px; background: {{ $video->color }}; border: 1px solid #ddd; border-radius: 3px;"></span>
                        {{ $video->color }}
                    </td>
                    <td>
                        <a href="{{ route('admin.tracks.videos.edit', [$track, $video]) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px; margin-left: 5px;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.tracks.videos.destroy', [$track, $video]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;" onclick="return confirm('Are you sure you want to delete this video?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No videos found. <a href="{{ route('admin.tracks.videos.create', $track) }}">Add a new video</a></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

