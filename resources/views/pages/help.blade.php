@extends('layouts.app')

@section('title', 'Help Center — ITLAB')
@section('body-class', 'page-help')

@section('content')
  <main class="page-wrapper">
    <header class="hero" style="margin-bottom:22px;">
      <h1>Help Center</h1>
      <p style="color:#9ca3af; max-width:720px;">Common questions and guides to use ITLAB. If you can't find an answer here, please contact us.</p>
    </header>

    <section>
      <h3>Common topics</h3>
      <ul style="color:#9ca3af;">
        <li>Getting started with a track</li>
        <li>How to take quizzes and view results</li>
        <li>Using the labs</li>
      </ul>
    </section>
  </main>
@endsection
