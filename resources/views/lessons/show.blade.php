@extends('layouts.app')

@section('title', $lesson->title . ' — ' . $track->title . ' — ITLAB')
@section('body-class', 'page-' . $track->slug . '-lesson')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
@endpush

<div class="page-wrapper">
    <!-- Sidebar -->
    <x-sidebar 
      :currentTrack="$track" 
      currentPage="tutorial"
    />

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-header">
            <div>
                <a href="{{ route('tracks.show', $track) }}" class="back-link" style="margin-bottom: 12px; display: inline-block;">
                    <i class="fa-solid fa-arrow-left-long"></i>
                    Back to {{ $track->title }}
                </a>
                <h1 id="lesson-{{ $lesson->id }}">{{ $lesson->title }}</h1>
            </div>
        </div>

        <div style="background: var(--card-bg, #fff); border: 1px solid var(--border, #e5e7eb); border-radius: 8px; padding: 32px; margin-bottom: 32px;">
            <div style="font-size: 16px; line-height: 1.8; color: var(--text);">
                {!! $lesson->content !!}
            </div>
        </div>

        <!-- Navigation between lessons -->
        @php
            $allLessons = $track->lessons()->orderBy('order')->get();
            $currentIndex = $allLessons->search(function($l) use ($lesson) {
                return $l->id === $lesson->id;
            });
            $prevLesson = $currentIndex > 0 ? $allLessons[$currentIndex - 1] : null;
            $nextLesson = $currentIndex < $allLessons->count() - 1 ? $allLessons[$currentIndex + 1] : null;
        @endphp

        <div style="display: flex; justify-content: space-between; gap: 16px; padding-top: 24px; border-top: 1px solid var(--border, #e5e7eb);">
            @if($prevLesson)
                <a href="{{ route('tracks.lessons.show', [$track, $prevLesson]) }}" 
                   style="display: flex; align-items: center; gap: 8px; padding: 12px 20px; background: var(--card-bg, #fff); border: 1px solid var(--border, #e5e7eb); border-radius: 8px; text-decoration: none; color: var(--text); transition: all 0.2s;">
                    <i class="fa-solid fa-arrow-left"></i>
                    <div>
                        <div style="font-size: 12px; color: var(--muted);">Previous</div>
                        <div style="font-weight: 500;">{{ $prevLesson->title }}</div>
                    </div>
                </a>
            @else
                <div></div>
            @endif

            @if($nextLesson)
                <a href="{{ route('tracks.lessons.show', [$track, $nextLesson]) }}" 
                   style="display: flex; align-items: center; gap: 8px; padding: 12px 20px; background: var(--card-bg, #fff); border: 1px solid var(--border, #e5e7eb); border-radius: 8px; text-decoration: none; color: var(--text); transition: all 0.2s; margin-left: auto;">
                    <div style="text-align: right;">
                        <div style="font-size: 12px; color: var(--muted);">Next</div>
                        <div style="font-weight: 500;">{{ $nextLesson->title }}</div>
                    </div>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            @endif
        </div>
    </main>
</div>

@push('scripts')
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/sidebar.js') }}"></script>
@endpush
@endsection
