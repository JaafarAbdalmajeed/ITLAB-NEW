<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Track;
use App\Models\QuizResult;
use App\Models\UserProgress;
use App\Services\ProgressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount(['quizResults', 'progress'])
            ->latest()
            ->paginate(20);
        
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['quizResults.quiz.track', 'progress.track']);
        
        $stats = [
            'total_quizzes_taken' => $user->quizResults()->count(),
            'average_score' => $user->quizResults()->avg('score') ?? 0,
            'completed_tracks' => $user->progress()->where('progress_percent', 100)->count(),
            'in_progress_tracks' => $user->progress()->where('progress_percent', '<', 100)->count(),
        ];
        
        $allTracks = Track::all();
        $userProgressTracks = $user->progress->pluck('track_id')->toArray();
        
        return view('admin.users.show', compact('user', 'stats', 'allTracks', 'userProgressTracks'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $data['is_admin'] = $request->has('is_admin');

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Complete a track for a user
     */
    public function completeTrack(Request $request, User $user, Track $track)
    {
        $progressService = app(ProgressService::class);
        
        try {
            $progressService->markTrackCompleted($user, $track);
            
            return redirect()->back()
                ->with('success', "Track '{$track->title}' has been marked as completed for {$user->name}. Certificate has been issued.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while completing the track: ' . $e->getMessage());
        }
    }
}

