@extends('layouts.app')

@section('title', 'ITLAB – Learn to Code')
@section('body-class', 'page-home')

@section('content')
  <!-- HERO -->
  <section class="hero">
    <div class="hero-left">
      <h1 class="hero-heading">Learn to Code</h1>
      <p class="hero-subtitle">
        With ITLAB The World's Largest Web Developer Site.
      </p>

      <div class="search-container">
        <form id="searchForm" class="search-bar">
          <input
            type="text"
            id="searchInput"
            placeholder="Search our tutorials, e.g. HTML">
          <button type="submit" class="search-btn">
            🔍
          </button>
        </form>
        <p id="searchMessage" class="search-message" style="color:#ccc; margin-top:8px; font-size:14px;"></p>
      </div>

      <a href="{{ route('pages.getting-started') }}" id="begin-btn">Not Sure Where To Begin?</a>

    </div>

    <div class="hero-right">
      <div class="example-card">
        <div class="example-title">ITLAB Statistics:</div>
        <div class="example-inner">
<pre><code>📊 Platform Stats:
  • {{ $stats['total_tracks'] }} Tracks
  • {{ $stats['total_lessons'] }} Lessons
  • {{ $stats['total_labs'] }} Labs
  • {{ $stats['total_quizzes'] }} Quizzes

🚀 Start Learning:
  → HTML Basics
  → CSS Styling
  → JavaScript Logic</code></pre>
        </div>
        <div class="example-footer">
          <button onclick="location.href='{{ route('pages.html') }}'">Start with HTML</button>
        </div>
      </div>
    </div>
  </section>

  <!-- TRACKS SECTION -->
  <section class="tracks-section">
    <!-- General Title -->
    <h2 class="tracks-title">Choose Your Track</h2>
    <p class="tracks-subtitle">
      Start with programming basics, then move to cyber security labs inside ITLAB.
    </p>

    <!-- Programming Tracks -->
    <div class="tracks-group">
      <h3 class="tracks-group-title">Programming Tracks</h3>

      <div class="tracks-grid">
        @foreach($programmingTracks as $track)
        <article class="track-card track-{{ $track->slug }}">
          <h4>{{ $track->title }}</h4>
          <p>{{ $track->description ?? 'Learn ' . $track->title . ' step by step' }}</p>
          <ul>
            @if($track->lessons->count() > 0)
              @foreach($track->lessons->take(3) as $lesson)
                <li>{{ $lesson->title }}</li>
              @endforeach
            @else
              <li>Basics & Fundamentals</li>
              <li>Practical Examples</li>
              <li>Hands-on Labs</li>
            @endif
          </ul>
          @php
            $trackRoute = match($track->slug) {
                'html' => route('pages.html'),
                'css' => route('pages.css'),
                'js' => route('pages.js'),
                'java' => route('pages.java'),
                default => route('tracks.show', $track),
            };
          @endphp
          <button onclick="location.href='{{ $trackRoute }}'">Go to {{ $track->title }}</button>
        </article>
        @endforeach
      </div>
    </div>

    <!-- Cyber Security Tracks -->
    <div class="tracks-group">
      <h3 class="tracks-group-title">Cyber Security Tracks</h3>

      <div class="tracks-grid">
        @foreach($cyberTracks as $track)
        <article class="track-card track-{{ $track->slug }}">
          <h4>{{ $track->title }}</h4>
          <p>{{ $track->description ?? 'Learn ' . $track->title . ' with hands-on labs' }}</p>
          <ul>
            @if($track->lessons->count() > 0)
              @foreach($track->lessons->take(3) as $lesson)
                <li>{{ $lesson->title }}</li>
              @endforeach
            @else
              <li>Security Fundamentals</li>
              <li>Practical Labs</li>
              <li>Real-world Scenarios</li>
            @endif
          </ul>
          @php
            $trackRoute = match($track->slug) {
                'cyber-network' => route('pages.cyber-network'),
                'cyber-web' => route('pages.cyber-web'),
                default => route('tracks.show', $track),
            };
          @endphp
          <button onclick="location.href='{{ $trackRoute }}'">Go to {{ $track->title }}</button>
        </article>
        @endforeach
      </div>
    </div>
  </section>

  <script>
  // Dynamic tracks from database (prepared in controller)
  const allTracks = @json($searchTracks);

  // Static routes for common searches
  const staticRoutes = [
    {
      keywords: ["html", "html5", "hypertext"],
      url: "{{ route('pages.html') }}"
    },
    {
      keywords: ["css", "stylesheet", "styling"],
      url: "{{ route('pages.css') }}"
    },
    {
      keywords: ["javascript", "js", "ecmascript"],
      url: "{{ route('pages.js') }}"
    },
    {
      keywords: ["java"],
      url: "{{ route('pages.java') }}"
    },
    {
      keywords: ["network", "network security", "networking"],
      url: "{{ route('pages.cyber-network') }}"
    },
    {
      keywords: ["web security", "web application security", "security", "cyber"],
      url: "{{ route('pages.cyber-web') }}"
    }
  ];

  // Combine all routes
  const allRoutes = [...staticRoutes, ...allTracks];

  const searchForm   = document.getElementById("searchForm");
  const searchInput  = document.getElementById("searchInput");
  const searchMsg    = document.getElementById("searchMessage");

  if (searchForm && searchInput && searchMsg) {
    searchForm.addEventListener("submit", function (e) {
      e.preventDefault(); // Don't reload the page

      const query = searchInput.value.trim().toLowerCase();

      if (!query) {
        searchMsg.textContent = "Please enter a course name first (e.g., HTML, CSS, JavaScript).";
        searchMsg.style.color = "#fbbf24";
        return;
      }

      // Try to find the first track that matches the user's input
      const match = allRoutes.find(route =>
        route.keywords.some(keyword => 
          keyword.includes(query) || query.includes(keyword)
        )
      );

      if (match) {
        // Redirect user to the track page
        window.location.href = match.url;
      } else {
        // No match found
        searchMsg.textContent = "No match found. Try keywords like: HTML, CSS, JavaScript, Network Security, Java, PHP...";
        searchMsg.style.color = "#ef4444";
      }
    });

    // Clear message when user starts typing
    searchInput.addEventListener("input", function() {
      if (searchMsg.textContent) {
        searchMsg.textContent = "";
      }
    });
  }
  </script>

@endsection
