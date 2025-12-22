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
            <div class="example-title">Modules in this track</div>
            <div class="example-inner">
                @if($track->lessons->isEmpty())
                    <p>No lessons yet. Check back later.</p>
                @else
                    <ul>
                        @foreach($track->lessons as $lesson)
                            <li>
                                <b>{{ $lesson->order }}.</b> 
                                <a href="{{ route('tracks.lessons.show', [$track, $lesson]) }}">{{ $lesson->title }}</a>
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

@push('scripts')
<script src="{{ asset('js/script.js') }}"></script>
@endpush
@endsection

