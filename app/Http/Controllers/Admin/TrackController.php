<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function index()
    {
        $tracks = Track::withCount([
            'lessons', 
            'quizzes', 
            'labs',
            'userProgress as completed_students_count' => function($query) {
                $query->where('progress_percent', 100);
            }
        ])->latest()->get();
        
        return view('admin.tracks.index', compact('tracks'));
    }

    public function show(Track $track)
    {
        $track->loadCount([
            'lessons',
            'quizzes',
            'labs',
            'userProgress as completed_students_count' => function($query) {
                $query->where('progress_percent', 100);
            },
            'certificates'
        ]);

        // Get all students who completed this track
        $completedStudents = $track->userProgress()
            ->where('progress_percent', 100)
            ->with('user')
            ->latest('updated_at')
            ->get();

        // Get students in progress
        $inProgressStudents = $track->userProgress()
            ->where('progress_percent', '<', 100)
            ->where('progress_percent', '>', 0)
            ->with('user')
            ->latest('updated_at')
            ->get();

        return view('admin.tracks.show', compact('track', 'completedStudents', 'inProgressStudents'));
    }

    public function create()
    {
        return view('admin.tracks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slug' => 'required|unique:tracks,slug',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tutorial_content' => 'nullable|string',
            'reference_content' => 'nullable|string',
            'hero_content' => 'nullable|string',
            'hero_button_text' => 'nullable|string|max:255',
            'hero_button_link' => 'nullable|string|max:255',
            'example_code' => 'nullable|string',
            'videos' => 'nullable|array',
            'videos.*.title' => 'nullable|string|max:255',
            'videos.*.url' => 'nullable|url',
            'show_tutorial' => 'boolean',
            'show_reference' => 'boolean',
            'show_videos' => 'boolean',
            'show_labs' => 'boolean',
            'show_quiz' => 'boolean',
        ]);

        // Process videos array - only update if videos are present in request
        if ($request->has('videos')) {
            $videos = [];
            foreach ($request->input('videos', []) as $video) {
                if (!empty($video['title']) && !empty($video['url'])) {
                    $videos[] = [
                        'title' => $video['title'],
                        'url' => $video['url'],
                    ];
                }
            }
            $data['videos'] = !empty($videos) ? $videos : null;
        } else {
            // If videos are not in request, keep existing videos
            unset($data['videos']);
        }

        // Process boolean fields
        $data['show_tutorial'] = $request->has('show_tutorial');
        $data['show_reference'] = $request->has('show_reference');
        $data['show_videos'] = $request->has('show_videos');
        $data['show_labs'] = $request->has('show_labs');
        $data['show_quiz'] = $request->has('show_quiz');

        Track::create($data);

        return redirect()->route('admin.tracks.index')
            ->with('success', 'Track created successfully.');
    }

    public function edit(Track $track)
    {
        $track->load('quizzes.questions');
        return view('admin.tracks.edit', compact('track'));
    }

    public function update(Request $request, Track $track)
    {
        $data = $request->validate([
            'slug' => 'required|unique:tracks,slug,' . $track->id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tutorial_content' => 'nullable|string',
            'reference_content' => 'nullable|string',
            'hero_content' => 'nullable|string',
            'hero_button_text' => 'nullable|string|max:255',
            'hero_button_link' => 'nullable|string|max:255',
            'example_code' => 'nullable|string',
            'videos' => 'nullable|array',
            'videos.*.title' => 'nullable|string|max:255',
            'videos.*.url' => 'nullable|url',
            'show_tutorial' => 'boolean',
            'show_reference' => 'boolean',
            'show_videos' => 'boolean',
            'show_labs' => 'boolean',
            'show_quiz' => 'boolean',
        ]);

        // Process videos array - only update if videos are present in request
        if ($request->has('videos')) {
            $videos = [];
            foreach ($request->input('videos', []) as $video) {
                if (!empty($video['title']) && !empty($video['url'])) {
                    $videos[] = [
                        'title' => $video['title'],
                        'url' => $video['url'],
                    ];
                }
            }
            $data['videos'] = !empty($videos) ? $videos : null;
        } else {
            // If videos are not in request, keep existing videos (don't update)
            unset($data['videos']);
        }

        // Process boolean fields
        $data['show_tutorial'] = $request->has('show_tutorial');
        $data['show_reference'] = $request->has('show_reference');
        $data['show_videos'] = $request->has('show_videos');
        $data['show_labs'] = $request->has('show_labs');
        $data['show_quiz'] = $request->has('show_quiz');

        $track->update($data);

        return redirect()->route('admin.tracks.index')
            ->with('success', 'Track updated successfully.');
    }

    public function destroy(Track $track)
    {
        $track->delete();

        return redirect()->route('admin.tracks.index')
            ->with('success', 'Track deleted successfully.');
    }
}

