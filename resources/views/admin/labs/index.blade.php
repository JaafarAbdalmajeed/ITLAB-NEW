@extends('admin.layout')

@section('title', 'Manage Labs')
@section('page-title', 'Labs: ' . $track->title)

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>All Labs</h2>
        <div>
            <a href="{{ route('admin.tracks.index') }}" class="btn btn-secondary" style="margin-left: 10px;">
                <i class="fas fa-arrow-right"></i> Back to Tracks
            </a>
            <a href="{{ route('admin.tracks.labs.create', $track) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Lab
            </a>
        </div>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Scenario</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($labs as $lab)
                <tr>
                    <td><strong>{{ $lab->title }}</strong></td>
                    <td>{{ \Illuminate\Support\Str::limit($lab->scenario, 100) }}</td>
                    <td>
                        <a href="{{ route('admin.tracks.labs.edit', [$track, $lab]) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px; margin-left: 5px;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.tracks.labs.destroy', [$track, $lab]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;" onclick="return confirm('Are you sure you want to delete this lab?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">No labs found. <a href="{{ route('admin.tracks.labs.create', $track) }}">Add a new lab</a></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

