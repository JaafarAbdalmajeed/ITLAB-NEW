@extends('layouts.app')

@section('title', 'Dashboard — ITLAB')
@section('body-class', 'page-dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    /* Applies only to dashboard page */
    body.page-dashboard {
      margin: 0;
      min-height: 100vh;
      font-family: "Poppins", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      background: radial-gradient(circle at top left, #1f2937, #020617);
      color: #f9fafb;
    }

    /* Dashboard content */
    .dashboard-section {
      max-width: 1200px;
      margin: 32px auto 40px;
      padding: 0 24px 40px;
    }

    .hero-heading {
      font-size: 28px;
      font-weight: 600;
      margin-bottom: 6px;
    }

    .hero-subtitle {
      font-size: 14px;
      color: #9ca3af;
      max-width: 520px;
      line-height: 1.5;
      margin-bottom: 24px;
    }

    /* Summary card */
    .dash-summary {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 16px;
      margin-bottom: 28px;
    }

    .dash-summary-item {
      padding: 14px 16px;
      border-radius: 18px;
      background: radial-gradient(circle at top left, #111827, #020617);
      border: 1px solid #111827;
      box-shadow: 0 16px 40px rgba(15, 23, 42, 0.7);
    }

    .dash-summary-label {
      font-size: 13px;
      color: #9ca3af;
      display: block;
      margin-bottom: 4px;
    }

    .dash-summary-value {
      font-size: 20px;
      font-weight: 600;
    }

    /* Track cards */
    .dashboard-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 20px;
    }

    .dash-card {
      position: relative;
      padding: 18px 18px 20px;
      border-radius: 22px;
      background: radial-gradient(circle at top left, rgba(34, 197, 94, 0.08), #020617);
      border: 1px solid #1f2937;
      box-shadow: 0 20px 60px rgba(15, 23, 42, 0.95);
      overflow: hidden;
      transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
    }

    .dash-card::before {
      content: "";
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at top right, rgba(56, 189, 248, 0.22), transparent 45%);
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.25s ease;
    }

    .dash-card:hover {
      transform: translateY(-4px);
      border-color: #22c55e66;
      box-shadow: 0 26px 70px rgba(15, 23, 42, 1);
    }

    .dash-card:hover::before {
      opacity: 1;
    }

    .dash-card-title {
      font-size: 18px;
      margin-bottom: 6px;
    }

    .dash-card-text {
      font-size: 13px;
      color: #9ca3af;
      margin-bottom: 14px;
      min-height: 42px;
    }

    .dash-progress {
      margin-bottom: 12px;
    }

    .dash-progress-label {
      display: flex;
      justify-content: space-between;
      font-size: 12px;
      color: #9ca3af;
      margin-bottom: 4px;
    }

    .dash-progress-label span {
      color: #e5e7eb;
      font-weight: 500;
    }

    .dash-progress-bar {
      position: relative;
      width: 100%;
      height: 8px;
      border-radius: 999px;
      background: #020617;
      border: 1px solid #1f2937;
      overflow: hidden;
    }

    .dash-progress-fill {
      height: 100%;
      border-radius: inherit;
      background: linear-gradient(90deg, #22c55e, #a3e635);
      transition: width 0.25s ease-out;
    }

    .dash-card-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 10px;
    }

    .btn-main,
    .btn-secondary {
      border-radius: 999px;
      padding: 8px 14px;
      font-size: 13px;
      border: 1px solid transparent;
      cursor: pointer;
      white-space: nowrap;
      transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease, border-color 0.15s ease, color 0.15s ease;
    }

    .btn-main {
      background: #22c55e;
      border-color: #22c55e;
      color: #022c22;
      font-weight: 500;
    }

    .btn-main:hover {
      background: #16a34a;
      box-shadow: 0 14px 40px rgba(34, 197, 94, 0.45);
      transform: translateY(-1px);
    }

    .btn-secondary {
      background: transparent;
      border-color: #4b5563;
      color: #e5e7eb;
    }

    .btn-secondary:hover {
      background: rgba(15, 23, 42, 0.92);
      border-color: #e5e7eb;
      transform: translateY(-1px);
    }

    @media (max-width: 768px) {
      .navbar {
        padding-inline: 16px;
      }

      .navbar-links {
        display: none; /* Mobile menu for later */
      }

      .dashboard-section {
        padding-inline: 16px;
      }
    }
  </style>
@endpush

  <!-- DASHBOARD CONTENT -->
  <main class="dashboard-section">
    <h1 class="hero-heading">Student Dashboard</h1>
    <p class="hero-subtitle">
      Overview of your progress in Programming and Cyber Security tracks on ITLAB.
    </p>

    <!-- Summary cards -->
    <section class="dash-summary">
      <div class="dash-summary-item">
        <span class="dash-summary-label">Total Tracks</span>
        <span class="dash-summary-value">{{ $totalTracks }}</span>
      </div>
      <div class="dash-summary-item">
        <span class="dash-summary-label">Total Lessons</span>
        <span class="dash-summary-value">{{ $totalLessons }}</span>
      </div>
      <div class="dash-summary-item">
        <span class="dash-summary-label">Total Labs</span>
        <span class="dash-summary-value">{{ $totalLabs }}</span>
      </div>
      <div class="dash-summary-item">
        <span class="dash-summary-label">Total Quizzes</span>
        <span class="dash-summary-value">{{ $totalQuizzes }}</span>
      </div>
      @if(auth()->check() && $userStats)
      <div class="dash-summary-item">
        <span class="dash-summary-label">Your Completed Tracks</span>
        <span class="dash-summary-value">{{ $userStats['completed_tracks'] }}</span>
      </div>
      <div class="dash-summary-item">
        <span class="dash-summary-label">In Progress</span>
        <span class="dash-summary-value">{{ $userStats['in_progress_tracks'] }}</span>
      </div>
      <div class="dash-summary-item">
        <span class="dash-summary-label">Quizzes Taken</span>
        <span class="dash-summary-value">{{ $userStats['total_quizzes_taken'] }}</span>
      </div>
      <div class="dash-summary-item">
        <span class="dash-summary-label">Average Score</span>
        <span class="dash-summary-value">{{ number_format($userStats['average_quiz_score'], 1) }}%</span>
      </div>
      @php
        $certificatesCount = auth()->user()->certificates()->count();
      @endphp
      <div class="dash-summary-item">
        <span class="dash-summary-label">Certificates</span>
        <span class="dash-summary-value">
          <a href="{{ route('certificates.index') }}" style="color: inherit; text-decoration: none;">
            {{ $certificatesCount }}
          </a>
        </span>
      </div>
      @endif
    </section>

    @auth
    @php
      $userCertificates = auth()->user()->certificates()->with('track')->latest('issued_at')->take(3)->get();
    @endphp
    @if($userCertificates->count() > 0)
    <!-- Certificates Section -->
    <section style="margin-bottom: 32px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h2 style="font-size: 20px; font-weight: 600;">🏆 My Certificates</h2>
        <a href="{{ route('certificates.index') }}" style="color: #22c55e; text-decoration: none; font-size: 14px;">
          View All <i class="fas fa-arrow-left"></i>
        </a>
      </div>
      <div class="dashboard-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
        @foreach($userCertificates as $certificate)
        <article class="dash-card">
          <div style="font-size: 32px; color: #22c55e; margin-bottom: 10px;">
            <i class="fas fa-certificate"></i>
          </div>
          <h2 class="dash-card-title">{{ $certificate->track->title }}</h2>
          <p class="dash-card-text" style="font-size: 11px; color: #9ca3af;">
            {{ $certificate->certificate_number }}
          </p>
          <p class="dash-card-text" style="font-size: 11px; color: #9ca3af; margin-top: -10px;">
            Issued: {{ $certificate->issued_at->format('M Y') }}
          </p>
          <div class="dash-card-actions">
            <button class="btn-main" onclick="location.href='{{ route('tracks.certificate.show', $certificate->track) }}'">
              View Certificate
            </button>
          </div>
        </article>
        @endforeach
      </div>
    </section>
    @endif
    @endauth

    @if($popularTracks->count() > 0)
    <!-- Popular Tracks Section -->
    <section style="margin-bottom: 32px;">
      <h2 style="font-size: 20px; font-weight: 600; margin-bottom: 16px;">🔥 Popular Tracks</h2>
      <div class="dashboard-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
        @foreach($popularTracks as $track)
        <article class="dash-card">
          <h2 class="dash-card-title">{{ $track->title }}</h2>
          <p class="dash-card-text">{{ $track->description ?? 'Learn ' . $track->title }}</p>
          <div style="font-size: 12px; color: #9ca3af; margin-top: 8px;">
            <i class="fas fa-users"></i> {{ $track->user_progress_count }} learners
          </div>
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
          <div class="dash-card-actions">
            <button class="btn-main" onclick="location.href='{{ $mainRoute }}'">
              View Track
            </button>
          </div>
        </article>
        @endforeach
      </div>
    </section>
    @endif

    <!-- Track cards -->
    <section class="dashboard-grid">
      @foreach($recentTracks as $track)
      @php
        $progress = auth()->check() ? ($track->getUserProgress()?->progress_percent ?? 0) : 0;
        $mainRoute = match($track->slug) {
            'html' => route('pages.html'),
            'css' => route('pages.css'),
            'js' => route('pages.js'),
            'cyber-network' => route('pages.cyber-network'),
            'cyber-web' => route('pages.cyber-web'),
            default => route('tracks.show', $track),
        };
        $trackRoute = match($track->slug) {
            'html' => route('pages.html.track'),
            'css' => route('pages.css.track'),
            'js' => route('pages.js.track'),
            default => route('tracks.show', $track),
        };
        $quizRoute = $track->getQuizRoute();
        $labsRoute = $track->getLabsRoute();
      @endphp
      <article class="dash-card">
        <h2 class="dash-card-title">{{ $track->title }} Track</h2>
        <p class="dash-card-text">
          {{ $track->description ?? 'Learn ' . $track->title . ' step by step' }}
        </p>
        @if(auth()->check())
        <div class="dash-progress">
          <div class="dash-progress-label">
            Progress
            <span>{{ $progress }}%</span>
          </div>
          <div class="dash-progress-bar">
            <div class="dash-progress-fill" style="width: {{ $progress }}%;"></div>
          </div>
        </div>
        @endif
        <div class="dash-card-actions">
          <button class="btn-main" onclick="location.href='{{ $trackRoute }}'">
            Open {{ $track->title }} track
          </button>
          @if($track->show_quiz ?? true)
          <button class="btn-secondary" onclick="location.href='{{ $quizRoute }}'">
            Take Quiz
          </button>
          @endif
          @if($track->show_labs ?? true)
          <button class="btn-secondary" onclick="location.href='{{ $labsRoute }}'">
            View Labs
          </button>
          @endif
          @auth
            @php
              $isCompleted = $track->isCompletedByUser(auth()->id());
              $certificate = $track->getUserCertificate(auth()->id());
            @endphp
            @if($isCompleted && $certificate)
            <button class="btn-main" style="background: #28a745;" onclick="location.href='{{ route('tracks.certificate.show', $track) }}'">
              <i class="fas fa-certificate"></i> Certificate
            </button>
            @endif
          @endauth
        </div>
      </article>
      @endforeach
    </section>
  </main>

  <!-- Your old scripts (login modal and others) -->
@push('scripts')
<script src="{{ asset('js/script.js') }}"></script>
@endpush

@endsection
