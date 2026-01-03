@extends('admin.layout')

@section('title', 'Create Certificate')
@section('page-title', 'Create Certificate')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>Create Certificate</h2>
        <div>
            <a href="{{ route('admin.certificates.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-right"></i> Back to List
            </a>
        </div>
    </div>

    <form action="{{ route('admin.certificates.store') }}" method="POST">
        @csrf

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
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
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
                    <option value="{{ $track->id }}" {{ old('track_id') == $track->id ? 'selected' : '' }}>
                        {{ $track->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="certificate_number">Certificate Number</label>
            <input type="text" id="certificate_number" name="certificate_number" class="form-control" value="{{ old('certificate_number') }}" placeholder="Leave empty to auto-generate">
            <small style="color: #666;">Leave empty to auto-generate a unique certificate number</small>
        </div>

        <div class="form-group">
            <label for="issued_at">Issued Date</label>
            <input type="date" id="issued_at" name="issued_at" class="form-control" value="{{ old('issued_at', date('Y-m-d')) }}">
            <small style="color: #666;">Leave empty to use today's date</small>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create Certificate
            </button>
            <a href="{{ route('admin.certificates.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection

