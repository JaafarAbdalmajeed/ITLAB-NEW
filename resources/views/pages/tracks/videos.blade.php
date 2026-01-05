@extends('layouts.app')

@section('title', $track->title . ' Videos — ITLAB')
@section('body-class', 'page-videos')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
@endpush

<div class="page-wrapper">
    <!-- Sidebar -->
    <x-sidebar 
      :currentTrack="$track" 
      currentPage="videos"
    />

    <main class="main-content" style="background: #0f0f0f; min-height: 100vh; padding: 30px;">
        <div class="content-header mb-5">
            <h1 style="color: #00ffaa; font-size: 2.2rem; font-weight: bold;">
                <i class="fa-solid fa-play-circle me-2"></i> {{ $track->title }} Videos
            </h1>
            <a href="{{ $track->getMainRoute() }}" class="back-link">
                <i class="fa-solid fa-arrow-left me-2"></i> Back to Track
            </a>
        </div>

        <div class="row g-4">
            @php
                // Get videos from database
                $query = $track->videos();
                // Check if 'order' column exists before using it
                if (\Illuminate\Support\Facades\Schema::hasColumn('videos', 'order')) {
                    $trackVideos = $query->orderBy('order')->get();
                } else {
                    $trackVideos = $query->latest()->get();
                }
            @endphp

            @forelse($trackVideos as $index => $video)
            <div class="col-12 mb-4">
                <div class="video-container-card shadow-lg" style="border-left: 12px solid {{ $video->color ?? '#00ffaa' }}; background: #1a1a1a; border-radius: 20px; overflow: hidden; border: 1px solid #333;">
                    <div class="row g-0">
                        <div class="col-lg-7">
                            <div class="ratio ratio-16x9">
                                <iframe src="{{ $video->embed_url }}" 
                                        title="{{ $video->title }}" 
                                        frameborder="0" 
                                        allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                        <div class="col-lg-5 p-4 d-flex flex-column justify-content-center">
                            <h3 style="color: {{ $video->color ?? '#00ffaa' }}; font-weight: bold; margin-bottom: 15px;">{{ $video->title }}</h3>
                            <p style="color: #bbb; line-height: 1.6;">
                                {{ $video->description ?? 'Watch this lesson to learn how to apply the practical skills of this track step by step with the instructor.' }}
                            </p>
                            
                            <div class="mt-4 d-flex align-items-center gap-2">
                                <span class="badge" style="background: {{ $video->color ?? '#00ffaa' }}; color: #000; padding: 8px 15px;">Video #{{ $index + 1 }}</span>
                                <a href="{{ $video->watch_url }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fab fa-youtube text-danger me-1"></i> YouTube
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info" style="background: #1a1a1a; color: #00ffaa; padding: 20px; border-radius: 10px; border: 1px solid #333; text-align: center;">
                    <i class="fa-solid fa-video me-2"></i> No videos available for this track yet.
                </div>
            </div>
            @endforelse
        </div>
    </main>
</div>

<style>
    .video-container-card { transition: 0.3s ease; }
    .video-container-card:hover { transform: scale(1.005); border-color: rgba(255,255,255,0.2) !important; }
    .back-link { color: #888; text-decoration: none; font-size: 0.9rem; }
    .back-link:hover { color: #fff; }
</style>

@push('scripts')
<script src="{{ asset('js/sidebar.js') }}"></script>
@endpush
@endsection