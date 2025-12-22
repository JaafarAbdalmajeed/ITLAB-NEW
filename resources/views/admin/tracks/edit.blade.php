@extends('admin.layout')

@section('title', 'Edit Track')
@section('page-title', 'Edit Track: ' . $track->title)

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.tracks.update', $track) }}" method="POST">
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

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
            <a href="{{ route('admin.tracks.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
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
</script>
@endsection

