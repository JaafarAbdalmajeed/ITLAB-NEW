@extends('layouts.app')

@section('title', 'Roadmap 2025 — ITLAB')
@section('body-class', 'page-roadmap')

@section('content')
  <main class="page-wrapper">
    <header class="hero" style="margin-bottom:22px;">
      <h1>Roadmap 2025</h1>
      <p style="color:#9ca3af; max-width:720px;">Planned features and improvements for ITLAB in 2025: authentication, user progress tracking, expanded labs, admin content management, and improved testing & CI.</p>
    </header>

    <section>
      <h2>Planned milestones</h2>
      <ul style="color:#9ca3af;">
        <li>Scaffold authentication and user profiles</li>
        <li>Admin UI for tracks/quizzes/labs</li>
        <li>Automated feature tests and CI</li>
        <li>Expanded cyber labs and challenges</li>
      </ul>
    </section>
  </main>
@endsection
