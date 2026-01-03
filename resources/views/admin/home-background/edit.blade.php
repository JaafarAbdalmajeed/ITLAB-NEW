@extends('admin.layout')

@section('title', 'Home Background Settings')
@section('page-title', 'Home Background Settings')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>Home Background Settings</h2>
        <p>Control the background of the home page (image, video, or animated)</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-right: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.home-background.update') }}" method="POST" enctype="multipart/form-data" id="background-form">
        @csrf
        <input type="hidden" name="_method" value="PUT">

        <div class="form-group">
            <label for="type">Background Type *</label>
            <select name="type" id="type" class="form-control" required onchange="toggleBackgroundOptions()">
                <option value="image" {{ old('type', $setting->type ?? 'image') === 'image' ? 'selected' : '' }}>Image</option>
                <option value="video" {{ old('type', $setting->type ?? '') === 'video' ? 'selected' : '' }}>Video</option>
                <option value="animated" {{ old('type', $setting->type ?? '') === 'animated' ? 'selected' : '' }}>Animated (CSS/GIF)</option>
            </select>
            <small class="form-text text-muted">Choose the type of background for the home page</small>
        </div>

        <!-- Image Upload -->
        <div id="image-options" class="background-options">
            <div class="form-group">
                <label for="image">Background Image <span id="image-required" style="color: red;">*</span></label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*" 
                       onchange="handleImageChange(this);">
                <small class="form-text text-muted">Upload an image (All image formats supported - JPEG, PNG, GIF, WebP, BMP, SVG, ICO, TIFF, HEIC, etc. - Max 20MB)</small>
                <div id="image-preview" style="display: none; margin-top: 10px;">
                    <p style="color: #28a745; font-weight: bold;">✓ Image selected and ready to upload</p>
                    <p id="image-info" style="color: #666; font-size: 12px;"></p>
                </div>
                @if($setting->image_path ?? null)
                    <div style="margin-top: 10px;">
                        <p><strong>Current Image:</strong></p>
                        <img src="{{ asset('storage/' . $setting->image_path) }}" alt="Current background" style="max-width: 300px; max-height: 200px; border-radius: 4px; border: 1px solid #ddd;">
                    </div>
                @endif
            </div>
        </div>

        <!-- Video Upload -->
        <div id="video-options" class="background-options" style="display: none;">
            <div class="form-group">
                <label for="video">Background Video</label>
                <input type="file" name="video" id="video" class="form-control" accept="video/*">
                <small class="form-text text-muted">Upload a video (MP4, WebM, OGG, AVI, MOV, WMV, FLV, 3GP - Max 100MB). Short videos work best.</small>
                @if($setting->video_path ?? null)
                    <div style="margin-top: 10px;">
                        <p><strong>Current Video:</strong></p>
                        <video controls style="max-width: 300px; max-height: 200px; border-radius: 4px; border: 1px solid #ddd;">
                            <source src="{{ asset('storage/' . $setting->video_path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                @endif
            </div>
        </div>

        <!-- Animated Options -->
        <div id="animated-options" class="background-options" style="display: none;">
            <div class="form-group">
                <label for="animated_type">Animation Type</label>
                <select name="animated_type" id="animated_type" class="form-control">
                    <option value="css-gradient" {{ old('animated_type', $setting->animated_type ?? '') === 'css-gradient' ? 'selected' : '' }}>CSS Gradient Animation</option>
                    <option value="css-particles" {{ old('animated_type', $setting->animated_type ?? '') === 'css-particles' ? 'selected' : '' }}>CSS Particles</option>
                    <option value="gif" {{ old('animated_type', $setting->animated_type ?? '') === 'gif' ? 'selected' : '' }}>GIF Image</option>
                </select>
                <small class="form-text text-muted">Choose the type of animation</small>
            </div>
            <div class="form-group" id="gif-upload" style="display: none;">
                <label for="image">GIF Image</label>
                <input type="file" name="image" id="gif-image" class="form-control" accept="image/gif">
                <small class="form-text text-muted">Upload a GIF image for animated background</small>
            </div>
        </div>

        <!-- Overlay Settings -->
        <div class="form-group">
            <label for="overlay_color">Overlay Color</label>
            <input type="text" name="overlay_color" id="overlay_color" class="form-control" 
                   value="{{ old('overlay_color', $setting->overlay_color ?? 'rgba(0,0,0,0.5)') }}" 
                   placeholder="rgba(0,0,0,0.5)">
            <small class="form-text text-muted">Color overlay on top of background (RGBA format)</small>
        </div>

        <div class="form-group">
            <label for="overlay_opacity">Overlay Opacity</label>
            <input type="range" name="overlay_opacity" id="overlay_opacity" class="form-control" 
                   min="0" max="100" 
                   value="{{ old('overlay_opacity', $setting->overlay_opacity ?? 50) }}"
                   oninput="document.getElementById('opacity-value').textContent = this.value + '%'">
            <small class="form-text text-muted">Opacity: <span id="opacity-value">{{ old('overlay_opacity', $setting->overlay_opacity ?? 50) }}%</span></small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Settings
            </button>
            @if($setting->is_active ?? false)
                <a href="{{ route('admin.home-background.destroy') }}" 
                   class="btn btn-danger" 
                   onclick="return confirm('Are you sure you want to deactivate the background?')">
                    <i class="fas fa-times"></i> Deactivate Background
                </a>
            @endif
        </div>
    </form>
</div>

<script>
function toggleBackgroundOptions() {
    const type = document.getElementById('type').value;
    
    // Hide all options
    document.getElementById('image-options').style.display = 'none';
    document.getElementById('video-options').style.display = 'none';
    document.getElementById('animated-options').style.display = 'none';
    
    // Show relevant options
    if (type === 'image') {
        document.getElementById('image-options').style.display = 'block';
        document.getElementById('image').required = false;
        document.getElementById('video').required = false;
    } else if (type === 'video') {
        document.getElementById('video-options').style.display = 'block';
        document.getElementById('video').required = false;
        document.getElementById('image').required = false;
    } else if (type === 'animated') {
        document.getElementById('animated-options').style.display = 'block';
        document.getElementById('image').required = false;
        document.getElementById('video').required = false;
        
        // Show GIF upload if GIF is selected
        const animatedType = document.getElementById('animated_type');
        if (animatedType.value === 'gif') {
            document.getElementById('gif-upload').style.display = 'block';
        }
    }
}

// Toggle GIF upload based on animated type
document.getElementById('animated_type')?.addEventListener('change', function() {
    if (this.value === 'gif') {
        document.getElementById('gif-upload').style.display = 'block';
    } else {
        document.getElementById('gif-upload').style.display = 'none';
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleBackgroundOptions();
    
    // Debug: Log form submission
    const form = document.getElementById('background-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const type = document.getElementById('type').value;
            const imageInput = document.getElementById('image');
            const hasImage = imageInput.files && imageInput.files.length > 0;
            const currentImage = @json($setting->image_path ?? null);
            
            console.log('=== Form Submission Debug ===');
            console.log('Type:', type);
            console.log('Has Image File:', hasImage);
            console.log('Current Image Path:', currentImage);
            
            if (hasImage) {
                console.log('Image File:', imageInput.files[0].name, imageInput.files[0].size, imageInput.files[0].type);
            }
            
            // Check if image is required but not provided
            if (type === 'image' && !hasImage && !currentImage) {
                console.error('ERROR: Image is required but not provided!');
                alert('⚠️ Please upload an image! Image is required!');
                e.preventDefault();
                return false;
            }
            
            const formData = new FormData(this);
            console.log('Form Data:');
            for (let [key, value] of formData.entries()) {
                if (value instanceof File) {
                    console.log(key + ':', value.name, value.size, value.type);
                } else {
                    console.log(key + ':', value);
                }
            }
        });
    }
});
</script>

<style>
.background-options {
    margin: 20px 0;
    padding: 15px;
    background: #f9f9f9;
    border-radius: 4px;
    border: 1px solid #e0e0e0;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    color: #333;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.form-control:focus {
    outline: none;
    border-color: #04aa6d;
    box-shadow: 0 0 0 2px rgba(4, 170, 109, 0.1);
}

.form-text {
    display: block;
    margin-top: 5px;
    font-size: 12px;
    color: #666;
}

.form-actions {
    margin-top: 30px;
    display: flex;
    gap: 10px;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    transition: all 0.3s;
}

.btn-primary {
    background: #04aa6d;
    color: white;
}

.btn-primary:hover {
    background: #038a5a;
}

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn-danger:hover {
    background: #c82333;
}
</style>
@endsection

