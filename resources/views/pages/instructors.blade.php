@extends('layouts.app')

@section('title', 'Instructors — ITLAB')
@section('body-class', 'page-instructors')

@section('content')
  <main class="page-wrapper">
    <header class="hero" style="margin-bottom:22px;">
      <h1>For Instructors</h1>
      <p style="color:#9ca3af; max-width:720px;">Guidance for teachers and instructors who want to use ITLAB with their students. Use the tracks and labs as structured exercises and customize assignments to fit your course.</p>
    </header>

    <section>
      <h2>Use cases</h2>
      <p style="color:#9ca3af;">ITLAB is suitable for workshops, introductory modules, and self-study assignments. Contact us via the <a href="{{ route('pages.contact') }}">Contact</a> page to discuss bulk access or instructor resources.</p>
    </section>
  </main>
@endsection
