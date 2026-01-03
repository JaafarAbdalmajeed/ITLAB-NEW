@extends('layouts.app')

@section('title', $lesson->title . ' — ' . $track->title . ' — ITLAB')
@section('body-class', 'page-' . $track->slug . '-lesson')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
<style>
    /* YouTube Video Container - Responsive */
    .youtube-video-container {
        margin: 20px 0;
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        border-radius: 8px;
        background: #000;
    }
    .youtube-video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    /* Lesson Sections */
    .lesson-section {
        margin: 30px 0;
        padding: 20px;
        background: var(--card-bg, #f9fafb);
        border: 1px solid var(--border, #e5e7eb);
        border-radius: 8px;
    }
    .lesson-section h3 {
        margin-top: 0;
        margin-bottom: 15px;
        color: var(--text);
    }
    .lesson-section pre {
        margin: 0;
        overflow-x: auto;
    }
    .lesson-section code {
        font-family: 'Courier New', monospace;
        font-size: 14px;
    }

    /* Code Editor */
    .code-editor-container {
        margin: 20px 0;
        border: 1px solid var(--border, #e5e7eb);
        border-radius: 8px;
        overflow: hidden;
        background: var(--card-bg, #fff);
    }
    .code-editor-header {
        background: var(--card-bg, #f9fafb);
        padding: 10px 15px;
        border-bottom: 1px solid var(--border, #e5e7eb);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .code-editor-header h3 {
        margin: 0;
        color: var(--text);
    }
    .code-editor-textarea {
        width: 100%;
        min-height: 300px;
        padding: 15px;
        font-family: 'Courier New', monospace;
        font-size: 14px;
        border: none;
        resize: vertical;
        background: #1e1e1e;
        color: #d4d4d4;
        box-sizing: border-box;
    }
    .code-editor-textarea:focus {
        outline: none;
    }
    .code-editor-output {
        background: #1e1e1e;
        color: #d4d4d4;
        padding: 15px;
        min-height: 100px;
        font-family: 'Courier New', monospace;
        font-size: 14px;
        border-top: 1px solid var(--border, #e5e7eb);
    }
    .run-code-btn {
        background: #04aa6d;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.2s;
    }
    .run-code-btn:hover {
        background: #038a5a;
    }

    /* Ensure text colors are correct based on page background */
    body[class*="page-cyber"] .lesson-section,
    body[class*="page-js"] .lesson-section,
    body[class*="page-home"] .lesson-section {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.1);
        color: #e5e7eb;
    }

    body[class*="page-cyber"] .lesson-section h3,
    body[class*="page-js"] .lesson-section h3,
    body[class*="page-home"] .lesson-section h3 {
        color: #ffffff;
    }

    body[class*="page-html"] .lesson-section,
    body[class*="page-css"] .lesson-section {
        background: rgba(0, 0, 0, 0.02);
        border-color: rgba(0, 0, 0, 0.1);
        color: #333;
    }

    body[class*="page-html"] .lesson-section h3,
    body[class*="page-css"] .lesson-section h3 {
        color: #000;
    }

    /* Ensure proper text colors for lesson pages */
    body[class*="page-cyber"][class*="-lesson"] .content-header h1,
    body[class*="page-js"][class*="-lesson"] .content-header h1,
    body[class*="page-home"][class*="-lesson"] .content-header h1 {
        color: #ffffff !important;
    }

    body[class*="page-cyber"][class*="-lesson"] .back-link,
    body[class*="page-js"][class*="-lesson"] .back-link,
    body[class*="page-home"][class*="-lesson"] .back-link {
        color: #d9d9e3 !important;
    }

    body[class*="page-html"][class*="-lesson"] .content-header h1,
    body[class*="page-css"][class*="-lesson"] .content-header h1 {
        color: #000000 !important;
    }

    body[class*="page-html"][class*="-lesson"] .back-link,
    body[class*="page-css"][class*="-lesson"] .back-link {
        color: #333333 !important;
    }

    /* Navigation buttons styling */
    body[class*="page-cyber"][class*="-lesson"] a[style*="background"],
    body[class*="page-js"][class*="-lesson"] a[style*="background"],
    body[class*="page-home"][class*="-lesson"] a[style*="background"] {
        background: rgba(255, 255, 255, 0.1) !important;
        border-color: rgba(255, 255, 255, 0.2) !important;
        color: #ffffff !important;
    }

    body[class*="page-html"][class*="-lesson"] a[style*="background"],
    body[class*="page-css"][class*="-lesson"] a[style*="background"] {
        background: #ffffff !important;
        border-color: #e5e7eb !important;
        color: #333333 !important;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .youtube-video-container {
            margin: 15px 0;
        }
        .lesson-section {
            padding: 15px;
            margin: 20px 0;
        }
        .code-editor-container {
            margin: 15px 0;
        }
        .code-editor-textarea {
            min-height: 200px;
            font-size: 12px;
        }
        .code-editor-header {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }
        .lesson-main-content,
        .lesson-videos-section {
            padding: 20px !important;
        }
    }
</style>
@endpush

<div class="page-wrapper">
    <!-- Sidebar -->
    <x-sidebar 
      :currentTrack="$track" 
      currentPage="tutorial"
    />

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-header">
            <div>
                <a href="{{ route('tracks.show', $track) }}" class="back-link" style="margin-bottom: 12px; display: inline-block;">
                    <i class="fa-solid fa-arrow-left-long"></i>
                    Back to {{ $track->title }}
                </a>
                <h1 id="lesson-{{ $lesson->id }}">{{ $lesson->title }}</h1>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lesson-main-content" style="background: var(--card-bg, #fff); border: 1px solid var(--border, #e5e7eb); border-radius: 8px; padding: 32px; margin-bottom: 32px;">
            <div style="font-size: 16px; line-height: 1.8; color: var(--text);">
                {!! $lesson->content !!}
            </div>
        </div>

        <!-- YouTube Videos -->
        @if($lesson->youtube_videos && count($lesson->youtube_videos) > 0)
            <div class="lesson-videos-section" style="background: var(--card-bg, #fff); border: 1px solid var(--border, #e5e7eb); border-radius: 8px; padding: 32px; margin-bottom: 32px;">
                <h2 style="margin-top: 0; margin-bottom: 20px; color: var(--text);">Video Tutorials</h2>
                @foreach($lesson->youtube_videos as $video)
                    @php
                        // Extract YouTube video ID from URL
                        $videoId = null;
                        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video['url'] ?? '', $matches)) {
                            $videoId = $matches[1];
                        }
                    @endphp
                    @if($videoId)
                        <div style="margin-bottom: 30px;">
                            @if(!empty($video['title']))
                                <h3 style="margin-bottom: 10px; color: var(--text);">{{ $video['title'] }}</h3>
                            @endif
                            <div class="youtube-video-container">
                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        <!-- Lesson Sections -->
        @if($lesson->sections && count($lesson->sections) > 0)
            @foreach($lesson->sections as $index => $section)
                <div class="lesson-section">
                    @if(!empty($section['title']))
                        <h3>{{ $section['title'] }}</h3>
                    @endif
                    @if(!empty($section['content']))
                        <div style="margin-bottom: 15px;">
                            {!! $section['content'] !!}
                        </div>
                    @endif
                    @if(!empty($section['code']))
                        <div style="background: #1e1e1e; color: #d4d4d4; padding: 15px; border-radius: 5px; margin-top: 15px; overflow-x: auto;">
                            <pre style="margin: 0;"><code style="color: #d4d4d4;">{{ htmlspecialchars($section['code']) }}</code></pre>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif

        <!-- Code Editor (Try It Yourself) -->
        @if($lesson->enable_code_editor)
            <div class="code-editor-container" style="background: var(--card-bg, #fff); border: 1px solid var(--border, #e5e7eb); border-radius: 8px; margin-bottom: 32px;">
                <div class="code-editor-header">
                    <h3 style="margin: 0;">Try It Yourself</h3>
                    <button class="run-code-btn" onclick="runCode()">
                        <i class="fas fa-play"></i> Run Code
                    </button>
                </div>
                <textarea id="code-editor" class="code-editor-textarea" placeholder="Write your code here...">{{ $lesson->sections && count($lesson->sections) > 0 && !empty($lesson->sections[0]['code']) ? $lesson->sections[0]['code'] : '' }}</textarea>
                <div class="code-editor-output" id="code-output">
                    <div style="color: #888;">Output will appear here...</div>
                </div>
            </div>
        @endif

        <!-- Lesson Completion & Navigation -->
        @php
            $allLessons = $track->lessons()->orderBy('order')->get();
            $currentIndex = $allLessons->search(function($l) use ($lesson) {
                return $l->id === $lesson->id;
            });
            $prevLesson = $currentIndex > 0 ? $allLessons[$currentIndex - 1] : null;
            $nextLesson = $currentIndex < $allLessons->count() - 1 ? $allLessons[$currentIndex + 1] : null;
        @endphp

        <!-- Mark as Complete Button -->
        @auth
        <div style="padding: 24px; background: var(--card-bg, #fff); border: 1px solid var(--border, #e5e7eb); border-radius: 8px; margin-bottom: 24px; text-align: center;">
            @if($isCompleted)
                <div style="display: flex; align-items: center; justify-content: center; gap: 10px; color: #10b981; font-weight: 600;">
                    <i class="fa-solid fa-check-circle" style="font-size: 20px;"></i>
                    <span>Lesson Completed!</span>
                </div>
            @else
                <button id="mark-complete-btn" onclick="markLessonComplete()" 
                        style="padding: 12px 32px; background: #04aa6d; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                    <i class="fa-solid fa-check"></i> Mark as Complete
                </button>
            @endif
        </div>
        @endauth

        <!-- Navigation between lessons -->
        <div style="display: flex; justify-content: space-between; gap: 16px; padding-top: 24px; border-top: 1px solid var(--border, #e5e7eb);">
            @if($prevLesson)
                <a href="{{ route('tracks.lessons.show', [$track, $prevLesson]) }}" 
                   style="display: flex; align-items: center; gap: 8px; padding: 12px 20px; background: var(--card-bg, #fff); border: 1px solid var(--border, #e5e7eb); border-radius: 8px; text-decoration: none; color: var(--text); transition: all 0.2s;">
                    <i class="fa-solid fa-arrow-left"></i>
                    <div>
                        <div style="font-size: 12px; color: var(--muted);">Previous</div>
                        <div style="font-weight: 500;">{{ $prevLesson->title }}</div>
                    </div>
                </a>
            @else
                <div></div>
            @endif

            @if($nextLesson)
                <a href="{{ route('tracks.lessons.show', [$track, $nextLesson]) }}" 
                   id="next-lesson-btn"
                   style="display: flex; align-items: center; gap: 8px; padding: 12px 20px; background: #04aa6d; color: white; border: none; border-radius: 8px; text-decoration: none; transition: all 0.2s; margin-left: auto; font-weight: 600;">
                    <div style="text-align: right;">
                        <div style="font-size: 12px; opacity: 0.9;">Next Lesson</div>
                        <div style="font-weight: 500;">{{ $nextLesson->title }}</div>
                    </div>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            @else
                <div style="display: flex; align-items: center; gap: 8px; padding: 12px 20px; background: #667eea; color: white; border-radius: 8px; margin-left: auto; font-weight: 600;">
                    <i class="fa-solid fa-trophy"></i>
                    <span>Track Completed!</span>
                </div>
            @endif
        </div>
    </main>
</div>

@push('scripts')
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/sidebar.js') }}"></script>
@auth
<script>
function markLessonComplete() {
    const btn = document.getElementById('mark-complete-btn');
    if (!btn) return;

    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

    fetch('{{ route('tracks.lessons.complete', [$track, $lesson]) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            btn.parentElement.innerHTML = `
                <div style="display: flex; align-items: center; justify-content: center; gap: 10px; color: #10b981; font-weight: 600;">
                    <i class="fa-solid fa-check-circle" style="font-size: 20px;"></i>
                    <span>Lesson Completed!</span>
                </div>
            `;
            
            // Show success message
            const successMsg = document.createElement('div');
            successMsg.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #10b981; color: white; padding: 15px 20px; border-radius: 8px; z-index: 9999; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
            successMsg.innerHTML = '<i class="fa-solid fa-check"></i> Lesson marked as complete!';
            document.body.appendChild(successMsg);
            
            setTimeout(() => {
                successMsg.remove();
            }, 3000);
        } else {
            alert(data.message || 'Error marking lesson as complete');
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Mark as Complete';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-check"></i> Mark as Complete';
    });
}
</script>
@endauth
@if($lesson->enable_code_editor)
<script>
function runCode() {
    const code = document.getElementById('code-editor').value;
    const output = document.getElementById('code-output');
    
    if (!code.trim()) {
        output.innerHTML = '<div style="color: #ffc107; padding: 10px; background: rgba(255, 193, 7, 0.1); border-radius: 5px;">⚠ Please write some code first</div>';
        return;
    }
    
    // Clear previous output
    output.innerHTML = '<div style="color: #888; padding: 10px;">Running code...</div>';
    
    // Create a new iframe for safe execution
    const iframe = document.createElement('iframe');
    iframe.style.cssText = 'width: 100%; height: 400px; border: none; background: white;';
    iframe.setAttribute('sandbox', 'allow-scripts allow-same-origin');
    
    try {
        const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
        
        // Write HTML structure with user code
        iframeDoc.open();
        iframeDoc.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <style>
                    body { 
                        margin: 0; 
                        padding: 15px; 
                        font-family: Arial, sans-serif; 
                        background: white;
                        color: #333;
                    }
                </style>
            </head>
            <body>
                <script>
                    // Execute user code
                    try {
                        ${code.replace(/<\/script>/g, '<\\/script>')}
                    } catch (error) {
                        document.body.innerHTML = '<div style="color: red; padding: 10px; background: #ffe0e0; border-radius: 5px; margin: 10px 0;">Error: ' + error.message + '</div>';
                    }
                <\/script>
            </body>
            </html>
        `);
        iframeDoc.close();
        
        // Show result
        setTimeout(() => {
            output.innerHTML = '';
            const successMsg = document.createElement('div');
            successMsg.style.cssText = 'color: #4caf50; padding: 10px; background: rgba(76, 175, 80, 0.1); border-radius: 5px; margin-bottom: 10px; font-weight: 600;';
            successMsg.textContent = '✓ Code executed successfully!';
            output.appendChild(successMsg);
            output.appendChild(iframe);
        }, 200);
        
    } catch (error) {
        output.innerHTML = '<div style="color: #f44336; padding: 10px; background: rgba(244, 67, 54, 0.1); border-radius: 5px;">✗ Error: ' + error.message + '</div>';
    }
}

// Allow Ctrl+Enter to run code
document.addEventListener('DOMContentLoaded', function() {
    const codeEditor = document.getElementById('code-editor');
    if (codeEditor) {
        codeEditor.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                e.preventDefault();
                runCode();
            }
        });
    }
});
</script>
@endif
@endpush
@endsection
