@extends('admin.layout')

@section('title', 'Edit Navbar Item')
@section('page-title', 'Edit Navbar Item')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>Edit Navbar Item</h2>
        <a href="{{ route('admin.navbar.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <form action="{{ route('admin.navbar.update', $navbar) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 20px;">
            <label for="label" style="display: block; margin-bottom: 5px; font-weight: bold;">Label <span style="color: red;">*</span></label>
            <input type="text" id="label" name="label" value="{{ old('label', $navbar->label) }}" required 
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                   placeholder="e.g., Home, Dashboard, HTML">
            @error('label')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="url" style="display: block; margin-bottom: 5px; font-weight: bold;">URL <span style="color: red;">*</span></label>
            <input type="text" id="url" name="url" value="{{ old('url', $navbar->url) }}" required 
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                   placeholder="e.g., /dashboard or https://example.com">
            <small style="color: #666;">Enter the full URL or relative path</small>
            @error('url')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="route" style="display: block; margin-bottom: 5px; font-weight: bold;">Route Name (Optional)</label>
            <input type="text" id="route" name="route" value="{{ old('route', $navbar->route) }}" 
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                   placeholder="e.g., pages.html, home">
            <small style="color: #666;">If provided, this route will be used instead of the URL above</small>
            @error('route')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="icon" style="display: block; margin-bottom: 5px; font-weight: bold;">Icon Class (Optional)</label>
            <input type="text" id="icon" name="icon" value="{{ old('icon', $navbar->icon) }}" 
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                   placeholder="e.g., fas fa-home, fa-solid fa-user">
            <small style="color: #666;">Font Awesome icon class (e.g., fas fa-home)</small>
            @error('icon')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="order" style="display: block; margin-bottom: 5px; font-weight: bold;">Order <span style="color: red;">*</span></label>
            <input type="number" id="order" name="order" value="{{ old('order', $navbar->order) }}" required min="0" 
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            <small style="color: #666;">Lower numbers appear first in the navbar</small>
            @error('order')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="target" style="display: block; margin-bottom: 5px; font-weight: bold;">Link Target</label>
            <select id="target" name="target" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="_self" {{ old('target', $navbar->target) == '_self' ? 'selected' : '' }}>Same Window (_self)</option>
                <option value="_blank" {{ old('target', $navbar->target) == '_blank' ? 'selected' : '' }}>New Window (_blank)</option>
            </select>
            @error('target')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="css_class" style="display: block; margin-bottom: 5px; font-weight: bold;">CSS Class (Optional)</label>
            <input type="text" id="css_class" name="css_class" value="{{ old('css_class', $navbar->css_class) }}" 
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"
                   placeholder="e.g., nav-certified, special-link">
            <small style="color: #666;">Additional CSS classes to apply to the link</small>
            @error('css_class')
                <span style="color: red; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: flex; align-items: center; gap: 10px;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $navbar->is_active) ? 'checked' : '' }}>
                <span>Active (Show in navbar)</span>
            </label>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Item
            </button>
            <a href="{{ route('admin.navbar.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

