@extends('layouts.app')

@section('title', $track->title . ' — ITLAB')
@section('body-class', 'page-' . $track->slug)

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
<style>
    /* Ensure white text on dark backgrounds only */
    body.page-cyber-network,
    body.page-cyber-web,
    body.page-cyber,
    body.page-js,
    body.page-home {
        color: #ffffff !important;
    }

    body.page-cyber-network .hero-heading,
    body.page-cyber-web .hero-heading,
    body.page-cyber .hero-heading,
    body.page-js .hero-heading,
    body.page-home .hero-heading {
        color: #ffffff !important;
    }

    body.page-cyber-network .hero-subtitle,
    body.page-cyber-web .hero-subtitle,
    body.page-cyber .hero-subtitle,
    body.page-js .hero-subtitle,
    body.page-home .hero-subtitle {
        color: #d9d9e3 !important;
    }

    body.page-cyber-network .hero-content,
    body.page-cyber-web .hero-content,
    body.page-cyber .hero-content,
    body.page-js .hero-content,
    body.page-home .hero-content {
        color: #e5e7eb !important;
    }

    body.page-cyber-network .content-header h1,
    body.page-cyber-web .content-header h1,
    body.page-cyber .content-header h1,
    body.page-js .content-header h1,
    body.page-home .content-header h1 {
        color: #ffffff !important;
    }

    body.page-cyber-network .back-link,
    body.page-cyber-web .back-link,
    body.page-cyber .back-link,
    body.page-js .back-link,
    body.page-home .back-link {
        color: #d9d9e3 !important;
    }

    body.page-cyber-network .back-link:hover,
    body.page-cyber-web .back-link:hover,
    body.page-cyber .back-link:hover,
    body.page-js .back-link:hover,
    body.page-home .back-link:hover {
        color: #ffffff !important;
    }

    /* Ensure dark text on light backgrounds */
    body.page-html,
    body.page-css {
        color: #000000 !important;
    }

    body.page-html .hero-heading,
    body.page-css .hero-heading,
    body.page-html h1,
    body.page-css h1 {
        color: #000000 !important;
    }

    body.page-html .hero-subtitle,
    body.page-css .hero-subtitle {
        color: #333333 !important;
    }

    body.page-html .hero-content,
    body.page-css .hero-content,
    body.page-html p,
    body.page-css p {
        color: #333333 !important;
    }

    body.page-html .content-header h1,
    body.page-css .content-header h1 {
        color: #000000 !important;
    }

    body.page-html .back-link,
    body.page-css .back-link {
        color: #333333 !important;
    }

    body.page-html .back-link:hover,
    body.page-css .back-link:hover {
        color: #000000 !important;
    }
</style>
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
                <button class="btn-main" onclick="location.href='{{ $track->getTrackRoute() }}'">
                    <i class="fa-solid fa-book"></i> View Lessons
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

            @auth
                @php
                    $isCompleted = $track->isCompletedByUser(auth()->id());
                    $certificate = $track->getUserCertificate(auth()->id());
                    $userProgress = $track->getUserProgress(auth()->id());
                    $progressPercent = $userProgress ? $userProgress->progress_percent : 0;
                @endphp
                
                @if(!$isCompleted)
                    <form action="{{ route('tracks.complete', $track) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to mark this track as completed? A certificate will be issued automatically.');">
                        @csrf
                        <button type="submit" class="btn-main" style="background-color:#17a2b8; border:none; cursor:pointer;">
                            <i class="fas fa-check-circle"></i> Complete Track
                        </button>
                    </form>
                    @if($progressPercent > 0)
                        <div style="margin-top: 10px; font-size: 14px; color: #666;">
                            Progress: {{ $progressPercent }}%
                        </div>
                    @endif
                @elseif($certificate)
                    <a href="{{ route('tracks.certificate.show', $track) }}" class="btn-main" style="background-color:#28a745; text-decoration:none; display:inline-block; padding:12px 24px; border-radius:6px; color:white; font-weight:600;">
                        <i class="fas fa-certificate"></i> View Certificate
                    </a>
                @endif
            @endauth
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

@php
    $recommendationService = app(\App\Services\RecommendationService::class);
    $youMightAlsoLike = $recommendationService->getYouMightAlsoLike(auth()->user(), $track, 4);
@endphp

@if(count($youMightAlsoLike) > 0)
<!-- You Might Also Like Section -->
<section style="margin-top: 60px; padding: 40px 0; border-top: 1px solid rgba(255,255,255,0.1);">
    <div class="content-header" style="margin-bottom: 30px;">
        <h2 style="font-size: 24px; font-weight: 600; margin-bottom: 8px;">You Might Also Like</h2>
        <p style="font-size: 14px; color: #9ca3af; max-width: 600px;">
            Based on your learning progress and interests, here are some tracks you might enjoy
        </p>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        @foreach($youMightAlsoLike as $recommendedTrack)
        @php
            $mainRoute = match($recommendedTrack->slug ?? '') {
                'html' => route('pages.html'),
                'css' => route('pages.css'),
                'js' => route('pages.js'),
                'cyber-network' => route('pages.cyber-network'),
                'cyber-web' => route('pages.cyber-web'),
                default => route('tracks.show', $recommendedTrack),
            };
        @endphp
        <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 20px; transition: all 0.3s ease; cursor: pointer;" 
             onclick="location.href='{{ $mainRoute }}'"
             onmouseover="this.style.transform='translateY(-5px)'; this.style.borderColor='rgba(34,197,94,0.5)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='rgba(255,255,255,0.1)';">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                <span style="font-size: 20px;">✨</span>
                <h3 style="font-size: 18px; font-weight: 600; margin: 0;">{{ $recommendedTrack->title ?? 'Track' }}</h3>
            </div>
            <p style="font-size: 14px; color: #9ca3af; margin-bottom: 15px; line-height: 1.5;">
                {{ $recommendedTrack->description ?? 'Learn ' . ($recommendedTrack->title ?? 'this track') }}
            </p>
            <div style="display: flex; align-items: center; gap: 15px; font-size: 12px; color: #9ca3af;">
                <span><i class="fas fa-users"></i> {{ $recommendedTrack->user_progress_count ?? 0 }} learners</span>
                @if($recommendedTrack->lessons && $recommendedTrack->lessons->count() > 0)
                <span><i class="fas fa-book"></i> {{ $recommendedTrack->lessons->count() }} lessons</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

    </main>
</div>

@push('scripts')
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/sidebar.js') }}"></script>
@endpush
@endsection

