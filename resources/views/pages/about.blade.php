@extends('layouts.app')

@section('title', 'About ITLAB')
@section('body-class', 'page-about')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<style>
  .page-wrapper {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
  }
  
  .hero {
    margin-bottom: 40px;
  }
  
  .hero h1 {
    font-size: 32px;
    margin-bottom: 12px;
  }
  
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin: 32px 0;
  }
  
  .stat-card {
    background: linear-gradient(135deg, #04aa6d, #22c55e);
    color: #fff;
    padding: 24px;
    border-radius: 12px;
    text-align: center;
  }
  
  .stat-value {
    font-size: 36px;
    font-weight: 700;
    margin-bottom: 4px;
  }
  
  .stat-label {
    font-size: 14px;
    opacity: 0.9;
  }
  
  .tracks-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin: 32px 0;
  }
  
  .track-card {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-left: 4px solid #04aa6d;
  }
  
  .track-card h3 {
    color: #04aa6d;
    margin-bottom: 8px;
  }
  
  .track-card p {
    color: #666;
    font-size: 14px;
    margin-bottom: 12px;
  }
  
  .track-meta {
    display: flex;
    gap: 16px;
    font-size: 12px;
    color: #999;
  }
</style>
@endpush

  <main class="page-wrapper">
    <header class="hero">
      <h1>About ITLAB</h1>
      <p style="color:#9ca3af; max-width:720px;">
        ITLAB is a hands-on learning platform for web development and cyber security.
        We focus on short, practical tracks, labs, and quizzes so learners build
        real skills while working on real examples.
      </p>
    </header>

    <!-- Statistics -->
    <section>
      <h2 style="font-size: 24px; margin-bottom: 16px;">Platform Statistics</h2>
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-value">{{ $stats['total_tracks'] }}</div>
          <div class="stat-label">Learning Tracks</div>
        </div>
        <div class="stat-card">
          <div class="stat-value">{{ $stats['total_lessons'] }}</div>
          <div class="stat-label">Lessons</div>
        </div>
        <div class="stat-card">
          <div class="stat-value">{{ $stats['total_labs'] }}</div>
          <div class="stat-label">Hands-on Labs</div>
        </div>
        <div class="stat-card">
          <div class="stat-value">{{ $stats['total_quizzes'] }}</div>
          <div class="stat-label">Quizzes</div>
        </div>
        <div class="stat-card">
          <div class="stat-value">{{ $stats['total_users'] }}</div>
          <div class="stat-label">Active Learners</div>
        </div>
      </div>
    </section>

    <section>
      <h2 style="font-size: 24px; margin-bottom: 16px;">Our Approach</h2>
      <p style="color:#9ca3af; line-height: 1.8; margin-bottom: 24px;">
        We emphasize learning-by-doing: follow a track, complete small projects and labs, then validate your knowledge with quizzes.
        All content is dynamic and managed through our admin dashboard, ensuring up-to-date and relevant learning materials.
      </p>

      <h3 style="margin-top: 24px; margin-bottom: 16px;">Available Tracks</h3>
      <div class="tracks-grid">
        @foreach($allTracks as $track)
        <div class="track-card">
          <h3>{{ $track->title }}</h3>
          <p>{{ $track->description ?? 'Learn ' . $track->title . ' step by step' }}</p>
          <div class="track-meta">
            <span><i class="fas fa-book"></i> {{ $track->lessons->count() }} Lessons</span>
            <span><i class="fas fa-flask"></i> {{ $track->labs->count() }} Labs</span>
            <span><i class="fas fa-question-circle"></i> {{ $track->quizzes->count() }} Quizzes</span>
          </div>
          @php
            $trackRoute = match($track->slug) {
                'html' => route('pages.html'),
                'css' => route('pages.css'),
                'js' => route('pages.js'),
                'cyber-network' => route('pages.cyber-network'),
                'cyber-web' => route('pages.cyber-web'),
                default => route('tracks.show', $track),
            };
          @endphp
          <a href="{{ $trackRoute }}" style="color: #04aa6d; text-decoration: none; font-weight: 600; display: inline-block; margin-top: 8px;">
            Explore Track →
          </a>
        </div>
        @endforeach
      </div>
    </section>

    <section style="margin-top: 40px;">
      <h3 style="margin-bottom: 16px;">Start Learning</h3>
      <p style="color:#9ca3af; line-height: 1.8;">
        Begin with our <a href="{{ route('pages.getting-started') }}" style="color: #04aa6d;">Getting Started</a> guide or jump straight into a track like 
        <a href="{{ route('pages.html') }}" style="color: #04aa6d;">HTML</a>, 
        <a href="{{ route('pages.css') }}" style="color: #04aa6d;">CSS</a>, 
        <a href="{{ route('pages.js') }}" style="color: #04aa6d;">JavaScript</a>, or 
        <a href="{{ route('pages.cyber-network') }}" style="color: #04aa6d;">Network Security</a>.
      </p>
    </section>

    {{-- Display page sections if they exist --}}
    @if($page && $page->publishedSections->count() > 0)
      @foreach($page->publishedSections as $section)
        <section class="page-section page-section-{{ $section->section_type }}" style="margin-top: 40px; margin-bottom: 40px;">
          @if($section->title)
            <h2 style="margin-bottom: 15px; font-size: 24px; color: #333;">{{ $section->title }}</h2>
          @endif
          @if($section->subtitle)
            <p style="color:#666; margin-bottom: 20px; font-size: 16px;">{!! $section->subtitle !!}</p>
          @endif
          @if($section->content)
            <div style="background: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); color:#333; line-height:1.7;">
              {!! $section->content !!}
            </div>
          @endif
        </section>
      @endforeach
    @elseif($page && $page->content)
      {{-- Fallback to old content if no sections --}}
      <section style="margin-top: 40px; background: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        {!! $page->content !!}
      </section>
    @endif
  </main>
@endsection
