@extends('layouts.app')

@section('title', 'Leaderboard — ITLAB')
@section('body-class', 'page-leaderboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    body.page-leaderboard {
        margin: 0;
        min-height: 100vh;
        font-family: "Poppins", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        background: radial-gradient(circle at top left, #1f2937, #020617);
        color: #f9fafb;
    }

    .leaderboard-section {
        max-width: 1200px;
        margin: 32px auto 40px;
        padding: 0 24px 40px;
    }

    .hero-heading {
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .hero-subtitle {
        font-size: 14px;
        color: #9ca3af;
        max-width: 520px;
        line-height: 1.5;
        margin-bottom: 24px;
    }

    /* Filter Tabs */
    .leaderboard-tabs {
        display: flex;
        gap: 12px;
        margin-bottom: 32px;
        flex-wrap: wrap;
        border-bottom: 2px solid #1f2937;
        padding-bottom: 16px;
    }

    .tab-button {
        padding: 12px 24px;
        background: transparent;
        border: 2px solid #1f2937;
        color: #9ca3af;
        border-radius: 12px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .tab-button:hover {
        border-color: #3b82f6;
        color: #3b82f6;
    }

    .tab-button.active {
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        border-color: transparent;
        color: white;
    }

    /* Leaderboard Table */
    .leaderboard-container {
        background: radial-gradient(circle at top left, #111827, #020617);
        border: 1px solid #1f2937;
        border-radius: 22px;
        box-shadow: 0 20px 60px rgba(15, 23, 42, 0.95);
        overflow: hidden;
    }

    .leaderboard-header {
        padding: 24px;
        border-bottom: 1px solid #1f2937;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .leaderboard-title {
        font-size: 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .leaderboard-table {
        width: 100%;
        border-collapse: collapse;
    }

    .leaderboard-table thead {
        background: rgba(59, 130, 246, 0.1);
    }

    .leaderboard-table th {
        padding: 16px 24px;
        text-align: left;
        font-size: 13px;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .leaderboard-table td {
        padding: 20px 24px;
        border-bottom: 1px solid #1f2937;
    }

    .leaderboard-table tbody tr {
        transition: background 0.2s ease;
    }

    .leaderboard-table tbody tr:hover {
        background: rgba(59, 130, 246, 0.05);
    }

    .leaderboard-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Rank Badge */
    .rank-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 16px;
    }

    .rank-badge.gold {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: #000;
    }

    .rank-badge.silver {
        background: linear-gradient(135deg, #94a3b8, #64748b);
        color: #fff;
    }

    .rank-badge.bronze {
        background: linear-gradient(135deg, #fb923c, #ea580c);
        color: #fff;
    }

    .rank-badge.regular {
        background: rgba(59, 130, 246, 0.2);
        color: #3b82f6;
    }

    /* User Info */
    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: white;
        font-size: 16px;
    }

    .user-name {
        font-weight: 500;
        color: #fff;
    }

    .user-email {
        font-size: 12px;
        color: #9ca3af;
    }

    /* Value Display */
    .value-display {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        font-size: 18px;
    }

    .value-icon {
        font-size: 20px;
    }

    /* User Stats Card */
    .user-stats-card {
        background: radial-gradient(circle at top left, rgba(59, 130, 246, 0.1), #020617);
        border: 1px solid #3b82f6;
        border-radius: 18px;
        padding: 20px;
        margin-bottom: 32px;
    }

    .user-stats-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .user-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }

    .user-stat-item {
        padding: 12px;
        background: rgba(59, 130, 246, 0.1);
        border-radius: 12px;
    }

    .user-stat-label {
        font-size: 12px;
        color: #9ca3af;
        margin-bottom: 4px;
    }

    .user-stat-value {
        font-size: 20px;
        font-weight: 600;
        color: #fff;
    }

    .user-stat-rank {
        font-size: 14px;
        color: #3b82f6;
        margin-top: 4px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #9ca3af;
    }

    @media (max-width: 768px) {
        .leaderboard-tabs {
            overflow-x: auto;
            flex-wrap: nowrap;
        }

        .leaderboard-table {
            font-size: 14px;
        }

        .leaderboard-table th,
        .leaderboard-table td {
            padding: 12px 16px;
        }

        .user-stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

<main class="leaderboard-section">
    <h1 class="hero-heading">🏆 Leaderboard</h1>
    <p class="hero-subtitle">See the top performers and compete with other learners</p>

    <!-- User Stats (if authenticated) -->
    @auth
        @if($userStats)
        <div class="user-stats-card">
            <div class="user-stats-title">
                <span>📊</span>
                <span>Your Stats</span>
            </div>
            <div class="user-stats-grid">
                <div class="user-stat-item">
                    <div class="user-stat-label">Completed Tracks</div>
                    <div class="user-stat-value">{{ $userStats['tracks']['value'] }}</div>
                    @if($userStats['tracks']['rank'])
                        <div class="user-stat-rank">Rank #{{ $userStats['tracks']['rank'] }}</div>
                    @endif
                </div>
                <div class="user-stat-item">
                    <div class="user-stat-label">Certificates</div>
                    <div class="user-stat-value">{{ $userStats['certificates']['value'] }}</div>
                    @if($userStats['certificates']['rank'])
                        <div class="user-stat-rank">Rank #{{ $userStats['certificates']['rank'] }}</div>
                    @endif
                </div>
                <div class="user-stat-item">
                    <div class="user-stat-label">Achievement Points</div>
                    <div class="user-stat-value">{{ number_format($userStats['points']['value']) }}</div>
                    @if($userStats['points']['rank'])
                        <div class="user-stat-rank">Rank #{{ $userStats['points']['rank'] }}</div>
                    @endif
                </div>
                <div class="user-stat-item">
                    <div class="user-stat-label">Quiz Average</div>
                    <div class="user-stat-value">{{ number_format($userStats['quiz_average']['value'], 1) }}%</div>
                    @if($userStats['quiz_average']['rank'])
                        <div class="user-stat-rank">Rank #{{ $userStats['quiz_average']['rank'] }}</div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    @endauth

    <!-- Filter Tabs -->
    <div class="leaderboard-tabs">
        @foreach($types as $typeKey => $typeInfo)
            <a href="?type={{ $typeKey }}" class="tab-button {{ $type === $typeKey ? 'active' : '' }}">
                <span>{{ $typeInfo['icon'] }}</span>
                <span>{{ $typeInfo['name'] }}</span>
            </a>
        @endforeach
    </div>

    <!-- Leaderboard Table -->
    <div class="leaderboard-container">
        <div class="leaderboard-header">
            <div class="leaderboard-title">
                <span>{{ $types[$type]['icon'] ?? '📊' }}</span>
                <span>{{ $types[$type]['name'] ?? 'Leaderboard' }}</span>
            </div>
            <div style="font-size: 12px; color: #9ca3af;">
                Updated every hour
            </div>
        </div>

        @if(!empty($leaderboard))
            <table class="leaderboard-table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>User</th>
                        <th style="text-align: right;">{{ $types[$type]['name'] ?? 'Value' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaderboard as $entry)
                        @php
                            $isCurrentUser = auth()->check() && auth()->id() === $entry['user_id'];
                            $rankClass = match(true) {
                                $entry['rank'] === 1 => 'gold',
                                $entry['rank'] === 2 => 'silver',
                                $entry['rank'] === 3 => 'bronze',
                                default => 'regular',
                            };
                            $initials = strtoupper(substr($entry['name'], 0, 2));
                        @endphp
                        <tr style="{{ $isCurrentUser ? 'background: rgba(59, 130, 246, 0.15);' : '' }}">
                            <td>
                                <div class="rank-badge {{ $rankClass }}">
                                    @if($entry['rank'] <= 3)
                                        {{ $entry['rank'] }}
                                    @else
                                        #{{ $entry['rank'] }}
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">{{ $initials }}</div>
                                    <div>
                                        <div class="user-name">
                                            {{ $entry['name'] }}
                                            @if($isCurrentUser)
                                                <span style="color: #3b82f6; margin-left: 8px;">(You)</span>
                                            @endif
                                        </div>
                                        <div class="user-email">{{ $entry['email'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <div class="value-display">
                                    <span class="value-icon">{{ $entry['icon'] ?? '⭐' }}</span>
                                    <span>
                                        @if(isset($entry['quizzes_taken']))
                                            {{ number_format($entry['value'], 1) }}%
                                            <small style="font-size: 12px; color: #9ca3af; font-weight: normal;">
                                                ({{ $entry['quizzes_taken'] }} quizzes)
                                            </small>
                                        @else
                                            {{ number_format($entry['value']) }}
                                        @endif
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <p style="font-size: 18px; margin-bottom: 12px;">No data available</p>
                <p style="font-size: 14px;">The leaderboard will be populated as users complete activities</p>
            </div>
        @endif
    </div>
</main>

@push('scripts')
<script src="{{ asset('js/script.js') }}"></script>
@endpush

@endsection

