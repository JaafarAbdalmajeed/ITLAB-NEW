@extends('layouts.app')

@section('title', 'Students — ITLAB')
@section('body-class', 'page-students')

@section('content')
  <main class="page-wrapper">
    <header class="hero" style="margin-bottom:22px;">
      <h1>Students</h1>
      <p style="color:#9ca3af; max-width:720px;">Resources and guidance for learners using ITLAB.
      Find recommended tracks, study tips, and how to get the most from the labs and quizzes.</p>
    </header>

    <section>
      <h2>Recommended first steps</h2>
      <ul style="color:#9ca3af;">
        <li>Complete the <a href="{{ route('pages.beginner-path') }}">Beginner Path</a>.</li>
        <li>Start with <a href="{{ route('pages.html') }}">HTML</a> and <a href="{{ route('pages.css') }}">CSS</a>.</li>
        <li>Practice in Labs and take quizzes to measure progress.</li>
      </ul>
    </section>
  </main>
@endsection
