@extends('layouts.app')

@section('title', $track->title . ' — ITLAB')
@section('body-class', 'page-' . $track->slug)

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
@endpush

<div class="page-wrapper">
    <!-- Sidebar -->
    <x-sidebar 
      :currentTrack="$track" 
      currentPage="track"
    />

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-header">
            <h1>{{ $track->title }}</h1>
            <a href="{{ route('home') }}" class="back-link">
                <i class="fa-solid fa-arrow-left-long"></i>
                Back to Home
            </a>
        </div>

        <div style="margin-bottom: 32px;">
            <p style="font-size: 18px; color: var(--muted);">{{ $track->description }}</p>
        </div>

        @if($track->lessons->count() > 0)
        <div style="margin-bottom: 40px;">
            <h2 style="font-size: 28px; margin-bottom: 20px; color: var(--text);">Lessons</h2>
            <div style="display: grid; gap: 12px;">
                @foreach($track->lessons as $lesson)
                    <a href="{{ route('tracks.lessons.show', [$track, $lesson]) }}" 
                       style="display: block; padding: 16px; background: var(--card-bg, #fff); border: 1px solid var(--border, #e5e7eb); border-radius: 8px; text-decoration: none; color: var(--text); transition: all 0.2s;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <span style="background: var(--accent, #04aa6d); color: #000; padding: 4px 10px; border-radius: 4px; font-weight: 600; font-size: 14px;">{{ $lesson->order }}</span>
                            <span style="font-size: 16px; font-weight: 500;">{{ $lesson->title }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        @if($track->quizzes->count() > 0)
        <div style="margin-bottom: 40px;">
            <h2 style="font-size: 28px; margin-bottom: 20px; color: var(--text);">Quizzes</h2>
            <div style="display: grid; gap: 12px;">
                @foreach($track->quizzes as $quiz)
                    <a href="{{ route('tracks.quizzes.show', [$track, $quiz]) }}" 
                       style="display: block; padding: 16px; background: var(--card-bg, #fff); border: 1px solid var(--border, #e5e7eb); border-radius: 8px; text-decoration: none; color: var(--text); transition: all 0.2s;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <i class="fa-solid fa-question-circle" style="color: var(--accent, #04aa6d); font-size: 20px;"></i>
                            <span style="font-size: 16px; font-weight: 500;">{{ $quiz->title }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        @if($track->labs->count() > 0)
        <div style="margin-bottom: 40px;">
            <h2 style="font-size: 28px; margin-bottom: 20px; color: var(--text);">Labs</h2>
            <div style="display: grid; gap: 12px;">
                @foreach($track->labs as $lab)
                    <a href="{{ route('tracks.labs.show', [$track, $lab]) }}" 
                       style="display: block; padding: 16px; background: var(--card-bg, #fff); border: 1px solid var(--border, #e5e7eb); border-radius: 8px; text-decoration: none; color: var(--text); transition: all 0.2s;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <i class="fa-solid fa-flask" style="color: var(--accent, #04aa6d); font-size: 20px;"></i>
                            <div>
                                <span style="font-size: 16px; font-weight: 500;">{{ $lab->title }}</span>
                                @if($lab->scenario)
                                    <p style="font-size: 14px; color: var(--muted); margin: 4px 0 0 0;">{{ Str::limit($lab->scenario, 100) }}</p>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        @if($track->lessons->count() === 0 && $track->quizzes->count() === 0 && $track->labs->count() === 0)
        <div style="text-align: center; padding: 60px 20px; background: var(--card-bg, #fff); border: 1px solid var(--border, #e5e7eb); border-radius: 8px;">
            <i class="fa-solid fa-inbox" style="font-size: 48px; color: var(--muted); margin-bottom: 16px;"></i>
            <h3 style="font-size: 20px; color: var(--text); margin-bottom: 8px;">No content yet</h3>
            <p style="color: var(--muted);">This track doesn't have any lessons, quizzes, or labs yet.</p>
        </div>
        @endif
    </main>
</div>

@push('scripts')
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/sidebar.js') }}"></script>
@endpush
@endsection
