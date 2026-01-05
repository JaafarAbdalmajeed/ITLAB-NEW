<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class VideoController extends Controller
{
    public function index(Track $track)
    {
        $query = $track->videos();
        
        // Check if 'order' column exists before using it
        if (Schema::hasColumn('videos', 'order')) {
            $videos = $query->orderBy('order')->latest()->get();
        } else {
            $videos = $query->latest()->get();
        }
        
        return view('admin.videos.index', compact('track', 'videos'));
    }

    public function create(Track $track)
    {
        return view('admin.videos.create', compact('track'));
    }

    public function store(Request $request, Track $track)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|string|max:500',
            'video_id' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer|min:0',
        ]);

        // Extract video ID or playlist ID from URL if provided and video_id is empty
        if (empty($data['video_id']) && !empty($data['url'])) {
            // Try to extract playlist ID first
            if (preg_match('/[?&]list=([a-zA-Z0-9_-]+)/', $data['url'], $matches)) {
                $data['video_id'] = $matches[1];
            }
            // If no playlist ID, try to extract video ID
            elseif (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $data['url'], $matches)) {
                $data['video_id'] = $matches[1];
            }
        }

        // Set default color if not provided
        if (empty($data['color'])) {
            $colors = ['#00ffaa', '#61dafb', '#ff5252', '#ffeb3b', '#e040fb'];
            $data['color'] = $colors[($track->videos()->count() % count($colors))];
        }

        // Set default order if not provided
        if (!isset($data['order'])) {
            if (Schema::hasColumn('videos', 'order')) {
                $data['order'] = $track->videos()->max('order') + 1 ?? 0;
            } else {
                $data['order'] = 0;
            }
        }

        $track->videos()->create($data);

        return redirect()->route('admin.tracks.videos.index', $track)
            ->with('success', 'Video created successfully.');
    }

    public function edit(Track $track, Video $video)
    {
        return view('admin.videos.edit', compact('track', 'video'));
    }

    public function update(Request $request, Track $track, Video $video)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|string|max:500',
            'video_id' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer|min:0',
        ]);

        // Extract video ID or playlist ID from URL if provided and video_id is empty
        if (empty($data['video_id']) && !empty($data['url'])) {
            // Try to extract playlist ID first
            if (preg_match('/[?&]list=([a-zA-Z0-9_-]+)/', $data['url'], $matches)) {
                $data['video_id'] = $matches[1];
            }
            // If no playlist ID, try to extract video ID
            elseif (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $data['url'], $matches)) {
                $data['video_id'] = $matches[1];
            }
        }

        $video->update($data);

        return redirect()->route('admin.tracks.videos.index', $track)
            ->with('success', 'Video updated successfully.');
    }

    public function destroy(Track $track, Video $video)
    {
        $video->delete();

        return redirect()->route('admin.tracks.videos.index', $track)
            ->with('success', 'Video deleted successfully.');
    }
}
