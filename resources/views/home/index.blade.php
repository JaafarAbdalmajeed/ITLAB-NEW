
@extends('layouts.app')

@section('title', 'ITLAB – Learn to Code')
@section('body-class', 'page-home')

@section('content')
  <!-- HERO -->
<section class="hero relative flex items-center justify-between w-full h-[80vh] min-h-[500px] overflow-hidden" 
         style="background: url('{{ asset('images/itlab-bg.jpg') }}') no-repeat center center/cover !important;">
    
    <div class="absolute inset-0 bg-black/50 z-0"></div>
    
    <div class="hero-left relative z-10 pl-6 w-1/2"> 
      <h1 class="hero-heading text-white text-6xl font-bold mb-4">Learn to Code</h1>
      <p class="hero-subtitle text-white/90 text-xl mb-8">
        With ITLAB The World's Largest Web Developer Site.
      </p>

      <div class="search-container mb-6 max-w-md"> <form id="searchForm" class="search-bar flex">
          <input type="text" id="searchInput" class="p-4 w-full rounded-l-full text-black outline-none" placeholder="Search our tutorials, e.g. HTML">
          <button type="submit" class="search-btn bg-[#059669] hover:bg-[#10b981] px-8 rounded-r-full text-white transition">🔍</button>
        </form>
      </div>

      <a href="{{ route('pages.getting-started') }}" id="begin-btn" class="text-white hover:text-teal-400 underline font-medium text-lg ml-2">
        Not Sure Where To Begin?
      </a>
    </div>

    <div class="hero-right relative z-10 pr-10 w-auto">
      <div class="example-card bg-[#f3f3f3] p-8 rounded-xl shadow-2xl w-[400px]">
        <div class="example-title text-black text-2xl font-bold mb-6">ITLAB Statistics:</div>
        <div class="example-inner text-gray-800 text-lg leading-relaxed mb-6">
            <div class="mb-4">
                <span class="mr-2">📊</span> <strong>Platform Stats:</strong>
                <ul class="ml-8 list-disc">
                    <li>{{ $stats['total_tracks'] }} Tracks</li>
                    <li>{{ $stats['total_lessons'] }} Lessons</li>
                    <li>{{ $stats['total_labs'] }} Labs</li>
                    <li>{{ $stats['total_quizzes'] }} Quizzes</li>
                </ul>
            </div>
            <div>
                <span class="mr-2">🚀</span> <strong>Start Learning:</strong>
                <ul class="ml-8">
                    <li>→ HTML Basics</li>
                    <li>→ CSS Styling</li>
                    <li>→ JavaScript Logic</li>
                </ul>
            </div>
        </div>
        <div class="example-footer">
          <button onclick="location.href='{{ route('pages.html') }}'" class="w-full bg-[#059669] hover:bg-[#10b981] text-white font-bold py-4 rounded-lg text-xl transition shadow-lg">
            Try it Yourself
          </button>
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
