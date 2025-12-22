@extends('layouts.app')

@section('title', $track->title . ' Reference — ITLAB')
@section('body-class', 'page-reference')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
@endpush

<div class="page-wrapper">
    <!-- Sidebar -->
    <x-sidebar 
      :currentTrack="$track" 
      currentPage="reference"
    />

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-header">
            <h1>{{ $track->title }} Reference</h1>
            <a href="{{ $track->getMainRoute() }}" class="back-link">
                <i class="fa-solid fa-arrow-left-long"></i>
                Back to {{ $track->title }}
            </a>
        </div>

        <div class="reference-content" style="background: var(--card); padding: 30px; border-radius: 8px; border: 1px solid var(--border);">
        @if($track->reference_content)
            <div style="line-height: 1.8; font-size: 16px;">
                {!! $track->reference_content !!}
            </div>
        @else
            <div style="text-align: center; padding: 60px 20px; color: #999;">
                <p style="font-size: 18px; margin-bottom: 10px;">No Reference content available at the moment</p>
                <p style="font-size: 14px;">Content will be added soon</p>
            </div>
        @endif
        </div>
    </main>
</div>

@push('scripts')
<script src="{{ asset('js/sidebar.js') }}"></script>
@endpush
@endsection

