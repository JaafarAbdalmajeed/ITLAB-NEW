@extends('admin.layout')

@section('title', 'View Certificate')
@section('page-title', 'View Certificate: ' . $certificate->certificate_number)

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>Certificate Details</h2>
        <div>
            <a href="{{ route('admin.certificates.index') }}" class="btn btn-secondary" style="margin-left: 10px;">
                <i class="fas fa-arrow-right"></i> Back to List
            </a>
            <a href="{{ route('admin.certificates.edit', $certificate) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
        <div>
            <h3 style="margin-bottom: 15px; font-size: 16px; color: #666;">Certificate Information</h3>
            <table class="admin-table" style="margin-bottom: 0;">
                <tr>
                    <td style="font-weight: 600; width: 150px;">Certificate Number:</td>
                    <td><strong>{{ $certificate->certificate_number }}</strong></td>
                </tr>
                <tr>
                    <td style="font-weight: 600;">Track:</td>
                    <td>{{ $certificate->track->title }}</td>
                </tr>
                <tr>
                    <td style="font-weight: 600;">Issued Date:</td>
                    <td>{{ $certificate->issued_at->format('Y/m/d') }}</td>
                </tr>
                <tr>
                    <td style="font-weight: 600;">Created At:</td>
                    <td>{{ $certificate->created_at->format('Y/m/d H:i') }}</td>
                </tr>
            </table>
        </div>

        <div>
            <h3 style="margin-bottom: 15px; font-size: 16px; color: #666;">User Information</h3>
            <table class="admin-table" style="margin-bottom: 0;">
                <tr>
                    <td style="font-weight: 600; width: 150px;">Name:</td>
                    <td>{{ $certificate->user->name }}</td>
                </tr>
                <tr>
                    <td style="font-weight: 600;">Email:</td>
                    <td>{{ $certificate->user->email }}</td>
                </tr>
                <tr>
                    <td style="font-weight: 600;">User Type:</td>
                    <td>
                        @if($certificate->user->is_admin)
                            <span style="color: var(--admin-secondary); font-weight: bold;">Admin</span>
                        @else
                            <span>User</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--admin-border);">
        <h3 style="margin-bottom: 15px; font-size: 16px; color: #666;">Actions</h3>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('admin.certificates.view', $certificate) }}" class="btn btn-primary" target="_blank">
                <i class="fas fa-eye"></i> View Certificate
            </a>
            <a href="{{ route('admin.certificates.download', $certificate) }}" class="btn btn-secondary" target="_blank">
                <i class="fas fa-download"></i> Download PDF
            </a>
            <a href="{{ route('admin.users.show', $certificate->user) }}" class="btn btn-secondary">
                <i class="fas fa-user"></i> View User
            </a>
            <a href="{{ route('admin.tracks.show', $certificate->track) }}" class="btn btn-secondary">
                <i class="fas fa-book"></i> View Track
            </a>
            <form action="{{ route('admin.certificates.destroy', $certificate) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this certificate?')">
                    <i class="fas fa-trash"></i> Delete Certificate
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

