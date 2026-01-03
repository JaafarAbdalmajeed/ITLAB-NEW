<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Track $track)
    {
        $lessons = $track->lessons()->orderBy('order')->get();
        return view('admin.lessons.index', compact('track', 'lessons'));
    }

    public function create(Track $track)
    {
        return view('admin.lessons.create', compact('track'));
    }

    public function store(Request $request, Track $track)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'required|integer|min:0',
            'youtube_videos' => 'nullable|array',
            'youtube_videos.*.title' => 'nullable|string|max:255',
            'youtube_videos.*.url' => 'nullable|url',
            'sections' => 'nullable|array',
            'sections.*.title' => 'nullable|string|max:255',
            'sections.*.content' => 'nullable|string',
            'sections.*.code' => 'nullable|string',
            'enable_code_editor' => 'boolean',
        ]);

        // Process youtube_videos
        if ($request->has('youtube_videos')) {
            $videos = [];
            foreach ($request->input('youtube_videos', []) as $video) {
                if (!empty($video['url'])) {
                    $videos[] = [
                        'title' => $video['title'] ?? '',
                        'url' => $video['url'],
                    ];
                }
            }
            $data['youtube_videos'] = !empty($videos) ? $videos : null;
        }

        // Process sections
        if ($request->has('sections')) {
            $sections = [];
            foreach ($request->input('sections', []) as $section) {
                if (!empty($section['title']) || !empty($section['content']) || !empty($section['code'])) {
                    $sections[] = [
                        'title' => $section['title'] ?? '',
                        'content' => $section['content'] ?? '',
                        'code' => $section['code'] ?? '',
                    ];
                }
            }
            $data['sections'] = !empty($sections) ? $sections : null;
        }

        $data['enable_code_editor'] = $request->has('enable_code_editor');

        $track->lessons()->create($data);

        return redirect()->route('admin.tracks.lessons.index', $track)
            ->with('success', 'Lesson created successfully.');
    }

    public function edit(Track $track, Lesson $lesson)
    {
        return view('admin.lessons.edit', compact('track', 'lesson'));
    }

    public function update(Request $request, Track $track, Lesson $lesson)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'required|integer|min:0',
            'youtube_videos' => 'nullable|array',
            'youtube_videos.*.title' => 'nullable|string|max:255',
            'youtube_videos.*.url' => 'nullable|url',
            'sections' => 'nullable|array',
            'sections.*.title' => 'nullable|string|max:255',
            'sections.*.content' => 'nullable|string',
            'sections.*.code' => 'nullable|string',
            'enable_code_editor' => 'boolean',
        ]);

        // Process youtube_videos
        if ($request->has('youtube_videos')) {
            $videos = [];
            foreach ($request->input('youtube_videos', []) as $video) {
                if (!empty($video['url'])) {
                    $videos[] = [
                        'title' => $video['title'] ?? '',
                        'url' => $video['url'],
                    ];
                }
            }
            $data['youtube_videos'] = !empty($videos) ? $videos : null;
        } else {
            $data['youtube_videos'] = null;
        }

        // Process sections
        if ($request->has('sections')) {
            $sections = [];
            foreach ($request->input('sections', []) as $section) {
                if (!empty($section['title']) || !empty($section['content']) || !empty($section['code'])) {
                    $sections[] = [
                        'title' => $section['title'] ?? '',
                        'content' => $section['content'] ?? '',
                        'code' => $section['code'] ?? '',
                    ];
                }
            }
            $data['sections'] = !empty($sections) ? $sections : null;
        } else {
            $data['sections'] = null;
        }

        $data['enable_code_editor'] = $request->has('enable_code_editor');

        $lesson->update($data);

        return redirect()->route('admin.tracks.lessons.index', $track)
            ->with('success', 'Lesson updated successfully.');
    }

    public function destroy(Track $track, Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('admin.tracks.lessons.index', $track)
            ->with('success', 'Lesson deleted successfully.');
    }
}

