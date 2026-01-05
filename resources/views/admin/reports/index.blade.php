@extends('admin.layout')

@section('title', 'Reports')
@section('page-title', 'Reports')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Users</h3>
        <div class="stat-value">{{ $stats['total_users'] }}</div>
    </div>
    <div class="stat-card">
        <h3>Total Tracks</h3>
        <div class="stat-value">{{ $stats['total_tracks'] }}</div>
    </div>
    <div class="stat-card">
        <h3>Total Quizzes</h3>
        <div class="stat-value">{{ $stats['total_quizzes'] }}</div>
    </div>
    <div class="stat-card">
        <h3>Total Certificates</h3>
        <div class="stat-value">{{ $stats['total_certificates'] }}</div>
    </div>
</div>

<div class="admin-card" style="margin-top: 20px;">
    <div class="admin-card-header">
        <h2>Available Reports</h2>
    </div>
    <div style="padding: 20px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            <a href="{{ route('admin.reports.users') }}" class="report-card" style="text-decoration: none; color: inherit;">
                <div style="background: var(--admin-card); padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: transform 0.2s;">
                    <div style="font-size: 48px; color: var(--admin-secondary); margin-bottom: 15px;">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 style="margin: 0 0 10px 0; font-size: 20px;">Users Report</h3>
                    <p style="margin: 0; color: #666; font-size: 14px;">View user details and registration statistics</p>
                </div>
            </a>

            <a href="{{ route('admin.reports.tracks') }}" class="report-card" style="text-decoration: none; color: inherit;">
                <div style="background: var(--admin-card); padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: transform 0.2s;">
                    <div style="font-size: 48px; color: var(--admin-secondary); margin-bottom: 15px;">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3 style="margin: 0 0 10px 0; font-size: 20px;">Tracks Report</h3>
                    <p style="margin: 0; color: #666; font-size: 14px;">View track performance and completion rates</p>
                </div>
            </a>

            <a href="{{ route('admin.reports.quizzes') }}" class="report-card" style="text-decoration: none; color: inherit;">
                <div style="background: var(--admin-card); padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: transform 0.2s;">
                    <div style="font-size: 48px; color: var(--admin-secondary); margin-bottom: 15px;">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <h3 style="margin: 0 0 10px 0; font-size: 20px;">Quizzes Report</h3>
                    <p style="margin: 0; color: #666; font-size: 14px;">View quiz performance and results</p>
                </div>
            </a>

            <a href="{{ route('admin.reports.certificates') }}" class="report-card" style="text-decoration: none; color: inherit;">
                <div style="background: var(--admin-card); padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: transform 0.2s;">
                    <div style="font-size: 48px; color: var(--admin-secondary); margin-bottom: 15px;">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3 style="margin: 0 0 10px 0; font-size: 20px;">Certificates Report</h3>
                    <p style="margin: 0; color: #666; font-size: 14px;">View issued certificates and statistics</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .report-card:hover div {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
</style>
@endpush

