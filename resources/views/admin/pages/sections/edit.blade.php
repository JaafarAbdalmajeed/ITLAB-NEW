@extends('admin.layout')

@section('title', 'Edit Section')
@section('page-title', 'Edit Section: ' . ($section->title ?: 'Untitled'))

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.pages.sections.update', [$page, $section]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="section_type">Section Type *</label>
            <select id="section_type" name="section_type" class="form-control" required onchange="updateFormFields()">
                <option value="content" {{ old('section_type', $section->section_type) === 'content' ? 'selected' : '' }}>Content</option>
                <option value="hero" {{ old('section_type', $section->section_type) === 'hero' ? 'selected' : '' }}>Hero Section</option>
                <option value="features" {{ old('section_type', $section->section_type) === 'features' ? 'selected' : '' }}>Features</option>
                <option value="testimonials" {{ old('section_type', $section->section_type) === 'testimonials' ? 'selected' : '' }}>Testimonials</option>
                <option value="cta" {{ old('section_type', $section->section_type) === 'cta' ? 'selected' : '' }}>Call to Action</option>
                <option value="image" {{ old('section_type', $section->section_type) === 'image' ? 'selected' : '' }}>Image Section</option>
                <option value="code" {{ old('section_type', $section->section_type) === 'code' ? 'selected' : '' }}>Code Block</option>
                <option value="table" {{ old('section_type', $section->section_type) === 'table' ? 'selected' : '' }}>Table</option>
            </select>
        </div>

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $section->title) }}" placeholder="Section title">
        </div>

        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug', $section->slug) }}" placeholder="section-slug">
        </div>

        <div class="form-group">
            <label for="subtitle">Subtitle</label>
            <textarea id="subtitle" name="subtitle" class="form-control" rows="2" placeholder="Brief subtitle or description">{{ old('subtitle', $section->subtitle) }}</textarea>
        </div>

        <div class="form-group">
            <label for="content">Content *</label>
            <textarea id="content" name="content" class="form-control" rows="15" required>{{ old('content', $section->content) }}</textarea>
            <small style="color: #666;">You can use HTML in the content</small>
        </div>

        <div class="form-group">
            <label for="order">Order</label>
            <input type="number" id="order" name="order" class="form-control" value="{{ old('order', $section->order) }}" min="0">
            <small style="color: #666;">Lower numbers appear first (0 = first)</small>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="published" value="1" {{ old('published', $section->published) ? 'checked' : '' }}>
                Publish Section
            </label>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Changes
            </button>
            <a href="{{ route('admin.pages.sections.index', $page) }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>

<script>
function updateFormFields() {
    const type = document.getElementById('section_type').value;
    const contentField = document.getElementById('content');
    const subtitleField = document.getElementById('subtitle');
    
    switch(type) {
        case 'hero':
            contentField.placeholder = 'Hero content (main heading, description, etc.)';
            subtitleField.placeholder = 'Hero subtitle or tagline';
            break;
        case 'features':
            contentField.placeholder = 'Features list (HTML format)';
            subtitleField.placeholder = 'Features section subtitle';
            break;
        case 'cta':
            contentField.placeholder = 'Call to action text and button';
            subtitleField.placeholder = 'CTA subtitle';
            break;
        case 'code':
            contentField.placeholder = 'Code block content';
            break;
        default:
            contentField.placeholder = 'Enter section content (HTML supported)';
            subtitleField.placeholder = 'Brief subtitle or description';
    }
}
</script>
@endsection

