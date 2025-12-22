@extends('admin.layout')

@section('title', 'Add New Section')
@section('page-title', 'Add New Section to: ' . $page->title)

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.pages.sections.store', $page) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="section_type">Section Type *</label>
            <select id="section_type" name="section_type" class="form-control" required onchange="updateFormFields()">
                <option value="content">Content</option>
                <option value="hero">Hero Section</option>
                <option value="features">Features</option>
                <option value="testimonials">Testimonials</option>
                <option value="cta">Call to Action</option>
                <option value="image">Image Section</option>
                <option value="code">Code Block</option>
                <option value="table">Table</option>
            </select>
            <small style="color: #666;">Choose the type of section you want to add</small>
        </div>

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" placeholder="Section title">
            <small style="color: #666;">Optional: Leave empty for untitled sections</small>
        </div>

        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="section-slug">
            <small style="color: #666;">Optional: Auto-generated from title if empty</small>
        </div>

        <div class="form-group">
            <label for="subtitle">Subtitle</label>
            <textarea id="subtitle" name="subtitle" class="form-control" rows="2" placeholder="Brief subtitle or description">{{ old('subtitle') }}</textarea>
        </div>

        <div class="form-group">
            <label for="content">Content *</label>
            <textarea id="content" name="content" class="form-control" rows="15" required placeholder="Enter section content (HTML supported)">{{ old('content') }}</textarea>
            <small style="color: #666;">You can use HTML in the content</small>
        </div>

        <div class="form-group">
            <label for="order">Order</label>
            <input type="number" id="order" name="order" class="form-control" value="{{ old('order', 0) }}" min="0">
            <small style="color: #666;">Lower numbers appear first (0 = first)</small>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="published" value="1" {{ old('published', true) ? 'checked' : '' }}>
                Publish Section
            </label>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Section
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
    
    // Update placeholder based on type
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

