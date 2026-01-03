@extends('layouts.app')

@section('title', $track->title . ' Track — ITLAB')
@section('body-class', 'page-' . $track->slug . '-track')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endpush

<!-- HERO -->
<section class="hero">
    <div class="hero-left">
        <h1 class="hero-heading">{{ $track->title }} Track</h1>
        <p class="hero-subtitle">
            {{ $track->description }}
        </p>

        <p class="hero-note">
            In this track, you will cover all the fundamentals you need:
        </p>

        <div class="example-card" style="max-width:520px;">
            @php
                $orderedLessons = $track->lessons->sortBy('order')->values();
            @endphp
            <div class="example-title">Lessons in this track ({{ $orderedLessons->count() }})</div>
            <div class="example-inner">
                @if($orderedLessons->isEmpty())
                    <p>No lessons yet. Check back later.</p>
                @else
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        @foreach($orderedLessons as $lesson)
                            @php
                                $isCompleted = auth()->check() ? $lesson->isCompletedByUser(auth()->id()) : false;
                            @endphp
                            <li style="padding: 12px 0; border-bottom: 1px solid rgba(0,0,0,0.1); display: flex; align-items: center; gap: 12px;">
                                <div style="flex: 1;">
                                    <a href="{{ route('tracks.lessons.show', [$track, $lesson]) }}" 
                                       style="text-decoration: none; color: inherit; font-weight: 500; display: flex; align-items: center; gap: 8px;">
                                        <span style="color: #666; font-weight: 600; min-width: 30px;">{{ $lesson->order }}.</span>
                                        <span>{{ $lesson->title }}</span>
                                    </a>
                                </div>
                                @if(auth()->check())
                                    @if($isCompleted)
                                        <span style="color: #10b981; font-size: 18px;" title="Completed">
                                            <i class="fa-solid fa-check-circle"></i>
                                        </span>
                                    @else
                                        <span style="color: #ccc; font-size: 18px;" title="Not completed">
                                            <i class="fa-regular fa-circle"></i>
                                        </span>
                                    @endif
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <p style="margin-top:16px;font-size:14px;">
            You can navigate to the videos or quiz pages from the buttons on the
            @php
                $mainRoute = match($track->slug) {
                    'html' => route('pages.html'),
                    'css' => route('pages.css'),
                    'js' => route('pages.js'),
                    'cyber-network' => route('pages.cyber-network'),
                    'cyber-web' => route('pages.cyber-web'),
                    default => route('tracks.show', $track),
                };
            @endphp
            <a href="{{ $mainRoute }}">{{ $track->title }} main page</a>.
        </p>
    </div>

    <div class="hero-right">
        <div class="example-card">
            <div class="example-title">{{ $track->title }} Structure (Example)</div>
            <div class="example-inner">
                @if($track->example_code)
                    <pre><code>{{ $track->example_code }}</code></pre>
                @else
                    <p>Example code will be added soon.</p>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Ratings & Reviews Section -->
<section style="max-width: 1200px; margin: 40px auto; padding: 0 24px;">
    <x-ratings :track="$track" />
    <x-reviews :track="$track" />
</section>

@push('scripts')
<script src="{{ asset('js/script.js') }}"></script>
@endpush
@endsection

