@extends('layouts.app')

@section('title', 'Beginner Path — ITLAB')
@section('body-class', 'page-beginner-path')

@section('content')
  <main class="page-wrapper">
    <header class="hero" style="margin-bottom:22px;">
      <h1>Beginner Path</h1>
      <p style="color:#9ca3af; max-width:720px;">A short guided path for new learners: HTML → CSS → JavaScript → basic projects → beginner labs.</p>
    </header>

    <section>
      <h3>Suggested order</h3>
      <ol style="color:#9ca3af;">
        <li><a href="{{ route('pages.html') }}">HTML</a></li>
        <li><a href="{{ route('pages.css') }}">CSS</a></li>
        <li><a href="{{ route('pages.js') }}">JavaScript</a></li>
        <li>Practice labs & quizzes</li>
      </ol>
    </section>
  </main>
@endsection
