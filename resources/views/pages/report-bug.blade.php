@extends('layouts.app')

@section('title', 'Report a Bug — ITLAB')
@section('body-class', 'page-report-bug')

@section('content')
  <main class="page-wrapper">
    <header class="hero" style="margin-bottom:22px;">
      <h1>Report a Bug</h1>
      @if($page && $page->meta_description)
        <p style="color:#9ca3af; max-width:720px;">{!! $page->meta_description !!}</p>
      @else
        <p style="color:#9ca3af; max-width:720px;">Found an issue? Describe the steps to reproduce and any relevant screenshots. We'll investigate and fix it as soon as possible.</p>
      @endif
    </header>

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
    @elseif($page && $page->content)
      {{-- Fallback to old content if no sections --}}
      <section>
        <div style="color:#cbd5e1; line-height:1.7;">{!! $page->content !!}</div>
      </section>
    @else
      {{-- Default content if no page data --}}
      <section>
        <p style="color:#9ca3af;">Send bug reports to <code>support@example.com</code> or use the <a href="{{ route('pages.contact') }}" style="color: #04aa6d;">contact form</a>.</p>
      </section>
    @endif
  </main>
@endsection
