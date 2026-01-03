@extends('admin.layout')

@section('title', 'Edit Lesson')
@section('page-title', 'Edit Lesson: ' . $lesson->title)

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.tracks.lessons.update', [$track, $lesson]) }}" method="POST" id="lesson-form">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="title">Lesson Title *</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $lesson->title) }}" required>
        </div>

        <div class="form-group">
            <label for="order">Order *</label>
            <input type="number" id="order" name="order" class="form-control" value="{{ old('order', $lesson->order) }}" min="0" required>
        </div>

        <div class="form-group">
            <label for="content">Lesson Content *</label>
            <textarea id="content" name="content" class="form-control" rows="10" required>{{ old('content', $lesson->content) }}</textarea>
            <small style="color: #666;">You can use HTML in the content</small>
        </div>

        <!-- YouTube Videos Section -->
        <div class="form-group">
            <label>YouTube Videos</label>
            <div id="youtube-videos-container">
                @if($lesson->youtube_videos && count($lesson->youtube_videos) > 0)
                    @foreach($lesson->youtube_videos as $index => $video)
                        <div class="video-item" style="margin-bottom: 10px; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
                            <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                                <input type="text" name="youtube_videos[{{ $index }}][title]" class="form-control" value="{{ $video['title'] ?? '' }}" placeholder="Video Title (optional)">
                                <input type="url" name="youtube_videos[{{ $index }}][url]" class="form-control" value="{{ $video['url'] ?? '' }}" placeholder="YouTube URL">
                                <button type="button" class="btn btn-danger" onclick="removeVideo(this)" style="padding: 5px 10px;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="video-item" style="margin-bottom: 10px; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <input type="text" name="youtube_videos[0][title]" class="form-control" placeholder="Video Title (optional)">
                            <input type="url" name="youtube_videos[0][url]" class="form-control" placeholder="YouTube URL">
                            <button type="button" class="btn btn-danger" onclick="removeVideo(this)" style="padding: 5px 10px;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
            <button type="button" class="btn btn-secondary" onclick="addVideo()" style="margin-top: 10px;">
                <i class="fas fa-plus"></i> Add Video
            </button>
        </div>

        <!-- Sections Section -->
        <div class="form-group">
            <label>Lesson Sections</label>
            <div id="sections-container">
                @if($lesson->sections && count($lesson->sections) > 0)
                    @foreach($lesson->sections as $index => $section)
                        <div class="section-item" style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
                            <div class="form-group">
                                <label>Section Title</label>
                                <input type="text" name="sections[{{ $index }}][title]" class="form-control" value="{{ $section['title'] ?? '' }}" placeholder="Section Title">
                            </div>
                            <div class="form-group">
                                <label>Section Content</label>
                                <textarea name="sections[{{ $index }}][content]" class="form-control" rows="5" placeholder="Section content (HTML allowed)">{{ $section['content'] ?? '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Code Example (optional)</label>
                                <textarea name="sections[{{ $index }}][code]" class="form-control" rows="5" placeholder="Code example">{{ $section['code'] ?? '' }}</textarea>
                            </div>
                            <button type="button" class="btn btn-danger" onclick="removeSection(this)" style="padding: 5px 10px;">
                                <i class="fas fa-times"></i> Remove Section
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="section-item" style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
                        <div class="form-group">
                            <label>Section Title</label>
                            <input type="text" name="sections[0][title]" class="form-control" placeholder="Section Title">
                        </div>
                        <div class="form-group">
                            <label>Section Content</label>
                            <textarea name="sections[0][content]" class="form-control" rows="5" placeholder="Section content (HTML allowed)"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Code Example (optional)</label>
                            <textarea name="sections[0][code]" class="form-control" rows="5" placeholder="Code example"></textarea>
                        </div>
                        <button type="button" class="btn btn-danger" onclick="removeSection(this)" style="padding: 5px 10px;">
                            <i class="fas fa-times"></i> Remove Section
                        </button>
                    </div>
                @endif
            </div>
            <button type="button" class="btn btn-secondary" onclick="addSection()" style="margin-top: 10px;">
                <i class="fas fa-plus"></i> Add Section
            </button>
        </div>

        <!-- Code Editor Toggle -->
        <div class="form-group">
            <label>
                <input type="checkbox" name="enable_code_editor" value="1" {{ old('enable_code_editor', $lesson->enable_code_editor) ? 'checked' : '' }}>
                Enable Code Editor (Try It Yourself)
            </label>
            <small style="color: #666; display: block; margin-top: 5px;">Allow students to write and test code in this lesson</small>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
            <a href="{{ route('admin.tracks.lessons.index', $track) }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>

<script>
let videoIndex = {{ $lesson->youtube_videos ? count($lesson->youtube_videos) : 1 }};
let sectionIndex = {{ $lesson->sections ? count($lesson->sections) : 1 }};

function addVideo() {
    const container = document.getElementById('youtube-videos-container');
    const newVideo = document.createElement('div');
    newVideo.className = 'video-item';
    newVideo.style.cssText = 'margin-bottom: 10px; padding: 15px; border: 1px solid #ddd; border-radius: 5px;';
    newVideo.innerHTML = `
        <div style="display: flex; gap: 10px; margin-bottom: 10px;">
            <input type="text" name="youtube_videos[${videoIndex}][title]" class="form-control" placeholder="Video Title (optional)">
            <input type="url" name="youtube_videos[${videoIndex}][url]" class="form-control" placeholder="YouTube URL">
            <button type="button" class="btn btn-danger" onclick="removeVideo(this)" style="padding: 5px 10px;">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(newVideo);
    videoIndex++;
}

function removeVideo(btn) {
    btn.closest('.video-item').remove();
}

function addSection() {
    const container = document.getElementById('sections-container');
    const newSection = document.createElement('div');
    newSection.className = 'section-item';
    newSection.style.cssText = 'margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px;';
    newSection.innerHTML = `
        <div class="form-group">
            <label>Section Title</label>
            <input type="text" name="sections[${sectionIndex}][title]" class="form-control" placeholder="Section Title">
        </div>
        <div class="form-group">
            <label>Section Content</label>
            <textarea name="sections[${sectionIndex}][content]" class="form-control" rows="5" placeholder="Section content (HTML allowed)"></textarea>
        </div>
        <div class="form-group">
            <label>Code Example (optional)</label>
            <textarea name="sections[${sectionIndex}][code]" class="form-control" rows="5" placeholder="Code example"></textarea>
        </div>
        <button type="button" class="btn btn-danger" onclick="removeSection(this)" style="padding: 5px 10px;">
            <i class="fas fa-times"></i> Remove Section
        </button>
    `;
    container.appendChild(newSection);
    sectionIndex++;
}

function removeSection(btn) {
    btn.closest('.section-item').remove();
}
</script>
@endsection
