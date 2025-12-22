@extends('layouts.app')

@section('title', 'Get Certified — ITLAB')
@section('body-class', 'page-get-certified')

@section('content')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
<style>
    :root {
      --bg: #050814;
      --card: #111827;
      --muted: #9ca3af;
      --accent: #00c26e;
      --accent-soft: #04e08a;
      --border: #1f2937;
      --text: #e5e7eb;
      --yellow: #fde047;
    }

    *{ box-sizing:border-box; margin:0; padding:0; }

    body{
      font-family: system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
      background: radial-gradient(circle at top,#111827 0,#020409 55%,#000 100%);
      color:var(--text);
      min-height:100vh;
    }


    /* Hero */
    .hero{
      text-align:left;
      padding:32px;
      background:linear-gradient(135deg,#020617,#111827);
      border-radius:12px;
      border:1px solid var(--border);
      box-shadow:0 20px 45px rgba(0,0,0,.7);
      margin-bottom:32px;
    }
    .hero h2{
      font-size:28px;
      margin-bottom:12px;
      color:var(--text);
    }
    .hero p{
      color:var(--muted);
      font-size:16px;
      line-height:1.8;
      margin-bottom:16px;
    }
    .hero-tag{
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding:4px 10px;
      border-radius:999px;
      background:rgba(56,189,248,.12);
      color:#7dd3fc;
      font-size:11px;
      text-transform:uppercase;
      letter-spacing:.16em;
      margin-bottom:16px;
    }

    /* Course section */
    .courses-header{
      display:flex;
      align-items:center;
      justify-content:space-between;
      margin-bottom:14px;
      margin-top:6px;
    }
    .courses-header h2{
      font-size:18px;
    }
    .courses-header span{
      font-size:13px;
      color:var(--muted);
    }

    .course-grid{
      display:grid;
      grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
      gap:20px;
    }

    .course-card{
      background:var(--card);
      border-radius:16px;
      border:1px solid var(--border);
      padding:18px 18px 16px;
      position:relative;
      overflow:hidden;
      box-shadow:0 16px 35px rgba(0,0,0,.7);
    }
    .course-card::before{
      content:"";
      position:absolute;
      inset:0;
      background:radial-gradient(circle at top left,rgba(252,211,77,.17),transparent 60%);
      pointer-events:none;
    }

    .course-top{
      display:flex;
      align-items:flex-start;
      gap:14px;
      margin-bottom:10px;
    }

    .course-icon{
      width:54px;
      height:54px;
      border-radius:14px;
      background:linear-gradient(135deg,#facc15,#fbbf24);
      display:flex;
      align-items:center;
      justify-content:center;
      color:#111827;
      font-size:26px;
      font-weight:700;
      flex-shrink:0;
      box-shadow:0 10px 22px rgba(0,0,0,.7);
    }

    .course-label{
      font-size:11px;
      text-transform:uppercase;
      letter-spacing:.16em;
      color:#a5b4fc;
      margin-bottom:4px;
    }

    .course-title{
      font-size:18px;
      margin-bottom:4px;
    }

    .course-sub{
      font-size:13px;
      color:var(--muted);
      line-height:1.6;
    }

    .course-list{
      margin:10px 0 10px 18px;
      font-size:13px;
      color:#e5e7eb;
    }
    .course-list li{
      margin-bottom:4px;
    }

    .meta-row{
      display:flex;
      flex-wrap:wrap;
      gap:8px;
      font-size:11px;
      color:var(--muted);
      margin-bottom:10px;
    }
    .meta-pill{
      padding:4px 9px;
      border-radius:999px;
      background:#020617;
      border:1px solid #374151;
      display:inline-flex;
      align-items:center;
      gap:6px;
    }

    .price-row{
      display:flex;
      align-items:flex-end;
      justify-content:space-between;
      flex-wrap:wrap;
      gap:10px;
      margin-top:6px;
    }

    .price-box{
      display:flex;
      flex-direction:column;
      gap:2px;
    }
    .price-main{
      font-size:24px;
      font-weight:700;
    }
    .price-main span{
      font-size:15px;
      font-weight:500;
    }
    .price-note{
      font-size:12px;
      color:var(--muted);
    }
    .price-badge{
      display:inline-flex;
      align-items:center;
      gap:6px;
      padding:3px 8px;
      border-radius:999px;
      background:rgba(74,222,128,.1);
      color:#4ade80;
      font-size:11px;
      text-transform:uppercase;
      letter-spacing:.12em;
    }

    .actions{
      display:flex;
      flex-wrap:wrap;
      gap:8px;
    }
    .btn-primary{
      text-decoration:none;
      padding:9px 16px;
      border-radius:999px;
      border:none;
      background:linear-gradient(135deg,var(--accent),var(--accent-soft));
      color:#020617;
      font-weight:600;
      font-size:14px;
      display:inline-flex;
      align-items:center;
      gap:6px;
      box-shadow:0 14px 28px rgba(0,0,0,.8);
      transition:.15s ease;
      cursor:pointer;
    }
    .btn-primary:hover{
      transform:translateY(-1px);
      box-shadow:0 20px 38px rgba(0,0,0,.9);
    }

    .btn-ghost{
      text-decoration:none;
      padding:8px 13px;
      border-radius:999px;
      border:1px solid #374151;
      background:rgba(15,23,42,.95);
      color:var(--muted);
      font-size:13px;
      display:inline-flex;
      align-items:center;
      gap:6px;
      cursor:pointer;
      transition:.15s ease;
    }
    .btn-ghost:hover{
      border-color:var(--accent);
      color:var(--text);
    }

    .note{
      margin-top:18px;
      font-size:12px;
      color:var(--muted);
      text-align:center;
    }

    /* Modals */
    .modal-backdrop{
      position:fixed;
      inset:0;
      background:rgba(0,0,0,.7);
      display:none;
      justify-content:center;
      align-items:center;
      z-index:9999;
      backdrop-filter:blur(4px);
    }
    .modal-backdrop.active{
      display:flex;
    }
    .modal{
      background:#0b1120;
      border-radius:16px;
      border:1px solid #1f2937;
      padding:20px 22px 18px;
      max-width:520px;
      width:90%;
      box-shadow:0 20px 45px rgba(0,0,0,.8);
      position:relative;
      font-size:14px;
      color:var(--muted);
    }
    .modal h2{
      font-size:18px;
      margin-bottom:8px;
      color:var(--text);
    }
    .modal-close{
      position:absolute;
      top:10px;
      right:12px;
      font-size:20px;
      background:none;
      border:none;
      color:var(--muted);
      cursor:pointer;
    }
    .modal-close:hover{
      color:#fff;
    }
    .modal ul{
      margin-left:18px;
      margin-top:6px;
    }
    .modal ul li{
      margin-bottom:4px;
    }
    .modal-footer{
      margin-top:12px;
      font-size:12px;
      color:var(--muted);
    }
    .modal-footer strong{
      color:var(--accent-soft);
    }

    .modal-form{
      display:flex;
      flex-direction:column;
      gap:8px;
      margin-top:10px;
    }
    .modal-form label{
      font-size:13px;
      color:var(--text);
    }
    .modal-form input,
    .modal-form select{
      background:#020617;
      border:1px solid #374151;
      border-radius:8px;
      padding:8px 10px;
      color:var(--text);
      font-size:13px;
      outline:none;
    }
    .modal-form input:focus,
    .modal-form select:focus{
      border-color:var(--accent);
    }

    .btn-confirm{
      margin-top:10px;
      width:100%;
      text-align:center;
      border-radius:999px;
      border:none;
      padding:9px 0;
      background:linear-gradient(135deg,var(--accent),var(--accent-soft));
      color:#020617;
      font-weight:600;
      cursor:pointer;
      transition:.15s ease;
    }
    .btn-confirm:hover{
      transform:translateY(-1px);
      box-shadow:0 12px 26px rgba(0,0,0,.8);
    }

    @media(max-width:640px){
      .hero h2{ font-size:22px; }
      .hero{ padding:24px 18px; }
    }
  </style>
@endpush

  <div class="page-wrapper">
    <!-- Sidebar -->
    <x-sidebar 
      currentPage="certified" 
      :certificationTracks="$certificationTracks"
    />

    <!-- Main Content -->
    <main class="main-content">
      <!-- Header -->
      <div class="content-header">
        <h1>Get Certified</h1>
        <a href="{{ route('home') }}" class="back-link">
          <i class="fa-solid fa-arrow-left-long"></i>
          Back to Home
        </a>
      </div>

      <!-- Hero -->
      <section class="hero">
        <div class="hero-tag">
          <i class="fa-solid fa-award"></i>
          <span>ITLAB Certification</span>
        </div>
        <h2>Get Certified in Web Development & Cyber Security</h2>
        <p>
          Earn official ITLAB certificates by completing tracks, passing quizzes, and demonstrating your skills.
        </p>
        <p>
          Getting certified is easy - You will enjoy it! Complete any track, pass the final quiz with 80% or higher, 
          and earn your official ITLAB certificate. All certificates are free and shareable.
        </p>
        <div style="margin-top: 20px; display: flex; gap: 12px; flex-wrap: wrap;">
          <a href="#certifications" class="btn-primary" style="text-decoration: none;">
            <i class="fa-solid fa-graduation-cap"></i> View Certifications
          </a>
          <a href="{{ route('pages.try-it') }}" class="btn-ghost" style="text-decoration: none;">
            <i class="fa-solid fa-code"></i> Try it Yourself
          </a>
        </div>
      </section>

      <!-- Learning by Examples Section -->
      <section style="background: linear-gradient(135deg,#020617,#111827); border-radius: 12px; border: 1px solid var(--border); padding: 24px; margin-bottom: 32px;">
        <h2 style="font-size: 24px; margin-bottom: 16px; color: var(--text);">Learning by Examples</h2>
        <p style="color: var(--muted); margin-bottom: 16px; line-height: 1.7;">
          With our interactive tracks, you can learn by doing. Complete lessons, practice in labs, and test your knowledge with quizzes.
        </p>
        <div style="background: #1e1e1e; border-radius: 8px; padding: 20px; margin: 16px 0; border: 1px solid #333;">
          <div style="color: #9ca3af; font-size: 13px; margin-bottom: 8px;">Example: Certification Process</div>
          <pre style="color: #e5e7eb; margin: 0; font-family: 'Courier New', monospace; font-size: 14px; line-height: 1.6;"><code>1. Choose a track (HTML, CSS, JavaScript, etc.)
2. Complete all lessons and labs
3. Take the certification quiz
4. Score 80% or higher
5. Download your certificate</code></pre>
        </div>
        <a href="{{ route('pages.try-it') }}" class="btn-primary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px; margin-top: 12px;">
          <i class="fa-solid fa-play"></i> Try it Yourself
        </a>
      </section>

      <!-- Course list -->
      <div id="certifications" style="scroll-margin-top: 20px;"></div>
      <div class="courses-header">
        <h2>Available Certifications</h2>
        <span>Currently offering {{ $certificationTracks->count() }} certification tracks.</span>
      </div>

    <div class="course-grid">
      @foreach($certificationTracks as $track)
      @php
        $quiz = $track->quizzes->first();
        $quizCount = $track->quizzes->count();
        $questionCount = $track->quizzes->sum(function($q) { return $q->questions->count(); });
        $lessonCount = $track->lessons->count();
        $labCount = $track->labs->count();
        
        // Check if user has completed this certification
        $isCompleted = false;
        $userBestScore = null;
        if (auth()->check() && $userCertifications && isset($userCertifications[$track->id])) {
          $userBestScore = $userCertifications[$track->id]->max('score');
          $isCompleted = $userBestScore >= 80; // 80% to pass
        }
        
        $trackRoute = match($track->slug) {
            'html' => route('pages.html'),
            'css' => route('pages.css'),
            'js' => route('pages.js'),
            'cyber-network' => route('pages.cyber-network'),
            'cyber-web' => route('pages.cyber-web'),
            default => route('tracks.show', $track),
        };
        
        $quizRoute = $track->getQuizRoute();
      @endphp
      <article class="course-card">
        <div class="course-top">
          <div class="course-icon">{{ strtoupper(substr($track->title, 0, 2)) }}</div>
          <div>
            <div class="course-label">Certification · {{ $track->title }}</div>
            <h3 class="course-title">{{ $track->title }} Developer Certificate</h3>
            <p class="course-sub">
              {{ $track->description ?? 'Learn ' . $track->title . ' from scratch to job-ready level – then pass a final exam and earn an official ITLAB certificate.' }}
            </p>
          </div>
        </div>

        <ul class="course-list">
          @if($track->lessons->count() > 0)
            @foreach($track->lessons->take(4) as $lesson)
              <li>{{ $lesson->title }}</li>
            @endforeach
            @if($track->lessons->count() > 4)
              <li>+ {{ $track->lessons->count() - 4 }} more lessons</li>
            @endif
          @else
            <li>Comprehensive {{ $track->title }} curriculum</li>
            <li>Hands-on practical exercises</li>
            <li>Real-world projects</li>
            <li>Final certification exam</li>
          @endif
          @if($labCount > 0)
            <li>{{ $labCount }} hands-on labs</li>
          @endif
          @if($quizCount > 0)
            <li>{{ $questionCount }} quiz questions</li>
          @endif
        </ul>

        <div class="meta-row">
          <span class="meta-pill"><i class="fa-regular fa-clock"></i> Self-paced</span>
          <span class="meta-pill"><i class="fa-solid fa-signal"></i> All Levels</span>
          <span class="meta-pill"><i class="fa-solid fa-globe"></i> 100% online</span>
          @if($isCompleted)
          <span class="meta-pill" style="background:rgba(74,222,128,.2); color:#4ade80; border-color:#4ade80;">
            <i class="fa-solid fa-check"></i> Certified
          </span>
          @endif
        </div>

        @if($userBestScore !== null)
        <div style="margin: 10px 0; padding: 8px; background: rgba(56,189,248,.1); border-radius: 8px; border: 1px solid rgba(56,189,248,.2);">
          <div style="font-size: 12px; color: #7dd3fc; margin-bottom: 4px;">Your Best Score</div>
          <div style="font-size: 18px; font-weight: 600; color: #e5e7eb;">{{ $userBestScore }}%</div>
        </div>
        @endif

        <div class="price-row">
          <div class="price-box">
            <div class="price-badge">
              <i class="fa-solid fa-certificate"></i> Certificate included
            </div>
            <div class="price-main">Free <span>USD</span></div>
            <div class="price-note">
              Complete the track, pass the quiz with 80%+, and earn your certificate.
            </div>
          </div>

          <div class="actions">
            @if($isCompleted)
            <a href="#" class="btn-primary" style="background: #4ade80; color: #020617;">
              <i class="fa-solid fa-certificate"></i> View Certificate
            </a>
            @else
            <a href="{{ $quizRoute }}" class="btn-primary">
              Take Certification Quiz
              <i class="fa-solid fa-arrow-right"></i>
            </a>
            @endif
            <a href="{{ $trackRoute }}" class="btn-ghost">
              View Track
              <i class="fa-regular fa-file-lines"></i>
            </a>
            <a href="#" class="btn-ghost" data-syllabus="{{ $track->slug }}">
              Syllabus
              <i class="fa-regular fa-file-lines"></i>
            </a>
          </div>
        </div>
      </article>
      @endforeach
    </div>

      <!-- Certification Examples Section -->
      <section style="margin-top: 48px; margin-bottom: 32px;">
        <h2 style="font-size: 32px; margin-bottom: 16px; color: var(--text);">Certification Examples</h2>
        <p style="color: var(--muted); margin-bottom: 24px; line-height: 1.8; font-size: 16px;">
          This certification page supplements all explanations with clarifying examples and tracks.
        </p>
        
        <div style="background: linear-gradient(135deg,#020617,#111827); border-radius: 12px; border: 1px solid var(--border); padding: 24px;">
          <h3 style="font-size: 20px; margin-bottom: 12px; color: var(--text);">Certification Process</h3>
          <ol style="color: var(--muted); line-height: 2; margin-left: 20px; font-size: 15px;">
            <li>Select a certification track from the list above</li>
            <li>Complete all lessons and practical labs</li>
            <li>Take the certification quiz</li>
            <li>Score 80% or higher to pass</li>
            <li>Download and share your certificate</li>
          </ol>
        </div>
      </section>

      <!-- Exercises Section -->
      <section style="margin-bottom: 32px; background: linear-gradient(135deg,#020617,#111827); border-radius: 12px; border: 1px solid var(--border); padding: 24px;">
        <h2 style="font-size: 32px; margin-bottom: 16px; color: var(--text);">Certification Exercises</h2>
        <p style="color: var(--muted); margin-bottom: 20px; line-height: 1.8;">
          Many chapters in our tracks end with exercises where you can check your level of knowledge.
        </p>
        <div style="background: #1e1e1e; border-radius: 8px; padding: 20px; border: 1px solid #333;">
          <div style="color: #e5e7eb; font-size: 16px; font-weight: 600; margin-bottom: 12px;">Exercise:</div>
          <div style="color: var(--muted); margin-bottom: 16px; line-height: 1.7;">
            What is required to earn an ITLAB certification?
          </div>
          <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <button class="btn-ghost" style="border: none; background: #373940; cursor: pointer;">Complete the track</button>
            <button class="btn-ghost" style="border: none; background: #373940; cursor: pointer;">Pass the quiz with 80%+</button>
            <button class="btn-ghost" style="border: none; background: #373940; cursor: pointer;">Both of the above</button>
          </div>
        </div>
      </section>

      <!-- Quiz Test Section -->
      <section style="margin-bottom: 32px;">
        <h2 style="font-size: 32px; margin-bottom: 16px; color: var(--text);">Quiz Test</h2>
        <p style="color: var(--muted); margin-bottom: 24px; line-height: 1.8;">
          Test your knowledge with our certification quizzes!
        </p>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
          @foreach($certificationTracks->take(3) as $track)
            <a href="{{ $track->getQuizRoute() }}" class="btn-primary" style="text-decoration: none; text-align: center; padding: 16px;">
              {{ $track->title }} Quiz
            </a>
          @endforeach
        </div>
      </section>

      @if($certificationTracks->count() == 0)
      <p class="note">
        No certification tracks available yet. Check back soon!
      </p>
      @else
      <p class="note">
        Complete any track, pass the final quiz with 80% or higher, and earn your official ITLAB certificate. All certificates are free and shareable.
      </p>
      @endif
    </main>
  </div>

  <!-- Modal: Syllabus -->
  <div class="modal-backdrop" id="syllabusModal">
    <div class="modal">
      <button class="modal-close" data-close="syllabusModal">&times;</button>
      <h2 id="syllabusTitle">Certification Syllabus</h2>
      <p id="syllabusDescription">Here is what you will study inside the course:</p>
      <ul id="syllabusList">
        <li>Comprehensive curriculum covering all fundamentals</li>
        <li>Hands-on practical exercises</li>
        <li>Real-world projects</li>
        <li><strong>Final:</strong> Certification exam (80%+ to pass)</li>
      </ul>
      <div class="modal-footer">
        <strong>Tip:</strong> You can come back to these lessons anytime – access is lifetime after enrollment.
      </div>
    </div>
  </div>

  <!-- Modal: Enroll / Purchase -->
  <div class="modal-backdrop" id="enrollModal">
    <div class="modal">
      <button class="modal-close" data-close="enrollModal">&times;</button>
      <h2>Enroll in Modern JavaScript Developer</h2>
      <p>
        Complete the form below to simulate enrollment. This is a demo checkout – no real payment will be processed.
      </p>

      <form class="modal-form">
        <label for="enroll-name">Full name</label>
        <input id="enroll-name" type="text" placeholder="Your name" required>

        <label for="enroll-email">Email address</label>
        <input id="enroll-email" type="email" placeholder="you@example.com" required>

        <label for="enroll-method">Payment method</label>
        <select id="enroll-method">
          <option>Credit / Debit Card</option>
          <option>PayPal</option>
          <option>Student voucher</option>
        </select>

        <button type="button" class="btn-confirm" id="btnConfirm">
          Confirm enrollment (demo)
        </button>
      </form>

      <div class="modal-footer" id="enrollMessage">
        Price: <strong>$120 USD</strong> – demo only, no real charge.
      </div>
    </div>
  </div>

  @push('scripts')
  <script src="{{ asset('js/sidebar.js') }}"></script>
  <script>
    const syllabusModal = document.getElementById('syllabusModal');
    const syllabusTitle = document.getElementById('syllabusTitle');
    const syllabusDescription = document.getElementById('syllabusDescription');
    const syllabusList = document.getElementById('syllabusList');

    // Track data for syllabus modal
    const trackData = {
      @foreach($certificationTracks as $track)
      '{{ $track->slug }}': {
        title: '{{ $track->title }} Certification Syllabus',
        description: '{{ $track->description ?? "Here is what you will study in this track:" }}',
        lessons: [
          @foreach($track->lessons as $lesson)
          '{{ $lesson->title }}',
          @endforeach
        ],
        labs: {{ $track->labs->count() }},
        quizzes: {{ $track->quizzes->count() }}
      },
      @endforeach
    };

    // Open explanation modal
    document.querySelectorAll('[data-syllabus]').forEach(function(btn){
      btn.addEventListener('click', function(e){
        e.preventDefault();
        const trackSlug = this.getAttribute('data-syllabus');
        const track = trackData[trackSlug];
        
        if (track) {
          syllabusTitle.textContent = track.title;
          syllabusDescription.textContent = track.description;
          
          let html = '';
          if (track.lessons.length > 0) {
            track.lessons.forEach(function(lesson, index) {
              html += '<li><strong>Lesson ' + (index + 1) + ':</strong> ' + lesson + '</li>';
            });
          } else {
            html += '<li>Comprehensive curriculum covering all fundamentals</li>';
            html += '<li>Hands-on practical exercises</li>';
            html += '<li>Real-world projects</li>';
          }
          
          if (track.labs > 0) {
            html += '<li><strong>Labs:</strong> ' + track.labs + ' hands-on labs</li>';
          }
          if (track.quizzes > 0) {
            html += '<li><strong>Quizzes:</strong> ' + track.quizzes + ' certification quiz' + (track.quizzes > 1 ? 'zes' : '') + '</li>';
          }
          html += '<li><strong>Final:</strong> Certification exam (80%+ to pass)</li>';
          
          syllabusList.innerHTML = html;
          syllabusModal.classList.add('active');
        }
      });
    });

    // Close any modal when clicking X
    document.querySelectorAll('.modal-close').forEach(function(btn){
      btn.addEventListener('click', function(){
        const id = this.getAttribute('data-close');
        document.getElementById(id).classList.remove('active');
      });
    });

    // Close when clicking outside the modal
    syllabusModal.addEventListener('click', function(e){
      if (e.target === syllabusModal) {
        syllabusModal.classList.remove('active');
      }
    });
  </script>
@endpush
@endsection
