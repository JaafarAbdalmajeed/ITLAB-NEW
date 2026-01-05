@extends('admin.layout')

@section('title', 'Manage Certificates')
@section('page-title', 'Manage Certificates')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>All Certificates</h2>
        <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Certificate
        </a>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.certificates.index') }}" style="margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap; align-items: end;">
        <div style="flex: 1; min-width: 200px;">
            <label for="search" style="display: block; margin-bottom: 5px; font-size: 13px;">Search by Certificate Number:</label>
            <input type="text" id="search" name="search" class="form-control" value="{{ request('search') }}" placeholder="CERT-XXXXX-YYYY">
        </div>
        <div style="flex: 1; min-width: 200px;">
            <label for="track_id" style="display: block; margin-bottom: 5px; font-size: 13px;">Track:</label>
            <select id="track_id" name="track_id" class="form-control">
                <option value="">All Tracks</option>
                @foreach($tracks as $track)
                    <option value="{{ $track->id }}" {{ request('track_id') == $track->id ? 'selected' : '' }}>
                        {{ $track->title }}
                    </option>
                @endforeach
            </select>
        </div>
        <div style="flex: 1; min-width: 200px;">
            <label for="user_id" style="display: block; margin-bottom: 5px; font-size: 13px;">User:</label>
            <select id="user_id" name="user_id" class="form-control">
                <option value="">All Users</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit" class="btn btn-primary" style="margin-top: 20px;">
                <i class="fas fa-search"></i> Search
            </button>
            <a href="{{ route('admin.certificates.index') }}" class="btn btn-secondary" style="margin-top: 20px;">
                <i class="fas fa-times"></i> Reset
            </a>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="admin-table">
        <thead>
            <tr>
                <th>Certificate Number</th>
                <th>User</th>
                <th>Track</th>
                <th>Issued Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($certificates as $certificate)
                <tr>
                    <td><strong>{{ $certificate->certificate_number ?? 'N/A' }}</strong></td>
                    <td>{{ $certificate->user->name ?? 'Deleted User' }}</td>
                    <td>{{ $certificate->track->title ?? 'Deleted Track' }}</td>
                    <td>{{ $certificate->issued_at ? $certificate->issued_at->format('Y/m/d') : 'N/A' }}</td>
                    <td>
                        @if($certificate->user && $certificate->track)
                            <a href="{{ route('admin.certificates.view', $certificate->id) }}" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px; margin-left: 5px;" target="_blank" title="View Certificate">
                                <i class="fas fa-certificate"></i> View Certificate
                            </a>
                        @endif
                        <a href="{{ route('admin.certificates.show', $certificate->id) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px; margin-left: 5px;" title="View Details">
                            <i class="fas fa-eye"></i> Details
                        </a>
                        <a href="{{ route('admin.certificates.edit', $certificate->id) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px; margin-left: 5px;" title="Edit Certificate">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.certificates.destroy', $certificate->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;" onclick="return confirm('Are you sure you want to delete this certificate?')" title="Delete Certificate">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No certificates found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="margin-top: 20px;">
        {{ $certificates->appends(request()->query())->links() }}
    </div>
</div>
@endsection

