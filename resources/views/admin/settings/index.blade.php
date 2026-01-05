@extends('admin.layout')

@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <h2>General Settings</h2>
    </div>
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- General Settings Tab -->
        <div class="settings-tabs">
            <div class="tab-buttons" style="display: flex; gap: 10px; border-bottom: 2px solid var(--admin-border); margin-bottom: 20px;">
                <button type="button" class="tab-btn active" data-tab="general">General</button>
                <button type="button" class="tab-btn" data-tab="social">Social Media</button>
                <button type="button" class="tab-btn" data-tab="features">Features</button>
                <button type="button" class="tab-btn" data-tab="seo">SEO</button>
                <button type="button" class="tab-btn" data-tab="email">Email</button>
                <button type="button" class="tab-btn" data-tab="appearance">Appearance</button>
            </div>

            <!-- General Tab -->
            <div class="tab-content active" id="general-tab">
                <div class="form-group">
                    <label>Site Name</label>
                    <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? '' }}" placeholder="ITLAB">
                </div>

                <div class="form-group">
                    <label>Site Description</label>
                    <textarea name="site_description" class="form-control" rows="3" placeholder="Learn programming and web development">{{ $settings['site_description'] ?? '' }}</textarea>
                </div>

                <div class="form-group">
                    <label>Site Keywords</label>
                    <input type="text" name="site_keywords" class="form-control" value="{{ $settings['site_keywords'] ?? '' }}" placeholder="programming, web development, coding">
                </div>

                <div class="form-group">
                    <label>Site Email</label>
                    <input type="email" name="site_email" class="form-control" value="{{ $settings['site_email'] ?? '' }}" placeholder="info@itlab.com">
                </div>

                <div class="form-group">
                    <label>Site Phone</label>
                    <input type="text" name="site_phone" class="form-control" value="{{ $settings['site_phone'] ?? '' }}" placeholder="+1234567890">
                </div>

                <div class="form-group">
                    <label>Site Address</label>
                    <textarea name="site_address" class="form-control" rows="2" placeholder="Your address">{{ $settings['site_address'] ?? '' }}</textarea>
                </div>
            </div>

            <!-- Social Media Tab -->
            <div class="tab-content" id="social-tab" style="display: none;">
                <div class="form-group">
                    <label><i class="fab fa-facebook"></i> Facebook URL</label>
                    <input type="url" name="facebook_url" class="form-control" value="{{ $settings['facebook_url'] ?? '' }}" placeholder="https://facebook.com/yourpage">
                </div>

                <div class="form-group">
                    <label><i class="fab fa-twitter"></i> Twitter URL</label>
                    <input type="url" name="twitter_url" class="form-control" value="{{ $settings['twitter_url'] ?? '' }}" placeholder="https://twitter.com/yourhandle">
                </div>

                <div class="form-group">
                    <label><i class="fab fa-instagram"></i> Instagram URL</label>
                    <input type="url" name="instagram_url" class="form-control" value="{{ $settings['instagram_url'] ?? '' }}" placeholder="https://instagram.com/yourprofile">
                </div>

                <div class="form-group">
                    <label><i class="fab fa-linkedin"></i> LinkedIn URL</label>
                    <input type="url" name="linkedin_url" class="form-control" value="{{ $settings['linkedin_url'] ?? '' }}" placeholder="https://linkedin.com/company/yourcompany">
                </div>

                <div class="form-group">
                    <label><i class="fab fa-youtube"></i> YouTube URL</label>
                    <input type="url" name="youtube_url" class="form-control" value="{{ $settings['youtube_url'] ?? '' }}" placeholder="https://youtube.com/yourchannel">
                </div>

                <div class="form-group">
                    <label><i class="fab fa-github"></i> GitHub URL</label>
                    <input type="url" name="github_url" class="form-control" value="{{ $settings['github_url'] ?? '' }}" placeholder="https://github.com/yourusername">
                </div>
            </div>

            <!-- Features Tab -->
            <div class="tab-content" id="features-tab" style="display: none;">
                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" name="maintenance_mode" value="1" {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' }}>
                        <span>Maintenance Mode</span>
                    </label>
                    <small style="color: #666; display: block; margin-top: 5px;">Enable to put the site in maintenance mode</small>
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" name="registration_enabled" value="1" {{ ($settings['registration_enabled'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span>Registration Enabled</span>
                    </label>
                    <small style="color: #666; display: block; margin-top: 5px;">Allow new users to register</small>
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" name="comments_enabled" value="1" {{ ($settings['comments_enabled'] ?? '1') == '1' ? 'checked' : '' }}>
                        <span>Comments Enabled</span>
                    </label>
                    <small style="color: #666; display: block; margin-top: 5px;">Enable comments on posts and lessons</small>
                </div>
            </div>

            <!-- SEO Tab -->
            <div class="tab-content" id="seo-tab" style="display: none;">
                <div class="form-group">
                    <label>Google Analytics ID</label>
                    <input type="text" name="google_analytics_id" class="form-control" value="{{ $settings['google_analytics_id'] ?? '' }}" placeholder="G-XXXXXXXXXX">
                    <small style="color: #666; display: block; margin-top: 5px;">Your Google Analytics tracking ID</small>
                </div>

                <div class="form-group">
                    <label>Google Tag Manager ID</label>
                    <input type="text" name="google_tag_manager_id" class="form-control" value="{{ $settings['google_tag_manager_id'] ?? '' }}" placeholder="GTM-XXXXXXX">
                    <small style="color: #666; display: block; margin-top: 5px;">Your Google Tag Manager container ID</small>
                </div>

                <div class="form-group">
                    <label>Meta Author</label>
                    <input type="text" name="meta_author" class="form-control" value="{{ $settings['meta_author'] ?? '' }}" placeholder="ITLAB Team">
                    <small style="color: #666; display: block; margin-top: 5px;">Default author name for meta tags</small>
                </div>
            </div>

            <!-- Email Tab -->
            <div class="tab-content" id="email-tab" style="display: none;">
                <div class="form-group">
                    <label>Contact Email</label>
                    <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? '' }}" placeholder="contact@itlab.com">
                    <small style="color: #666; display: block; margin-top: 5px;">Email address for contact form submissions</small>
                </div>

                <div class="form-group">
                    <label>Notification Email</label>
                    <input type="email" name="notification_email" class="form-control" value="{{ $settings['notification_email'] ?? '' }}" placeholder="notifications@itlab.com">
                    <small style="color: #666; display: block; margin-top: 5px;">Email address for system notifications</small>
                </div>
            </div>

            <!-- Appearance Tab -->
            <div class="tab-content" id="appearance-tab" style="display: none;">
                <div class="form-group">
                    <label>Logo URL</label>
                    <input type="url" name="logo_url" class="form-control" value="{{ $settings['logo_url'] ?? '' }}" placeholder="https://example.com/logo.png">
                    <small style="color: #666; display: block; margin-top: 5px;">URL to your site logo</small>
                </div>

                <div class="form-group">
                    <label>Favicon URL</label>
                    <input type="url" name="favicon_url" class="form-control" value="{{ $settings['favicon_url'] ?? '' }}" placeholder="https://example.com/favicon.ico">
                    <small style="color: #666; display: block; margin-top: 5px;">URL to your site favicon</small>
                </div>
            </div>
        </div>

        <div style="margin-top: 30px; display: flex; justify-content: flex-end; gap: 15px;">
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .tab-btn {
        padding: 10px 20px;
        background: transparent;
        border: none;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        font-size: 14px;
        color: #666;
        transition: all 0.3s;
    }
    .tab-btn:hover {
        color: var(--admin-secondary);
    }
    .tab-btn.active {
        color: var(--admin-secondary);
        border-bottom-color: var(--admin-secondary);
        font-weight: 600;
    }
    .tab-content {
        animation: fadeIn 0.3s;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>
@endpush

@push('scripts')
<script>
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');
            
            // Remove active class from all buttons and tabs
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(t => {
                t.style.display = 'none';
                t.classList.remove('active');
            });
            
            // Add active class to clicked button and corresponding tab
            this.classList.add('active');
            const tab = document.getElementById(tabName + '-tab');
            if (tab) {
                tab.style.display = 'block';
                tab.classList.add('active');
            }
        });
    });
</script>
@endpush

