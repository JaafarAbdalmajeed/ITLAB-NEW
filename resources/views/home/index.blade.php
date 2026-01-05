
@extends('layouts.app')

@section('title', 'ITLAB – Learn to Code')
@section('body-class', 'page-home')

@section('content')
  <!-- HERO -->
<section class="hero relative flex items-center justify-between w-full h-[80vh] min-h-[500px] overflow-hidden" 
         @php
            $bgStyle = "background: url('" . asset('images/itlab-bg.jpg') . "') no-repeat center center/cover !important;";
            if($backgroundSetting && $backgroundSetting->is_active) {
                if($backgroundSetting->type === 'image' && $backgroundSetting->image_path) {
                    $bgStyle = "background: url('" . asset('storage/' . $backgroundSetting->image_path) . "') no-repeat center center/cover !important;";
                } elseif($backgroundSetting->type === 'video' && $backgroundSetting->video_path) {
                    $bgStyle = "position: relative;";
                }
            }
         @endphp
         style="{{ $bgStyle }}">
    
    {{-- Video Background --}}
    @if($backgroundSetting && $backgroundSetting->is_active && $backgroundSetting->type === 'video' && $backgroundSetting->video_path)
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover z-0" style="object-fit: cover;">
            <source src="{{ asset('storage/' . $backgroundSetting->video_path) }}" type="video/mp4">
            <source src="{{ asset('storage/' . $backgroundSetting->video_path) }}" type="video/webm">
            Your browser does not support the video tag.
        </video>
    @endif

    {{-- Animated Background --}}
    @if($backgroundSetting && $backgroundSetting->is_active && $backgroundSetting->type === 'animated')
        @if($backgroundSetting->animated_type === 'css-gradient')
            <div class="animated-gradient absolute inset-0 z-0"></div>
        @elseif($backgroundSetting->animated_type === 'css-particles')
            <div class="animated-particles absolute inset-0 z-0"></div>
        @elseif($backgroundSetting->animated_type === 'gif' && $backgroundSetting->image_path)
            <div class="absolute inset-0 z-0" style="background: url('{{ asset('storage/' . $backgroundSetting->image_path) }}') no-repeat center center/cover;"></div>
        @endif
    @endif
    
    <div class="absolute inset-0 z-0" 
         style="background: {{ $backgroundSetting && $backgroundSetting->is_active ? $backgroundSetting->overlay_color ?? 'rgba(0,0,0,0.5)' : 'rgba(0,0,0,0.5)' }}; 
                opacity: {{ $backgroundSetting && $backgroundSetting->is_active ? ($backgroundSetting->overlay_opacity ?? 50) / 100 : 0.5 }};"></div>
    
    <div class="hero-left relative z-10 pl-6 w-1/2"> 
      <h1 class="hero-heading text-white text-6xl font-bold mb-4">Learn to Code</h1>
      <p class="hero-subtitle text-white/90 text-xl mb-8">
        With ITLAB The World's Largest Web Developer Site.
      </p>

      <div class="search-container mb-6 max-w-md">
        <form id="searchForm" class="search-bar flex">
          <input type="text" id="searchInput" class="p-4 w-full rounded-l-full text-black outline-none" placeholder="Search our tutorials, e.g. HTML">
          <button type="submit" class="search-btn bg-[#059669] hover:bg-[#10b981] px-8 rounded-r-full text-white transition">🔍</button>
        </form>
        <div id="searchMessage" style="margin-top: 10px; min-height: 20px;"></div>
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

  if (searchForm && searchInput) {
    searchForm.addEventListener("submit", function (e) {
      e.preventDefault(); // Don't reload the page

      const query = searchInput.value.trim().toLowerCase();

      if (!query) {
        if (searchMsg) {
          searchMsg.textContent = "Please enter a course name first (e.g., HTML, CSS, JavaScript).";
          searchMsg.style.color = "#fbbf24";
        }
        return;
      }

      // Try to find tracks that match the user's input
      // First, try exact matches
      let match = allRoutes.find(route =>
        route.keywords && route.keywords.some(keyword => {
          const lowerKeyword = keyword.toLowerCase();
          return lowerKeyword === query || query === lowerKeyword;
        })
      );

      // If no exact match, try partial matches
      if (!match) {
        match = allRoutes.find(route =>
          route.keywords && route.keywords.some(keyword => {
            const lowerKeyword = keyword.toLowerCase();
            return lowerKeyword.includes(query) || query.includes(lowerKeyword);
          })
        );
      }

      // If still no match, try word-by-word matching
      if (!match && query.split(' ').length > 1) {
        const queryWords = query.split(' ').filter(w => w.length > 0);
        match = allRoutes.find(route =>
          route.keywords && route.keywords.some(keyword => {
            const lowerKeyword = keyword.toLowerCase();
            return queryWords.some(word => lowerKeyword.includes(word) || word.includes(lowerKeyword));
          })
        );
      }

      if (match) {
        // Redirect user to the track page
        window.location.href = match.url;
      } else {
        // No match found
        if (searchMsg) {
          searchMsg.textContent = "No match found. Try keywords like: HTML, CSS, JavaScript, Network Security, Java, PHP...";
          searchMsg.style.color = "#ef4444";
        }
      }
    });

    // Clear message when user starts typing
    if (searchInput && searchMsg) {
      searchInput.addEventListener("input", function() {
        if (searchMsg.textContent) {
          searchMsg.textContent = "";
        }
      });
    }
  }
  </script>

@push('styles')
<style>
    /* Animated Gradient Background */
    .animated-gradient {
        background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #4facfe, #00f2fe);
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
    }

    @keyframes gradientShift {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }

    /* Animated Particles Background */
    .animated-particles {
        background: #1a1a2e;
        position: relative;
        overflow: hidden;
    }

    .animated-particles::before,
    .animated-particles::after {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(102, 126, 234, 0.3) 0%, transparent 70%);
        animation: float 20s ease-in-out infinite;
    }

    .animated-particles::before {
        top: 20%;
        left: 20%;
        animation-delay: 0s;
    }

    .animated-particles::after {
        bottom: 20%;
        right: 20%;
        animation-delay: 10s;
    }

    @keyframes float {
        0%, 100% {
            transform: translate(0, 0) scale(1);
            opacity: 0.5;
        }
        25% {
            transform: translate(50px, -50px) scale(1.2);
            opacity: 0.8;
        }
        50% {
            transform: translate(-30px, 30px) scale(0.8);
            opacity: 0.6;
        }
        75% {
            transform: translate(30px, 50px) scale(1.1);
            opacity: 0.7;
        }
    }

    /* Video Background Styles */
    .hero video {
        position: absolute;
        top: 50%;
        left: 50%;
        min-width: 100%;
        min-height: 100%;
        width: auto;
        height: auto;
        transform: translate(-50%, -50%);
        z-index: 0;
    }
</style>
@endpush

@endsection
