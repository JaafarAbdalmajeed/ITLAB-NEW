<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Track;
use App\Models\UserLessonProgress;
use App\Services\ProgressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function index(Track $track)
    {
        $lessons = $track->lessons()->orderBy('order')->get();
        return view('lessons.index', compact('track', 'lessons'));
    }

    public function create(Track $track)
    {
        return view('lessons.create', compact('track'));
    }

    public function store(Request $request, Track $track)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'order' => 'integer',
        ]);

        $lesson = $track->lessons()->create($data);

        return redirect()->route('tracks.lessons.show', [$track, $lesson]);
    }

    public function show(Track $track, Lesson $lesson)
    {
        // Load track with lessons ordered for navigation
        $track->load(['lessons' => function($query) {
            $query->orderBy('order');
        }]);

        // Check if lesson is completed by user
        $isCompleted = false;
        if (Auth::check()) {
            $isCompleted = $lesson->isCompletedByUser(Auth::id());
        }

        return view('lessons.show', compact('track', 'lesson', 'isCompleted'));
    }

    /**
     * Mark lesson as completed
     */
    public function markComplete(Request $request, Track $track, Lesson $lesson)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to mark lessons as complete',
            ], 401);
        }

        $user = Auth::user();

        // Create or update lesson progress
        $progress = UserLessonProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
            ],
            [
                'is_completed' => true,
                'completed_at' => now(),
            ]
        );

        // Update track progress
        $this->updateTrackProgress($user, $track);

        return response()->json([
            'success' => true,
            'message' => 'Lesson marked as completed',
            'progress' => $progress,
        ]);
    }

    /**
     * Update track progress based on completed lessons
     */
    private function updateTrackProgress($user, Track $track): void
    {
        $totalLessons = $track->lessons()->count();
        
        if ($totalLessons === 0) {
            return;
        }

        $completedLessons = UserLessonProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $track->lessons()->pluck('id'))
            ->where('is_completed', true)
            ->count();

        $progressPercent = (int) round(($completedLessons / $totalLessons) * 100);

        $progressService = app(ProgressService::class);
        $progressService->updateProgress($user, $track, $progressPercent);
    }

    public function edit(Track $track, Lesson $lesson)
    {
        return view('lessons.edit', compact('track', 'lesson'));
    }

    public function update(Request $request, Track $track, Lesson $lesson)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'order' => 'integer',
        ]);

        $lesson->update($data);

        return redirect()->route('tracks.lessons.show', [$track, $lesson]);
    }

    public function destroy(Track $track, Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('tracks.show', $track);
    }
}
