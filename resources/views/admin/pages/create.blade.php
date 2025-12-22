@extends('admin.layout')

@section('title', 'Add New Page')
@section('page-title', 'Add New Page')

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.pages.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="slug">Slug *</label>
            <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" required>
            @error('slug')
                <div style="color: #dc3545; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
            <small style="color: #666;">Example: about, contact, help-center</small>
        </div>

        <div class="form-group">
            <label for="title">Title *</label>
            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
            @error('title')
                <div style="color: #dc3545; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="meta_description">SEO Description</label>
            <textarea id="meta_description" name="meta_description" class="form-control" rows="2">{{ old('meta_description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="content" class="form-control" rows="15">{{ old('content') }}</textarea>
            <small style="color: #666;">You can use HTML in the content</small>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="published" value="1" {{ old('published') ? 'checked' : '' }}>
                Publish Page
            </label>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save
            </button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection

