@extends('layouts.app')

@section('title', $page->title . ' — ITLAB')
@section('body-class', 'page-static')

@section('content')
  <main class="page-wrapper">
    <header class="hero" style="margin-bottom:22px;">
      <h1>{{ $page->title }}</h1>
      @if($page->meta_description)
        <p style="color:#9ca3af; max-width:720px;">{!! $page->meta_description !!}</p>
      @endif
    </header>

    @if($page->publishedSections->count() > 0)
      {{-- Display sections if they exist --}}
      @foreach($page->publishedSections as $section)
        <section class="page-section page-section-{{ $section->section_type }}" style="margin-bottom: 40px;">
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
    @else
      {{-- Fallback to old content if no sections --}}
      @if($page->content)
        <section>
          <div style="color:#cbd5e1; line-height:1.7;">{!! $page->content !!}</div>
        </section>
      @endif
    @endif
  </main>
@endsection
