<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{
    /**
     * Show preferences settings page
     */
    public function index()
    {
        $user = Auth::user();
        $preferences = $user ? $user->getPreferences() : [
            'theme' => 'light',
            'primary_color' => '#04aa6d',
            'font_size' => 'medium',
            'language' => 'en',
            'layout' => 'default',
        ];

        return view('preferences.index', compact('preferences'));
    }

    /**
     * Update user preferences
     */
    public function update(Request $request)
    {
        $request->validate([
            'theme' => 'nullable|in:light,dark',
            'primary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'font_size' => 'nullable|in:small,medium,large,xlarge',
            'language' => 'nullable|in:en,ar',
            'layout' => 'nullable|in:default,compact,wide',
        ]);

        if (!Auth::check()) {
            // Store in session for guests
            $preferences = session('preferences', []);
            foreach ($request->only(['theme', 'primary_color', 'font_size', 'language', 'layout']) as $key => $value) {
                if ($value !== null) {
                    $preferences[$key] = $value;
                }
            }
            session(['preferences' => $preferences]);

            return redirect()->route('preferences.index')
                ->with('success', 'Preferences saved (session only). Sign in to save permanently.');
        }

        $user = Auth::user();
        $preferences = $user->preferences ?? [];

        foreach ($request->only(['theme', 'primary_color', 'font_size', 'language', 'layout']) as $key => $value) {
            if ($value !== null) {
                $preferences[$key] = $value;
            }
        }

        $user->preferences = $preferences;
        $user->save();

        return redirect()->route('preferences.index')
            ->with('success', 'Preferences updated successfully.');
    }

    /**
     * Reset preferences to defaults
     */
    public function reset()
    {
        if (!Auth::check()) {
            session()->forget('preferences');
            return redirect()->route('preferences.index')
                ->with('success', 'Preferences reset to defaults.');
        }

        $user = Auth::user();
        $user->preferences = null;
        $user->save();

        return redirect()->route('preferences.index')
            ->with('success', 'Preferences reset to defaults.');
    }

    /**
     * Get preferences as JSON (for AJAX)
     */
    public function get()
    {
        if (Auth::check()) {
            $preferences = Auth::user()->getPreferences();
        } else {
            $sessionPrefs = session('preferences', []);
            $defaults = [
                'theme' => 'light',
                'primary_color' => '#04aa6d',
                'font_size' => 'medium',
                'language' => 'en',
                'layout' => 'default',
            ];
            $preferences = array_merge($defaults, $sessionPrefs);
        }

        return response()->json($preferences);
    }
}

