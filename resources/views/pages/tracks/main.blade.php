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
      currentPage="main"
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

<!-- HERO CONTENT -->
<section class="hero">
    <div class="hero-left">
        <h1 class="hero-heading">{{ $track->title }}</h1>
        <p class="hero-subtitle">
            {{ $track->description }}
        </p>

        @if($track->hero_content)
            <div class="hero-content" style="margin: 20px 0;">
                {!! $track->hero_content !!}
            </div>
        @endif

        <div class="hero-buttons">
            @if($track->show_track ?? true)
                <button class="btn-main" onclick="location.href='{{ route('tracks.show', $track) }}'">
                    Learn {{ $track->title }}
                </button>
            @endif

            @if($track->show_videos ?? true)
                <button class="btn-secondary" onclick="location.href='{{ $track->getVideosRoute() }}'">
                    Video Tutorial
                </button>
            @endif

            @if($track->show_reference ?? true)
                <button class="btn-tertiary" onclick="location.href='{{ $track->getReferenceRoute() }}'">
                    {{ $track->title }} Reference
                </button>
            @endif

            @if($track->show_quiz ?? true)
                <button class="btn-tertiary" style="background-color:#ffc0c7;" onclick="location.href='{{ $track->getQuizRoute() }}'">
                    Get Certified
                </button>
            @endif

            @if($track->show_labs ?? true)
                <button class="btn-tertiary" onclick="location.href='{{ $track->getLabsRoute() }}'">
                    Labs
                </button>
            @endif
        </div>

        @if($track->hero_button_text && $track->hero_button_link)
            <div style="margin-top: 15px;">
                <a href="{{ $track->hero_button_link }}" class="btn-main">
                    {{ $track->hero_button_text }}
                </a>
            </div>
        @endif
    </div>

    <div class="hero-right">
        <div class="example-card">
            <div class="example-title">{{ $track->title }} Example:</div>
            <div class="example-inner">
                @if($track->example_code)
                    <pre><code>{{ $track->example_code }}</code></pre>
                @else
                    <p>Example code will be added soon.</p>
                @endif
            </div>
            <div class="example-footer">
                <button class="btn-main" onclick="location.href='{{ route('pages.try-it') }}?type={{ $track->slug }}'">
                    Try it Yourself
                </button>
            </div>
        </div>
    </div>
</section>
    </main>
</div>

@push('scripts')
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/sidebar.js') }}"></script>
@endpush
@endsection

