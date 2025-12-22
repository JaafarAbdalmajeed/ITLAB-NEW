@extends('layouts.app')

@section('title', $quiz->title . ' — ITLAB')
@section('body-class', 'page-quiz')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
@endpush

<div class="page-wrapper">
    <!-- Sidebar -->
    <x-sidebar 
      :currentTrack="$track" 
      currentPage="quiz"
    />

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-header">
            <h1>{{ $quiz->title }}</h1>
            <a href="{{ $track->getMainRoute() }}" class="back-link">
                <i class="fa-solid fa-arrow-left-long"></i>
                Back to {{ $track->title }}
            </a>
        </div>
        
        <p style="color: var(--muted); font-size: 18px; margin-bottom: 20px;">{{ $track->description ?? 'Test your understanding of ' . $track->title }}</p>
        <p style="color: var(--muted); font-size: 14px; margin-bottom: 30px;">
            Number of questions: <strong>{{ $quiz->questions->count() }}</strong>
        </p>

        @if(session('status') || session('success'))
            <div style="background: #d4edda; border: 1px solid #28a745; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <p style="margin: 0; color: #155724;">
                    <i class="fas fa-check-circle"></i> 
                    <strong>Success!</strong> {{ session('status') }}
                    @if(session('quiz_score'))
                        <br><small>Your score: <strong>{{ session('quiz_score') }}%</strong></small>
                    @endif
                </p>
            </div>
        @endif

        @if(!auth()->check())
            <div style="background: #fff3cd; border: 1px solid #ffc107; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <p style="margin: 0; color: #856404;">
                    <i class="fas fa-exclamation-triangle"></i> 
                    <strong>Note:</strong> You must be <a href="#" onclick="if(typeof window.openAuthModal === 'function') { window.openAuthModal(); return false; } else { window.location.href='{{ route('auth.login') }}'; return false; }" style="color: #856404; text-decoration: underline;">logged in</a> to submit your answers and save your results.
                </p>
            </div>
        @endif

        @if(session('error'))
            <div style="background: #f8d7da; border: 1px solid #dc3545; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <p style="margin: 0; color: #721c24;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </p>
            </div>
        @endif

        @if($errors->any())
            <div style="background: #f8d7da; border: 1px solid #dc3545; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-right: 20px; color: #721c24;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="quiz-content" style="background: var(--card); padding: 30px; border-radius: 8px; border: 1px solid var(--border);">
        <form method="POST" action="{{ route('tracks.quizzes.results.store', [$track, $quiz]) }}" id="quizForm">
            @csrf
            @if(auth()->check())
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            @endif

            @foreach($quiz->questions as $index => $question)
                <div class="question-card" style="margin-bottom: 30px; padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px;">
                    <div class="question-header" style="margin-bottom: 15px;">
                        <span style="background: #04aa6d; color: #000; padding: 5px 12px; border-radius: 5px; font-weight: bold; margin-left: 10px;">
                            Question {{ $index + 1 }}
                        </span>
                        <span style="color: #666; font-size: 14px;">of {{ $quiz->questions->count() }}</span>
                    </div>
                    
                    <h3 style="margin: 0 0 20px 0; font-size: 18px; font-weight: 600; line-height: 1.6;">
                        {{ $question->question }}
                    </h3>

                    <div class="options" style="display: flex; flex-direction: column; gap: 12px;">
                        <label class="option-label" style="display: flex; align-items: center; padding: 12px; border: 2px solid #e0e0e0; border-radius: 5px; cursor: pointer; transition: all 0.2s;">
                            <input type="radio" name="answers[{{ $question->id }}]" value="a" required style="margin-left: 10px; width: 18px; height: 18px; cursor: pointer;">
                            <span style="flex: 1; margin-right: 10px;">{{ $question->option_a }}</span>
                        </label>

                        <label class="option-label" style="display: flex; align-items: center; padding: 12px; border: 2px solid #e0e0e0; border-radius: 5px; cursor: pointer; transition: all 0.2s;">
                            <input type="radio" name="answers[{{ $question->id }}]" value="b" required style="margin-left: 10px; width: 18px; height: 18px; cursor: pointer;">
                            <span style="flex: 1; margin-right: 10px;">{{ $question->option_b }}</span>
                        </label>

                        <label class="option-label" style="display: flex; align-items: center; padding: 12px; border: 2px solid #e0e0e0; border-radius: 5px; cursor: pointer; transition: all 0.2s;">
                            <input type="radio" name="answers[{{ $question->id }}]" value="c" required style="margin-left: 10px; width: 18px; height: 18px; cursor: pointer;">
                            <span style="flex: 1; margin-right: 10px;">{{ $question->option_c }}</span>
                        </label>
                    </div>
                </div>
            @endforeach

            <div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #e0e0e0;">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 18px;">
                    <i class="fas fa-paper-plane"></i> Submit Answers
                </button>
            </div>
        </form>
        </div>
    </main>
</div>

@push('scripts')
<script>
// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const quizForm = document.getElementById('quizForm');
    if (!quizForm) return;

    quizForm.addEventListener('submit', function(e) {
        const questions = {{ $quiz->questions->count() }};
        let answered = 0;
        
        @foreach($quiz->questions as $question)
            if (document.querySelector('input[name="answers[{{ $question->id }}]"]:checked')) {
                answered++;
            }
        @endforeach
        
        if (answered < questions) {
            e.preventDefault();
            alert('Please answer all questions (' + answered + ' of ' + questions + ')');
            return false;
        }

        // Check if user is logged in
        @if(!auth()->check())
            e.preventDefault();
            if (confirm('You must be logged in to submit the quiz. Would you like to log in now?')) {
                if (typeof window.openAuthModal === 'function') {
                    window.openAuthModal();
                } else {
                    window.location.href = '{{ route("auth.login") }}';
                }
            }
            return false;
        @endif
    });
});
</script>
<script src="{{ asset('js/sidebar.js') }}"></script>
@endpush
@endsection

