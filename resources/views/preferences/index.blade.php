@extends('layouts.app')

@section('title', 'Preferences - ITLAB')
@section('body-class', 'page-preferences')

@section('content')
<main class="page-wrapper">
    <div class="container" style="max-width: 900px; margin: 40px auto; padding: 20px;">
        <header class="hero" style="margin-bottom: 40px;">
            <h1>Preferences</h1>
            <p style="color: #9ca3af; max-width: 720px;">Customize your experience on ITLAB. Your preferences will be saved and applied across all pages.</p>
        </header>

        @if(session('success'))
            <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('preferences.update') }}" method="POST" id="preferencesForm">
            @csrf
            @method('PUT')

            <!-- Theme Selection -->
            <div class="preference-section" style="background: #fff; padding: 30px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h2 style="margin-top: 0; margin-bottom: 20px; font-size: 24px;">
                    <i class="fas fa-palette" style="margin-right: 10px; color: #04aa6d;"></i>
                    Theme
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                        <input type="radio" name="theme" value="light" {{ ($preferences['theme'] ?? 'light') === 'light' ? 'checked' : '' }} style="margin-right: 10px;">
                        <div>
                            <strong>Light</strong>
                            <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">Default light theme</p>
                        </div>
                    </label>
                    <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                        <input type="radio" name="theme" value="dark" {{ ($preferences['theme'] ?? 'light') === 'dark' ? 'checked' : '' }} style="margin-right: 10px;">
                        <div>
                            <strong>Dark</strong>
                            <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">Dark mode theme</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Primary Color -->
            <div class="preference-section" style="background: #fff; padding: 30px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h2 style="margin-top: 0; margin-bottom: 20px; font-size: 24px;">
                    <i class="fas fa-fill-drip" style="margin-right: 10px; color: #04aa6d;"></i>
                    Primary Color
                </h2>
                <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                    <input type="color" name="primary_color" value="{{ $preferences['primary_color'] ?? '#04aa6d' }}" style="width: 80px; height: 50px; border: none; border-radius: 5px; cursor: pointer;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Choose your primary color</label>
                        <p style="margin: 0; color: #666; font-size: 14px;">This color will be used for buttons, links, and highlights</p>
                    </div>
                </div>
                <div style="display: flex; gap: 10px; margin-top: 20px; flex-wrap: wrap;">
                    <button type="button" class="color-preset" data-color="#04aa6d" style="width: 50px; height: 50px; border: 2px solid #e0e0e0; border-radius: 5px; cursor: pointer; background: #04aa6d;"></button>
                    <button type="button" class="color-preset" data-color="#3b82f6" style="width: 50px; height: 50px; border: 2px solid #e0e0e0; border-radius: 5px; cursor: pointer; background: #3b82f6;"></button>
                    <button type="button" class="color-preset" data-color="#8b5cf6" style="width: 50px; height: 50px; border: 2px solid #e0e0e0; border-radius: 5px; cursor: pointer; background: #8b5cf6;"></button>
                    <button type="button" class="color-preset" data-color="#ef4444" style="width: 50px; height: 50px; border: 2px solid #e0e0e0; border-radius: 5px; cursor: pointer; background: #ef4444;"></button>
                    <button type="button" class="color-preset" data-color="#f59e0b" style="width: 50px; height: 50px; border: 2px solid #e0e0e0; border-radius: 5px; cursor: pointer; background: #f59e0b;"></button>
                    <button type="button" class="color-preset" data-color="#10b981" style="width: 50px; height: 50px; border: 2px solid #e0e0e0; border-radius: 5px; cursor: pointer; background: #10b981;"></button>
                </div>
            </div>

            <!-- Font Size -->
            <div class="preference-section" style="background: #fff; padding: 30px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h2 style="margin-top: 0; margin-bottom: 20px; font-size: 24px;">
                    <i class="fas fa-text-height" style="margin-right: 10px; color: #04aa6d;"></i>
                    Font Size
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
                    <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                        <input type="radio" name="font_size" value="small" {{ ($preferences['font_size'] ?? 'medium') === 'small' ? 'checked' : '' }} style="margin-right: 10px;">
                        <div>
                            <strong style="font-size: 12px;">Small</strong>
                        </div>
                    </label>
                    <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                        <input type="radio" name="font_size" value="medium" {{ ($preferences['font_size'] ?? 'medium') === 'medium' ? 'checked' : '' }} style="margin-right: 10px;">
                        <div>
                            <strong style="font-size: 14px;">Medium</strong>
                        </div>
                    </label>
                    <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                        <input type="radio" name="font_size" value="large" {{ ($preferences['font_size'] ?? 'medium') === 'large' ? 'checked' : '' }} style="margin-right: 10px;">
                        <div>
                            <strong style="font-size: 16px;">Large</strong>
                        </div>
                    </label>
                    <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                        <input type="radio" name="font_size" value="xlarge" {{ ($preferences['font_size'] ?? 'medium') === 'xlarge' ? 'checked' : '' }} style="margin-right: 10px;">
                        <div>
                            <strong style="font-size: 18px;">Extra Large</strong>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Language -->
            <div class="preference-section" style="background: #fff; padding: 30px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h2 style="margin-top: 0; margin-bottom: 20px; font-size: 24px;">
                    <i class="fas fa-globe" style="margin-right: 10px; color: #04aa6d;"></i>
                    Language
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                        <input type="radio" name="language" value="en" {{ ($preferences['language'] ?? 'en') === 'en' ? 'checked' : '' }} style="margin-right: 10px;">
                        <div>
                            <strong>English</strong>
                            <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">English interface</p>
                        </div>
                    </label>
                    <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                        <input type="radio" name="language" value="ar" {{ ($preferences['language'] ?? 'en') === 'ar' ? 'checked' : '' }} style="margin-right: 10px;">
                        <div>
                            <strong>العربية</strong>
                            <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">Arabic interface</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Layout -->
            <div class="preference-section" style="background: #fff; padding: 30px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h2 style="margin-top: 0; margin-bottom: 20px; font-size: 24px;">
                    <i class="fas fa-columns" style="margin-right: 10px; color: #04aa6d;"></i>
                    Layout
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                        <input type="radio" name="layout" value="default" {{ ($preferences['layout'] ?? 'default') === 'default' ? 'checked' : '' }} style="margin-right: 10px;">
                        <div>
                            <strong>Default</strong>
                            <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">Standard layout</p>
                        </div>
                    </label>
                    <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                        <input type="radio" name="layout" value="compact" {{ ($preferences['layout'] ?? 'default') === 'compact' ? 'checked' : '' }} style="margin-right: 10px;">
                        <div>
                            <strong>Compact</strong>
                            <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">Tighter spacing</p>
                        </div>
                    </label>
                    <label style="display: flex; align-items: center; padding: 15px; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                        <input type="radio" name="layout" value="wide" {{ ($preferences['layout'] ?? 'default') === 'wide' ? 'checked' : '' }} style="margin-right: 10px;">
                        <div>
                            <strong>Wide</strong>
                            <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">Wider content area</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 15px; justify-content: flex-end; margin-top: 30px;">
                <button type="button" onclick="resetPreferences()" class="btn btn-secondary" style="padding: 12px 24px; background: #6c757d; color: #fff; text-decoration: none; border-radius: 5px; border: none; cursor: pointer;">
                    Reset to Defaults
                </button>
                <button type="submit" class="btn btn-primary" style="padding: 12px 24px; background: #04aa6d; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;">
                    Save Preferences
                </button>
            </div>
        </form>
        
        <!-- Hidden form for reset -->
        <form action="{{ route('preferences.reset') }}" method="POST" id="resetForm" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</main>
