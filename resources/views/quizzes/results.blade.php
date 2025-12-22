@extends('layouts.app')

@section('title', 'Quiz Results — ' . $quiz->title . ' — ITLAB')
@section('body-class', 'page-quiz-results')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
@endpush

<div class="page-wrapper">
    <!-- Sidebar -->
    <x-sidebar 
      :currentTrack="$track" 
      currentPage="quiz"
    />

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-header">
            <div>
                <a href="{{ route('tracks.quizzes.show', [$track, $quiz]) }}" class="back-link" style="margin-bottom: 12px; display: inline-block;">
                    <i class="fa-solid fa-arrow-left-long"></i>
                    Back to Quiz
                </a>
                <h1>Quiz Results: {{ $quiz->title }}</h1>
            </div>
        </div>

        <div style="background: var(--card-bg, #fff); border: 1px solid var(--border, #e5e7eb); border-radius: 8px; padding: 32px; margin-bottom: 32px;">
            @if($userResult)
                <div style="text-align: center; margin-bottom: 32px;">
                    <div style="font-size: 48px; font-weight: bold; color: var(--accent, #04aa6d); margin-bottom: 8px;">
                        {{ $userResult->score }}%
                    </div>
                    <div style="font-size: 18px; color: var(--text); margin-bottom: 16px;">
                        Your Best Score
                    </div>
                    <div style="font-size: 14px; color: var(--muted);">
                        Submitted on: {{ $userResult->created_at->format('M d, Y') }}
                    </div>
                </div>

                @if($userResult->score >= 80)
                    <div style="background: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px; padding: 16px; margin-bottom: 24px; text-align: center;">
                        <i class="fa-solid fa-check-circle" style="color: #155724; font-size: 24px; margin-bottom: 8px;"></i>
                        <div style="color: #155724; font-weight: 600;">Excellent! You passed the quiz!</div>
                    </div>
                @elseif($userResult->score >= 60)
                    <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 16px; margin-bottom: 24px; text-align: center;">
                        <i class="fa-solid fa-exclamation-circle" style="color: #856404; font-size: 24px; margin-bottom: 8px;"></i>
                        <div style="color: #856404; font-weight: 600;">Good effort! Try again to improve your score.</div>
                    </div>
                @else
                    <div style="background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; padding: 16px; margin-bottom: 24px; text-align: center;">
                        <i class="fa-solid fa-times-circle" style="color: #721c24; font-size: 24px; margin-bottom: 8px;"></i>
                        <div style="color: #721c24; font-weight: 600;">Keep practicing! Review the material and try again.</div>
                    </div>
                @endif
            @else
                <div style="text-align: center; padding: 40px;">
                    <i class="fa-solid fa-inbox" style="font-size: 48px; color: var(--muted); margin-bottom: 16px;"></i>
                    <h3 style="font-size: 20px; color: var(--text); margin-bottom: 8px;">No Results Yet</h3>
                    <p style="color: var(--muted); margin-bottom: 24px;">You haven't taken this quiz yet.</p>
                    <a href="{{ route('tracks.quizzes.show', [$track, $quiz]) }}" style="display: inline-block; padding: 12px 24px; background: var(--accent, #04aa6d); color: #000; text-decoration: none; border-radius: 8px; font-weight: 600;">
                        Take Quiz Now
                    </a>
                </div>
            @endif

            @if($statistics)
                <div style="border-top: 1px solid var(--border, #e5e7eb); padding-top: 24px; margin-top: 24px;">
                    <h3 style="font-size: 20px; margin-bottom: 16px; color: var(--text);">Quiz Statistics</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                        <div style="background: var(--bg, #f5f5f5); padding: 16px; border-radius: 8px;">
                            <div style="font-size: 14px; color: var(--muted); margin-bottom: 4px;">Total Attempts</div>
                            <div style="font-size: 24px; font-weight: bold; color: var(--text);">{{ $statistics['total_attempts'] ?? 0 }}</div>
                        </div>
                        <div style="background: var(--bg, #f5f5f5); padding: 16px; border-radius: 8px;">
                            <div style="font-size: 14px; color: var(--muted); margin-bottom: 4px;">Average Score</div>
                            <div style="font-size: 24px; font-weight: bold; color: var(--text);">{{ number_format($statistics['average_score'] ?? 0, 1) }}%</div>
                        </div>
                        <div style="background: var(--bg, #f5f5f5); padding: 16px; border-radius: 8px;">
                            <div style="font-size: 14px; color: var(--muted); margin-bottom: 4px;">Highest Score</div>
                            <div style="font-size: 24px; font-weight: bold; color: var(--text);">{{ $statistics['highest_score'] ?? 0 }}%</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div style="display: flex; gap: 16px; justify-content: center;">
            <a href="{{ route('tracks.quizzes.show', [$track, $quiz]) }}" 
               style="display: inline-block; padding: 12px 24px; background: var(--accent, #04aa6d); color: #000; text-decoration: none; border-radius: 8px; font-weight: 600;">
                <i class="fa-solid fa-redo"></i> Retake Quiz
            </a>
            <a href="{{ route('tracks.show', $track) }}" 
               style="display: inline-block; padding: 12px 24px; background: var(--card-bg, #fff); border: 1px solid var(--border, #e5e7eb); color: var(--text); text-decoration: none; border-radius: 8px; font-weight: 600;">
                <i class="fa-solid fa-book"></i> Back to Track
            </a>
        </div>
</div>

@push('scripts')
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/sidebar.js') }}"></script>
@endpush
@endsection

