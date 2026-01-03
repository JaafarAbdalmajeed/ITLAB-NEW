@extends('admin.layout')

@section('title', 'Edit Track')
@section('page-title', 'Edit Track: ' . $track->title)

@push('styles')
<style>
    .tabs-container {
        margin-bottom: 20px;
    }

    .tabs-nav {
        display: flex;
        border-bottom: 2px solid var(--admin-border);
        margin-bottom: 20px;
    }

    .tab-button {
        padding: 12px 24px;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        color: #666;
        transition: all 0.3s;
        position: relative;
        top: 2px;
    }

    .tab-button:hover {
        color: var(--admin-secondary);
        background: rgba(4, 170, 109, 0.05);
    }

    .tab-button.active {
        color: var(--admin-secondary);
        border-bottom-color: var(--admin-secondary);
        font-weight: 600;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .quiz-item {
        border: 1px solid var(--admin-border);
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        background: #fafafa;
    }

    .quiz-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .quiz-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--admin-text);
    }

    .quiz-actions {
        display: flex;
        gap: 10px;
    }

    .questions-list {
        margin-top: 15px;
    }

    .question-item {
        background: white;
        border: 1px solid var(--admin-border);
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 10px;
    }

    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 10px;
    }

    .question-text {
        font-weight: 500;
        margin-bottom: 10px;
    }

    .question-options {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-top: 10px;
    }

    .option-item {
        padding: 8px;
        background: #f5f5f5;
        border-radius: 4px;
        font-size: 13px;
    }

    .correct-answer {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="admin-card">
    <!-- Tabs Navigation -->
    <div class="tabs-container">
        <div class="tabs-nav">
            <button type="button" class="tab-button active" onclick="switchTab('basic')">
                <i class="fas fa-info-circle"></i> Basic Information
            </button>
            <button type="button" class="tab-button" onclick="switchTab('quizzes')">
                <i class="fas fa-question-circle"></i> Quizzes
            </button>
        </div>
    </div>

    <!-- Tab 1: Basic Information -->
    <div id="tab-basic" class="tab-content active">
        <form action="{{ route('admin.tracks.update', $track) }}" method="POST" id="track-form">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="slug">Slug *</label>
                <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug', $track->slug) }}" required>
            </div>

            <div class="form-group">
                <label for="title">Title *</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $track->title) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $track->description) }}</textarea>
            </div>

            <hr style="margin: 30px 0; border: 1px solid var(--admin-border);">

            <h3 style="margin-bottom: 20px;">Main Page Content</h3>
            
            <div class="form-group">
                <label for="hero_content">Hero Content</label>
                <textarea id="hero_content" name="hero_content" class="form-control" rows="6">{{ old('hero_content', $track->hero_content) }}</textarea>
                <small style="color: #666;">Content that appears on the track's main page</small>
            </div>

            <div class="form-group">
                <label for="hero_button_text">Hero Button Text</label>
                <input type="text" id="hero_button_text" name="hero_button_text" class="form-control" value="{{ old('hero_button_text', $track->hero_button_text) }}">
            </div>

            <div class="form-group">
                <label for="hero_button_link">Hero Button Link</label>
                <input type="text" id="hero_button_link" name="hero_button_link" class="form-control" value="{{ old('hero_button_link', $track->hero_button_link) }}">
            </div>

            <div class="form-group">
                <label for="example_code">Example Code</label>
                <textarea id="example_code" name="example_code" class="form-control" rows="10">{{ old('example_code', $track->example_code) }}</textarea>
                <small style="color: #666;">Example code that appears on the main page</small>
            </div>

            <hr style="margin: 30px 0; border: 1px solid var(--admin-border);">

            <h3 style="margin-bottom: 20px;">Educational Content</h3>

            <div class="form-group">
                <label for="tutorial_content">Tutorial Content</label>
                <textarea id="tutorial_content" name="tutorial_content" class="form-control" rows="10">{{ old('tutorial_content', $track->tutorial_content) }}</textarea>
                <small style="color: #666;">Content that appears on the Tutorial page</small>
            </div>

            <div class="form-group">
                <label for="reference_content">Reference Content</label>
                <textarea id="reference_content" name="reference_content" class="form-control" rows="10">{{ old('reference_content', $track->reference_content) }}</textarea>
                <small style="color: #666;">Content that appears on the Reference page</small>
            </div>

            <hr style="margin: 30px 0; border: 1px solid var(--admin-border);">

            <h3 style="margin-bottom: 20px;">Videos</h3>

            <div id="videos-container">
                @if(old('videos') || $track->videos)
                    @foreach(old('videos', $track->videos ?? []) as $index => $video)
                        <div class="video-item" style="margin-bottom: 15px; padding: 15px; border: 1px solid var(--admin-border); border-radius: 5px;">
                            <div class="form-group">
                                <label>Video Title</label>
                                <input type="text" name="videos[{{ $index }}][title]" class="form-control" value="{{ $video['title'] ?? '' }}" placeholder="Video Title">
                            </div>
                            <div class="form-group">
                                <label>Video URL</label>
                                <input type="url" name="videos[{{ $index }}][url]" class="form-control" value="{{ $video['url'] ?? '' }}" placeholder="https://youtube.com/watch?v=...">
                            </div>
                            <button type="button" class="btn btn-danger" onclick="this.closest('.video-item').remove()" style="padding: 5px 10px; font-size: 12px;">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    @endforeach
                @endif
            </div>

            <button type="button" class="btn btn-secondary" onclick="addVideoField()" style="margin-bottom: 20px;">
                <i class="fas fa-plus"></i> Add Video
            </button>

            <hr style="margin: 30px 0; border: 1px solid var(--admin-border);">

            <h3 style="margin-bottom: 20px;">Display Settings</h3>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="show_tutorial" value="1" {{ old('show_tutorial', $track->show_tutorial) ? 'checked' : '' }}>
                    Show Tutorial Page
                </label>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="show_reference" value="1" {{ old('show_reference', $track->show_reference) ? 'checked' : '' }}>
                    Show Reference Page
                </label>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="show_videos" value="1" {{ old('show_videos', $track->show_videos) ? 'checked' : '' }}>
                    Show Videos Page
                </label>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="show_labs" value="1" {{ old('show_labs', $track->show_labs) ? 'checked' : '' }}>
                    Show Labs Page
                </label>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="show_quiz" value="1" {{ old('show_quiz', $track->show_quiz) ? 'checked' : '' }}>
                    Show Quiz Page
                </label>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 30px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="{{ route('admin.tracks.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Tab 2: Quizzes Management -->
    <div id="tab-quizzes" class="tab-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0;">Quiz Management</h2>
            <a href="{{ route('admin.tracks.quizzes.create', $track) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Quiz
            </a>
        </div>

        @php
            $quizzes = $track->quizzes()->with('questions')->get();
        @endphp

        @if($quizzes->count() > 0)
            @foreach($quizzes as $quiz)
                <div class="quiz-item">
                    <div class="quiz-header">
                        <div>
                            <div class="quiz-title">{{ $quiz->title }}</div>
                            <small style="color: #666;">Questions: {{ $quiz->questions->count() }}</small>
                        </div>
                        <div class="quiz-actions">
                            <a href="{{ route('admin.tracks.quizzes.questions.create', [$track, $quiz]) }}" class="btn btn-primary" style="padding: 8px 15px; font-size: 13px;">
                                <i class="fas fa-plus"></i> Add Question
                            </a>
                            <a href="{{ route('admin.tracks.quizzes.edit', [$track, $quiz]) }}" class="btn btn-secondary" style="padding: 8px 15px; font-size: 13px;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.tracks.quizzes.destroy', [$track, $quiz]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this quiz?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 8px 15px; font-size: 13px;">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    @if($quiz->questions->count() > 0)
                        <div class="questions-list">
                            <h4 style="margin-bottom: 15px; font-size: 14px; color: #666;">Questions:</h4>
                            @foreach($quiz->questions as $question)
                                <div class="question-item">
                                    <div class="question-header">
                                        <div class="question-text">
                                            <strong>{{ $loop->iteration }}.</strong> {{ $question->question }}
                                        </div>
                                        <div style="display: flex; gap: 5px;">
                                            <a href="{{ route('admin.tracks.quizzes.questions.edit', [$track, $quiz, $question]) }}" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px;">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.tracks.quizzes.questions.destroy', [$track, $quiz, $question]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this question?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="question-options">
                                        <div class="option-item {{ $question->correct_answer == 'a' ? 'correct-answer' : '' }}">
                                            <strong>A:</strong> {{ $question->option_a }}
                                        </div>
                                        <div class="option-item {{ $question->correct_answer == 'b' ? 'correct-answer' : '' }}">
                                            <strong>B:</strong> {{ $question->option_b }}
                                        </div>
                                        <div class="option-item {{ $question->correct_answer == 'c' ? 'correct-answer' : '' }}">
                                            <strong>C:</strong> {{ $question->option_c }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: 20px; color: #999;">
                            <p>No questions in this quiz</p>
                            <a href="{{ route('admin.tracks.quizzes.questions.create', [$track, $quiz]) }}" class="btn btn-primary" style="margin-top: 10px;">
                                <i class="fas fa-plus"></i> Add First Question
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <div style="text-align: center; padding: 40px; background: #fafafa; border-radius: 8px; border: 1px dashed var(--admin-border);">
                <i class="fas fa-question-circle" style="font-size: 48px; color: #ccc; margin-bottom: 15px;"></i>
                <p style="color: #666; margin-bottom: 20px;">No quizzes for this track</p>
                <a href="{{ route('admin.tracks.quizzes.create', $track) }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Quiz
                </a>
            </div>
        @endif
    </div>
</div>

<script>
let videoIndex = {{ count(old('videos', $track->videos ?? [])) }};

function addVideoField() {
    const container = document.getElementById('videos-container');
    const videoItem = document.createElement('div');
    videoItem.className = 'video-item';
    videoItem.style.cssText = 'margin-bottom: 15px; padding: 15px; border: 1px solid var(--admin-border); border-radius: 5px;';
    
    videoItem.innerHTML = `
        <div class="form-group">
            <label>Video Title</label>
            <input type="text" name="videos[${videoIndex}][title]" class="form-control" placeholder="Video Title">
        </div>
        <div class="form-group">
            <label>Video URL</label>
            <input type="url" name="videos[${videoIndex}][url]" class="form-control" placeholder="https://youtube.com/watch?v=...">
        </div>
        <button type="button" class="btn btn-danger" onclick="this.closest('.video-item').remove()" style="padding: 5px 10px; font-size: 12px;">
            <i class="fas fa-trash"></i> Delete
        </button>
    `;
    
    container.appendChild(videoItem);
    videoIndex++;
}

function switchTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById('tab-' + tabName).classList.add('active');
    
    // Add active class to clicked button
    event.target.classList.add('active');
}

// Ensure videos are preserved when form is submitted from any tab
document.getElementById('track-form').addEventListener('submit', function(e) {
    // Videos are already in the form, so they should be submitted
    // The controller will handle preserving them if not present
});
</script>
@endsection