@endsection

@push('styles')
<style>
    .preference-section label:hover {
        border-color: #04aa6d !important;
        background: #f9f9f9;
    }
    .preference-section input[type="radio"]:checked + div {
        color: #04aa6d;
    }
    .preference-section label:has(input[type="radio"]:checked) {
        border-color: #04aa6d !important;
        background: #f0fdf4;
    }
    .color-preset:hover {
        transform: scale(1.1);
        border-color: #333 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // Color preset buttons
    document.querySelectorAll('.color-preset').forEach(button => {
        button.addEventListener('click', function() {
            const color = this.getAttribute('data-color');
            document.querySelector('input[name="primary_color"]').value = color;
        });
    });

    // Apply preferences on change
    document.querySelectorAll('input[type="radio"], input[type="color"]').forEach(input => {
        input.addEventListener('change', function() {
            applyPreferences();
        });
    });

    function applyPreferences() {
        const form = document.getElementById('preferencesForm');
        const formData = new FormData(form);
        
        const preferences = {
            theme: formData.get('theme') || 'light',
            primary_color: formData.get('primary_color') || '#04aa6d',
            font_size: formData.get('font_size') || 'medium',
            language: formData.get('language') || 'en',
            layout: formData.get('layout') || 'default',
        };

        // Apply theme
        document.body.classList.remove('theme-light', 'theme-dark');
        document.body.classList.add('theme-' + preferences.theme);

        // Apply primary color
        document.documentElement.style.setProperty('--primary-color', preferences.primary_color);

        // Apply font size
        document.body.classList.remove('font-small', 'font-medium', 'font-large', 'font-xlarge');
        document.body.classList.add('font-' + preferences.font_size);

        // Apply language
        document.documentElement.setAttribute('lang', preferences.language);
        document.documentElement.setAttribute('dir', preferences.language === 'ar' ? 'rtl' : 'ltr');

        // Apply layout
        document.body.classList.remove('layout-default', 'layout-compact', 'layout-wide');
        document.body.classList.add('layout-' + preferences.layout);
    }

    // Apply on page load
    applyPreferences();

    // Reset preferences function
    function resetPreferences() {
        if (confirm('Are you sure you want to reset all preferences to defaults?')) {
            document.getElementById('resetForm').submit();
        }
    }
</script>
@endpush

