@extends('layouts.app')

@section('title', 'Achievements & Badges — ITLAB')
@section('body-class', 'page-achievements')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    body.page-achievements {
        margin: 0;
        min-height: 100vh;
        font-family: "Poppins", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        background: radial-gradient(circle at top left, #1f2937, #020617);
        color: #f9fafb;
    }

    .achievements-section {
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

    /* Stats Summary */
    .stats-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }

    .stat-card {
        padding: 20px;
        border-radius: 18px;
        background: radial-gradient(circle at top left, #111827, #020617);
        border: 1px solid #111827;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.7);
    }

    .stat-label {
        font-size: 13px;
        color: #9ca3af;
        display: block;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 600;
        color: #fff;
    }

    .stat-value small {
        font-size: 14px;
        color: #9ca3af;
        font-weight: normal;
    }

    /* Progress Bar */
    .progress-container {
        margin-top: 8px;
        background: #1f2937;
        border-radius: 8px;
        height: 8px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        border-radius: 8px;
        transition: width 0.3s ease;
    }

    /* Achievements Grid */
    .achievements-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 32px;
    }

    .achievement-card {
        position: relative;
        padding: 24px;
        border-radius: 22px;
        background: radial-gradient(circle at top left, rgba(34, 197, 94, 0.08), #020617);
        border: 1px solid #1f2937;
        box-shadow: 0 20px 60px rgba(15, 23, 42, 0.95);
        transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        overflow: hidden;
    }

    .achievement-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, rgba(56, 189, 248, 0.22), transparent 45%);
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.25s ease;
    }

    .achievement-card:hover {
        transform: translateY(-4px);
        border-color: #22c55e66;
        box-shadow: 0 26px 70px rgba(15, 23, 42, 1);
    }

    .achievement-card:hover::before {
        opacity: 1;
    }

    .achievement-card.unlocked {
        border-color: #22c55e;
        background: radial-gradient(circle at top left, rgba(34, 197, 94, 0.15), #020617);
    }

    .achievement-card.locked {
        opacity: 0.6;
        filter: grayscale(0.5);
    }

    .achievement-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 16px;
    }

    .achievement-icon {
        font-size: 48px;
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        background: rgba(59, 130, 246, 0.1);
        flex-shrink: 0;
    }

    .achievement-card.unlocked .achievement-icon {
        background: rgba(34, 197, 94, 0.2);
    }

    .achievement-info {
        flex: 1;
    }

    .achievement-name {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 4px;
        color: #fff;
    }

    .achievement-card.locked .achievement-name {
        color: #6b7280;
    }

    .achievement-description {
        font-size: 13px;
        color: #9ca3af;
        line-height: 1.5;
    }

    .achievement-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #1f2937;
    }

    .achievement-points {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 500;
        color: #fbbf24;
    }

    .achievement-status {
        font-size: 12px;
        padding: 4px 12px;
        border-radius: 12px;
        font-weight: 500;
    }

    .achievement-status.unlocked {
        background: rgba(34, 197, 94, 0.2);
        color: #22c55e;
    }

    .achievement-status.locked {
        background: rgba(107, 114, 128, 0.2);
        color: #9ca3af;
    }

    .section-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 16px;
        color: #fff;
    }

    @media (max-width: 768px) {
        .achievements-grid {
            grid-template-columns: 1fr;
        }

        .stats-summary {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

<main class="achievements-section">
    <h1 class="hero-heading">🏆 Achievements & Badges</h1>
    <p class="hero-subtitle">Track your achievements and badges earned during your learning journey</p>

    <!-- Stats Summary -->
    <div class="stats-summary">
        <div class="stat-card">
            <span class="stat-label">Total Points</span>
            <div class="stat-value">{{ number_format($progress['total_points'] ?? 0) }}</div>
        </div>
        <div class="stat-card">
            <span class="stat-label">Achievements Unlocked</span>
            <div class="stat-value">
                {{ $data['stats']['unlocked'] ?? 0 }} 
                <small>/ {{ $data['stats']['total'] ?? 0 }}</small>
            </div>
            <div class="progress-container">
                <div class="progress-bar" style="width: {{ $data['stats']['percentage'] ?? 0 }}%"></div>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-label">Completion Rate</span>
            <div class="stat-value">{{ number_format($data['stats']['percentage'] ?? 0, 1) }}%</div>
        </div>
    </div>

    <!-- All Achievements -->
    <h2 class="section-title">All Achievements</h2>
    <div class="achievements-grid">
        @foreach($data['all'] as $achievement)
            @php
                $isUnlocked = in_array($achievement->id, $data['unlocked'] ?? []);
                $unlockedInfo = null;
                if ($isUnlocked) {
                    $unlockedInfo = \App\Models\UserAchievement::where('user_id', auth()->id())
                        ->where('achievement_id', $achievement->id)
                        ->first();
                }
            @endphp
            <div class="achievement-card {{ $isUnlocked ? 'unlocked' : 'locked' }}">
                <div class="achievement-header">
                    <div class="achievement-icon" style="background-color: {{ $achievement->badge_color }}20;">
                        {{ $achievement->icon ?? '🏆' }}
                    </div>
                    <div class="achievement-info">
                        <h3 class="achievement-name">{{ $achievement->display_name }}</h3>
                        <p class="achievement-description">{{ $achievement->display_description }}</p>
                    </div>
                </div>
                <div class="achievement-footer">
                    <div class="achievement-points">
                        <span>⭐</span>
                        <span>{{ $achievement->points }} points</span>
                    </div>
                    <span class="achievement-status {{ $isUnlocked ? 'unlocked' : 'locked' }}">
                        {{ $isUnlocked ? '✓ Unlocked' : '🔒 Locked' }}
                    </span>
                </div>
                @if($isUnlocked && $unlockedInfo)
                    <div style="margin-top: 12px; font-size: 12px; color: #9ca3af;">
                        Unlocked on: {{ $unlockedInfo->unlocked_at->format('M d, Y') }}
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    @if(empty($data['all']))
        <div style="text-align: center; padding: 60px 20px; color: #9ca3af;">
            <p style="font-size: 18px; margin-bottom: 12px;">No achievements available at the moment</p>
            <p style="font-size: 14px;">Achievements will appear here when available</p>
        </div>
    @endif
</main>

@push('scripts')
<script src="{{ asset('js/script.js') }}"></script>
@endpush

@endsection

