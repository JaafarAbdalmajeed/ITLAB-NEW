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

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-header">
            <h1>{{ $track->title }} Videos</h1>
            <a href="{{ $track->getMainRoute() }}" class="back-link">
                <i class="fa-solid fa-arrow-left-long"></i>
                Back to {{ $track->title }}
            </a>
        </div>

        <div class="videos-content" style="background: var(--card); padding: 30px; border-radius: 8px; border: 1px solid var(--border);">
        @if($track->videos && count($track->videos) > 0)
            <div class="videos-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                @foreach($track->videos as $index => $video)
                    <div class="video-card" style="border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; transition: transform 0.2s;">
                        <div style="position: relative; padding-bottom: 56.25%; background: #000;">
                            @php
                                // Extract YouTube video ID
                                $videoId = null;
                                if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $video['url'], $matches)) {
                                    $videoId = $matches[1];
                                }
                            @endphp
                            @if($videoId)
                                <iframe 
                                    src="https://www.youtube.com/embed/{{ $videoId }}" 
                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            @else
                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #fff;">
                                    <i class="fas fa-video" style="font-size: 48px;"></i>
                                </div>
                            @endif
                        </div>
                        <div style="padding: 15px;">
                            <h3 style="margin: 0 0 10px 0; font-size: 16px; font-weight: 600;">{{ $video['title'] }}</h3>
                            <a href="{{ $video['url'] }}" target="_blank" style="color: #04aa6d; text-decoration: none; font-size: 14px;">
                                Watch on YouTube <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; color: #999;">
                <i class="fas fa-video" style="font-size: 64px; margin-bottom: 20px; opacity: 0.3;"></i>
                <p style="font-size: 18px; margin-bottom: 10px;">No videos available at the moment</p>
                <p style="font-size: 14px;">Videos will be added soon</p>
            </div>
        @endif
        </div>
    </main>
</div>

@push('scripts')
<script src="{{ asset('js/sidebar.js') }}"></script>
@endpush
@endsection

