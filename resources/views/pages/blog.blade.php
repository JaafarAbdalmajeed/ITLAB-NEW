@extends('layouts.app')

@section('title', 'Blog & Updates — ITLAB')
@section('body-class', 'page-blog')

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
  
  .blog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
  }
  
  .blog-card {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.2s, box-shadow 0.2s;
  }
  
  .blog-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
  }
  
  .blog-card h3 {
    font-size: 20px;
    margin-bottom: 8px;
    color: #04aa6d;
  }
  
  .blog-card p {
    color: #666;
    line-height: 1.6;
    margin-bottom: 12px;
  }
  
  .blog-card .meta {
    font-size: 12px;
    color: #999;
    display: flex;
    gap: 16px;
  }
  
  .stats-section {
    background: linear-gradient(135deg, #04aa6d, #22c55e);
    color: #fff;
    padding: 32px;
    border-radius: 12px;
    margin-bottom: 40px;
  }
  
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 24px;
    margin-top: 24px;
  }
  
  .stat-item {
    text-align: center;
  }
  
  .stat-value {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 4px;
  }
  
  .stat-label {
    font-size: 14px;
    opacity: 0.9;
  }
</style>
@endpush

  <main class="page-wrapper">
    <header class="hero">
      <h1>Blog & Updates</h1>
      <p style="color:#9ca3af; max-width:720px;">
        Stay updated with the latest news, new tracks, features, and community highlights from ITLAB.
      </p>
    </header>

    <!-- Statistics Section -->
    <section class="stats-section">
      <h2 style="margin-bottom: 8px; font-size: 24px;">Platform Statistics</h2>
      <p style="opacity: 0.9; margin-bottom: 0;">ITLAB in numbers</p>
      <div class="stats-grid">
        <div class="stat-item">
          <div class="stat-value">{{ $stats['total_tracks'] }}</div>
          <div class="stat-label">Tracks</div>
        </div>
        <div class="stat-item">
          <div class="stat-value">{{ $stats['total_lessons'] }}</div>
          <div class="stat-label">Lessons</div>
        </div>
        <div class="stat-item">
          <div class="stat-value">{{ $stats['total_labs'] }}</div>
          <div class="stat-label">Labs</div>
        </div>
      </div>
    </section>

    <!-- Recent Tracks -->
    <section>
      <h2 style="font-size: 24px; margin-bottom: 20px;">Latest Tracks</h2>
      <div class="blog-grid">
        @foreach($recentTracks as $track)
        <article class="blog-card">
          <h3>{{ $track->title }}</h3>
          <p>{{ $track->description ?? 'New track added to ITLAB' }}</p>
          <div class="meta">
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
          <a href="{{ $trackRoute }}" style="color: #04aa6d; text-decoration: none; font-weight: 600;">
            Explore Track →
          </a>
        </article>
        @endforeach
      </div>
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
      <section style="margin-top: 40px;">
        <div style="background: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
          {!! $page->content !!}
        </div>
      </section>
    @endif
  </main>
@endsection
