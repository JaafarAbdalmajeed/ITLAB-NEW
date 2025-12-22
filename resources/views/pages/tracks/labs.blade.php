@extends('layouts.app')

@section('title', $track->title . ' Labs — ITLAB')
@section('body-class', 'page-labs')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
@endpush

<div class="page-wrapper">
    <!-- Sidebar -->
    <x-sidebar 
      :currentTrack="$track" 
      currentPage="labs"
    />

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-header">
            <h1>{{ $track->title }} Labs</h1>
            <a href="{{ $track->getMainRoute() }}" class="back-link">
                <i class="fa-solid fa-arrow-left-long"></i>
                Back to {{ $track->title }}
            </a>
        </div>

        <p style="color: var(--muted); font-size: 18px; margin-bottom: 30px;">{{ $track->description ?? 'Hands-on labs and practical exercises.' }}</p>

        <div class="labs-content" style="background: var(--card); padding: 30px; border-radius: 8px; border: 1px solid var(--border);">
            @if($track->labs && $track->labs->count() > 0)
                <div class="labs-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px;">
                    @foreach($track->labs as $lab)
                        <div class="lab-card" style="border: 1px solid var(--border); border-radius: 8px; padding: 20px; transition: transform 0.2s, box-shadow 0.2s; background: var(--bg);">
                            <h3 style="margin: 0 0 15px 0; font-size: 20px; font-weight: 600; color: var(--accent);">
                                {{ $lab->title }}
                            </h3>
                            <p style="margin: 0 0 20px 0; color: var(--muted); line-height: 1.6; font-size: 14px;">
                                {{ \Illuminate\Support\Str::limit($lab->scenario, 200) }}
                            </p>
                            <div style="display: flex; gap: 10px;">
                                <a href="{{ route('tracks.labs.show', [$track, $lab]) }}" class="btn btn-primary" style="flex: 1; text-align: center; padding: 12px 24px; border-radius: 5px; text-decoration: none; background: var(--accent); color: #000; font-weight: 600;">
                                    <i class="fas fa-flask"></i> Open Lab
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 60px 20px; color: var(--muted);">
                    <i class="fas fa-flask" style="font-size: 64px; margin-bottom: 20px; opacity: 0.3;"></i>
                    <p style="font-size: 18px; margin-bottom: 10px;">No labs available at the moment</p>
                    <p style="font-size: 14px;">Labs will be added soon</p>
                </div>
            @endif
        </div>
    </main>
</div>

@push('scripts')
<script src="{{ asset('js/sidebar.js') }}"></script>
@endpush
@endsection
