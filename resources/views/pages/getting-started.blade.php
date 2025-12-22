@extends('layouts.app')

@section('title', 'Getting Started — ITLAB')
@section('body-class', 'page-getting-started')

@section('content')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    :root {
      --bg: #050814;
      --card: #111827;
      --muted: #9ca3af;
      --accent: #00c26e;
      --accent-soft: #04e08a;
      --border: #1f2937;
      --text: #e5e7eb;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      background: radial-gradient(circle at top, #111827 0, #020409 55%, #000 100%);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .page-wrapper {
      max-width: 1100px;
      margin: 32px auto 40px;
      padding: 0 20px;
    }

    /* Top bar */
    .top-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .logo-square {
      background: var(--accent);
      color: #020617;
      padding: 6px 10px;
      border-radius: 6px;
      font-weight: 700;
      letter-spacing: 0.04em;
    }

    .logo-text {
      font-weight: 700;
      font-size: 20px;
    }

    .back-link {
      text-decoration: none;
      color: var(--muted);
      font-size: 14px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 12px;
      border-radius: 999px;
      border: 1px solid #374151;
      background: rgba(15, 23, 42, 0.7);
      transition: 0.15s ease;
    }

    .back-link:hover {
      color: var(--text);
      border-color: var(--accent);
    }

    /* Hero */
    .hero {
      background: linear-gradient(135deg, #111827, #020617);
      border-radius: 18px;
      padding: 28px 24px 24px;
      border: 1px solid var(--border);
      box-shadow: 0 18px 40px rgba(0, 0, 0, 0.6);
      margin-bottom: 26px;
    }

    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 4px 10px;
      border-radius: 999px;
      background: rgba(15, 118, 110, 0.18);
      color: #f31515;
      font-size: 12px;
      margin-bottom: 10px;
    }

    .hero h1 {
      font-size: 26px;
      margin-bottom: 10px;
    }

    .hero p {
      max-width: 600px;
      color: var(--muted);
      line-height: 1.7;
      font-size: 14px;
    }

    /* Layout */
    .layout {
      display: grid;
      grid-template-columns: 2fr 1.3fr;
      gap: 22px;
      margin-top: 22px;
    }

    /* Cards */
    .track-card {
      background: var(--card);
      border-radius: 16px;
      padding: 18px 18px 16px;
      border: 1px solid var(--border);
      margin-bottom: 14px;
      position: relative;
      overflow: hidden;
    }

    .track-card::before {
      content: "";
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at top left, rgba(16, 185, 129, 0.16), transparent 60%);
      opacity: 0.7;
      pointer-events: none;
    }

    .track-tag {
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.15em;
      color: #a5b4fc;
      margin-bottom: 6px;
    }

    .track-card h2 {
      font-size: 18px;
      margin-bottom: 6px;
    }

    .track-card p {
      font-size: 13px;
      color: var(--muted);
      margin-bottom: 10px;
      line-height: 1.6;
    }

    .track-list {
      margin-left: 16px;
      margin-bottom: 10px;
      font-size: 13px;
      color: #d1d5db;
    }

    .track-list li {
      margin-bottom: 4px;
    }

    .track-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 12px;
      color: var(--muted);
      margin-top: 6px;
    }

    .meta-pill {
      padding: 4px 9px;
      border-radius: 999px;
      background: rgba(15, 23, 42, 0.9);
      border: 1px solid #374151;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .track-btn {
      margin-top: 10px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      text-decoration: none;
      font-size: 13px;
      padding: 8px 14px;
      border-radius: 999px;
      border: none;
      cursor: pointer;
      background: linear-gradient(135deg, var(--accent), var(--accent-soft));
      color: #020617;
      font-weight: 600;
      box-shadow: 0 10px 22px rgba(0,0,0,0.6);
      transition: 0.15s ease;
    }

    .track-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 16px 32px rgba(0,0,0,0.7);
    }

    /* Right column: steps */
    .steps-card {
      background: var(--card);
      border-radius: 16px;
      padding: 18px;
      border: 1px solid var(--border);
      margin-bottom: 16px;
    }

    .steps-card h3 {
      font-size: 16px;
      margin-bottom: 10px;
    }

    .step-item {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      margin-bottom: 10px;
      font-size: 13px;
      color: var(--muted);
    }

    .step-number {
      width: 22px;
      height: 22px;
      border-radius: 999px;
      background: #020617;
      border: 1px solid var(--accent);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
      color: var(--accent-soft);
      flex-shrink: 0;
      margin-top: 1px;
    }

    .step-item strong {
      color: var(--text);
    }

    .note-card {
      background: #020617;
      border-radius: 14px;
      padding: 14px 14px 12px;
      border: 1px dashed #374151;
      font-size: 12px;
      color: var(--muted);
      line-height: 1.6;
    }

    .note-card strong {
      color: var(--accent-soft);
    }

    /* Responsive */
    @media (max-width: 900px) {
      .layout {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 600px) {
      .page-wrapper {
        margin-top: 20px;
      }
      .hero h1 {
        font-size: 22px;
      }
      .begin-modal-content {
        width: 90%;
      }
    }
  </style>
@endpush

  <div class="page-wrapper">
    <div class="top-bar">
      <div class="logo">
        <span class="logo-square">IT</span>
        <span class="logo-text">LAB</span>
      </div>
      <a href="{{ route('home') }}" class="back-link">
        <i class="fa-solid fa-arrow-left-long"></i>
        Back to Home
      </a>
    </div>

    <section class="hero">
      <div class="hero-badge">
        <i class="fa-solid fa-compass"></i>
        <span>Not sure where to begin?</span>
      </div>
      <h1>Choose the best starting point for you.</h1>
      <p>
        ITLAB gives you more than random tutorials. Below is a clear path depending on your current level and your goal.
        Start with one track, stay consistent, and you’ll see real progress in a few weeks.
      </p>

      <div class="layout">
        <div>
          <!-- Track 1 -->
          <article class="track-card">
            <div class="track-tag">Best for absolute beginners</div>
            <h2>Web Foundations Track</h2>
            <p>
              If you've never coded before, start here. You’ll build real pages while learning the building blocks of the web.
            </p>
            <ul class="track-list">
              <li>HTML – Basic tags, structure, semantic layout</li>
              <li>CSS – Colors, fonts, layout, responsive design</li>
              <li>Mini Projects – Personal profile page, simple landing page</li>
            </ul>
            <div class="track-meta">
              <span class="meta-pill"><i class="fa-regular fa-clock"></i> 2–4 weeks</span>
              <span>After this: you can build clean static websites.</span>
            </div>
            <a href="{{ route('pages.html') }}" class="track-btn">
              Start with HTML
              <i class="fa-solid fa-arrow-right"></i>
            </a>
          </article>

          <!-- Track 2 -->
          <article class="track-card">
            <div class="track-tag">When you know the basics</div>
            <h2>JavaScript & Logic Track</h2>
            <p>
              Already comfortable with HTML/CSS? This track focuses on programming logic and interactivity.
            </p>
            <ul class="track-list">
              <li>Variables, conditions, functions, loops</li>
              <li>DOM basics – reacting to user input</li>
              <li>Mini Projects – counter, quiz app, simple to-do list</li>
            </ul>
            <div class="track-meta">
              <span class="meta-pill"><i class="fa-regular fa-clock"></i> 3–5 weeks</span>
              <span>After this: you can build interactive pages.</span>
            </div>
            <a href="{{ route('pages.js') }}" class="track-btn">
              Go to JavaScript
              <i class="fa-solid fa-arrow-right"></i>
            </a>
          </article>

          <!-- Track 3 -->
          <article class="track-card">
            <div class="track-tag">For security-focused learners</div>
            <h2>Cyber Security Starter Track</h2>
            <p>
              If your goal is cyber security or ethical hacking, start with these fundamentals after you know basic web.
            </p>
            <ul class="track-list">
              <li>Network basics – IP, ports, protocols</li>
              <li>Web app security – common vulnerabilities</li>
              <li>Hands-on labs inside ITLAB</li>
            </ul>
            <div class="track-meta">
              <span class="meta-pill"><i class="fa-regular fa-clock"></i> 4–6 weeks</span>
              <span>After this: ready for deeper security labs.</span>
            </div>
            <a href="{{ route('pages.cyber-network') }}" class="track-btn">
              View Security Labs
              <i class="fa-solid fa-arrow-right"></i>
            </a>
          </article>
        </div>

        <!-- RIGHT COLUMN -->
        <div>
          <div class="steps-card">
            <h3>How to use this page</h3>
            <div class="step-item">
              <div class="step-number">1</div>
              <div>
                <strong>Pick one track only.</strong><br />
                Don’t try to follow everything at once. Choose the track that matches your level.
              </div>
            </div>
            <div class="step-item">
              <div class="step-number">2</div>
              <div>
                <strong>Commit to a small daily goal.</strong><br />
                30–60 minutes a day is more powerful than 5 hours once a week.
              </div>
            </div>
            <div class="step-item">
              <div class="step-number">3</div>
              <div>
                <strong>Build, don’t just watch.</strong><br />
                Re-build the examples, then try to change them and create your own mini projects.
              </div>
            </div>
            <div class="step-item">
              <div class="step-number">4</div>
              <div>
                <strong>Ask questions.</strong><br />
                Use communities, Discord, or your peers to ask when you’re stuck. Struggle is normal.
              </div>
            </div>
          </div>

          <div class="note-card">
            <strong>Tip:</strong> If you ever feel lost, go back to the <em>Web Foundations Track</em>.
            A strong base in HTML, CSS, and basic JavaScript will make every other topic —
            frameworks, back-end, or security — much easier to understand.
          </div>
        </div>
      </div>
    </section>
  </div>
@push('scripts')
<!-- page-specific scripts could go here -->
@endpush

@endsection
