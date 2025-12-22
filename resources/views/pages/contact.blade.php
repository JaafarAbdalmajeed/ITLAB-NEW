@extends('layouts.app')

@section('title', 'Contact — ITLAB')
@section('body-class', 'page-contact')

@section('content')
  <main class="page-wrapper">
    <header class="hero" style="margin-bottom:22px;">
      <h1>Contact Us</h1>
      <p style="color:#9ca3af; max-width:720px;">Need help, partnership inquiries, or want to report content issues? Send us a message and we’ll get back to you.</p>
    </header>

    <section>
      <form action="{{ route('pages.contact') }}" method="post" style="max-width:640px;">
        @csrf
        <label for="name">Name</label><br />
        <input id="name" name="name" type="text" style="width:100%; padding:8px; margin-bottom:8px;" required>
        <label for="email">Email</label><br />
        <input id="email" name="email" type="email" style="width:100%; padding:8px; margin-bottom:8px;" required>
        <label for="message">Message</label><br />
        <textarea id="message" name="message" rows="6" style="width:100%; padding:8px; margin-bottom:8px;" required></textarea>
        <button type="submit" class="btn-primary">Send Message</button>
      </form>

      @if(session('status'))
        <p style="color:var(--accent); margin-top:12px;">{{ session('status') }}</p>
      @endif
    </section>

    {{-- Display page sections if they exist --}}
    @if($page && $page->publishedSections->count() > 0)
      @foreach($page->publishedSections as $section)
        <section class="page-section page-section-{{ $section->section_type }}" style="margin-top: 40px; margin-bottom: 40px;">
          @if($section->title)
            <h2 style="margin-bottom: 15px; font-size: 24px; color: #fff;">{{ $section->title }}</h2>
          @endif
          @if($section->subtitle)
            <p style="color:#9ca3af; margin-bottom: 20px; font-size: 16px;">{!! $section->subtitle !!}</p>
          @endif
          @if($section->content)
            <div style="color:#cbd5e1; line-height:1.7;">{!! $section->content !!}</div>
          @endif
        </section>
      @endforeach
    @endif
  </main>
@endsection
