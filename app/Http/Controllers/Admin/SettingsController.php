<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        $settings = $this->getAllSettings();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            // General Settings
            'site_name' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'site_keywords' => 'nullable|string|max:500',
            'site_email' => 'nullable|email|max:255',
            'site_phone' => 'nullable|string|max:50',
            'site_address' => 'nullable|string|max:500',
            
            // Social Media
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            
            // Features
            'maintenance_mode' => 'nullable|boolean',
            'registration_enabled' => 'nullable|boolean',
            'comments_enabled' => 'nullable|boolean',
            
            // SEO
            'google_analytics_id' => 'nullable|string|max:100',
            'google_tag_manager_id' => 'nullable|string|max:100',
            'meta_author' => 'nullable|string|max:255',
            
            // Email Settings
            'contact_email' => 'nullable|email|max:255',
            'notification_email' => 'nullable|email|max:255',
            
            // Appearance
            'logo_url' => 'nullable|url|max:500',
            'favicon_url' => 'nullable|url|max:500',
        ]);

        // Handle checkboxes separately
        $checkboxFields = ['maintenance_mode', 'registration_enabled', 'comments_enabled'];
        
        foreach ($checkboxFields as $field) {
            $value = $request->has($field) ? '1' : '0';
            Setting::updateOrCreate(
                ['key' => $field],
                ['value' => $value]
            );
        }

        // Handle other fields
        foreach ($validated as $key => $value) {
            if (!in_array($key, $checkboxFields)) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value ?? '']
                );
            }
        }

        // Clear cache
        Cache::forget('settings');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Get all settings
     */
    private function getAllSettings(): array
    {
        return Cache::remember('settings', 3600, function () {
            $settings = Setting::pluck('value', 'key')->toArray();
            
            // Default values
            return array_merge([
                'site_name' => 'ITLAB',
                'site_description' => 'Learn programming and web development',
                'site_keywords' => 'programming, web development, coding, tutorials',
                'site_email' => '',
                'site_phone' => '',
                'site_address' => '',
                'facebook_url' => '',
                'twitter_url' => '',
                'instagram_url' => '',
                'linkedin_url' => '',
                'youtube_url' => '',
                'github_url' => '',
                'maintenance_mode' => '0',
                'registration_enabled' => '1',
                'comments_enabled' => '1',
                'google_analytics_id' => '',
                'google_tag_manager_id' => '',
                'meta_author' => '',
                'contact_email' => '',
                'notification_email' => '',
                'logo_url' => '',
                'favicon_url' => '',
            ], $settings);
        });
    }
}

