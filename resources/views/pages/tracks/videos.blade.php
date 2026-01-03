@extends('layouts.app')

@section('title', $track->title . ' Videos — ITLAB')
@section('body-class', 'page-videos')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
@endpush

<div class="page-wrapper">
    <!-- Sidebar -->
    <x-sidebar 
      :currentTrack="$track" 
      currentPage="videos"
    />

    <main class="main-content" style="background: #0f0f0f; min-height: 100vh; padding: 30px;">
        <div class="content-header mb-5" dir="rtl">
            <h1 style="color: #00ffaa; font-size: 2.2rem; font-weight: bold;">
                <i class="fa-solid fa-play-circle me-2"></i> فيديوهات مسار {{ $track->title }}
            </h1>
            <a href="{{ $track->getMainRoute() }}" class="back-link">
                <i class="fa-solid fa-arrow-right ms-2"></i> عودة إلى قائمة الدروس
            </a>
        </div>

        <div class="row g-4" dir="rtl">
            @php
                // مصفوفة الفيديوهات - يمكنك تغيير الـ ID لكل فيديو من يوتيوب
                $trackVideos = [
                    ['t' => 'الدرس الأول: مقدمة في ' . $track->title, 'id' => 'PLDoPjvoNmBAwXDFEGst8SUHZuVnS866No', 'c' => '#00ffaa'],
                    ['t' => 'الدرس الثاني: التثبيت والبيئة البرمجية', 'id' => 'abc1', 'c' => '#61dafb'],
                    ['t' => 'الدرس الثالث: المفاهيم الأساسية والأدوات', 'id' => 'abc2', 'c' => '#ff5252'],
                    ['t' => 'الدرس الرابع: التطبيق العملي الأول', 'id' => 'abc3', 'c' => '#ffeb3b'],
                    ['t' => 'الدرس الخامس: نصائح متقدمة وحل المشكلات', 'id' => 'abc4', 'c' => '#e040fb'],
                ];
            @endphp

            @foreach($trackVideos as $index => $video)
            <div class="col-12 mb-4">
                <div class="video-container-card shadow-lg" style="border-right: 12px solid {{ $video['c'] }}; background: #1a1a1a; border-radius: 20px; overflow: hidden; border: 1px solid #333;">
                    <div class="row g-0">
                        <div class="col-lg-7">
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/{{ $video['id'] }}" 
                                        title="{{ $video['t'] }}" 
                                        frameborder="0" 
                                        allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                        <div class="col-lg-5 p-4 d-flex flex-column justify-content-center text-end">
                            <h3 style="color: {{ $video['c'] }}; font-weight: bold; margin-bottom: 15px;">{{ $video['t'] }}</h3>
                            <p style="color: #bbb; line-height: 1.6;">شاهد هذا الدرس لتتعلم كيفية تطبيق المهارات العملية لهذا المسار خطوة بخطوة مع المدرب.</p>
                            
                            <div class="mt-4 d-flex align-items-center gap-2 justify-content-end">
                                <span class="badge" style="background: {{ $video['c'] }}; color: #000; padding: 8px 15px;">الفيديو #{{ $index + 1 }}</span>
                                <a href="https://youtube.com/watch?v={{ $video['id'] }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fab fa-youtube text-danger ms-1"></i> يوتيوب
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </main>
</div>

<style>
    .video-container-card { transition: 0.3s ease; }
    .video-container-card:hover { transform: scale(1.005); border-color: rgba(255,255,255,0.2) !important; }
    .back-link { color: #888; text-decoration: none; font-size: 0.9rem; }
    .back-link:hover { color: #fff; }
</style>

@push('scripts')
<script src="{{ asset('js/sidebar.js') }}"></script>
@endpush
@endsection