@extends('admin.layout')

@section('title', 'Edit Certificate')
@section('page-title', 'Edit Certificate: ' . $certificate->certificate_number)

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>Edit Certificate</h2>
        <div>
            <a href="{{ route('admin.certificates.index') }}" class="btn btn-secondary" style="margin-left: 10px;">
                <i class="fas fa-arrow-right"></i> Back to List
            </a>
            <a href="{{ route('admin.certificates.show', $certificate) }}" class="btn btn-secondary">
                <i class="fas fa-eye"></i> View
            </a>
        </div>
    </div>

    <form action="{{ route('admin.certificates.update', $certificate) }}" method="POST">
        @csrf
        @method('PUT')

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label for="user_id">User *</label>
            <select id="user_id" name="user_id" class="form-control" required>
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $certificate->user_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="track_id">Track *</label>
            <select id="track_id" name="track_id" class="form-control" required>
                <option value="">Select Track</option>
                @foreach($tracks as $track)
                    <option value="{{ $track->id }}" {{ old('track_id', $certificate->track_id) == $track->id ? 'selected' : '' }}>
                        {{ $track->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="certificate_number">Certificate Number *</label>
            <input type="text" id="certificate_number" name="certificate_number" class="form-control" value="{{ old('certificate_number', $certificate->certificate_number) }}" required>
            <small style="color: #666;">Must be unique</small>
        </div>

        <div class="form-group">
            <label for="issued_at">Issued Date *</label>
            <input type="date" id="issued_at" name="issued_at" class="form-control" value="{{ old('issued_at', $certificate->issued_at->format('Y-m-d')) }}" required>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
            <a href="{{ route('admin.certificates.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection

