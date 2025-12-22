<?php

namespace App\Http\Controllers;

use App\Models\Track;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Lab;
use App\Models\Page;
use App\Models\User;
use App\Models\QuizResult;
use App\Models\UserProgress;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Cache statistics for 5 minutes
        $stats = Cache::remember('admin_stats', 300, function () {
            $stats = [
                'tracks' => Track::count(),
                'lessons' => Lesson::count(),
                'quizzes' => Quiz::count(),
                'labs' => Lab::count(),
                'pages' => Page::count(),
                'users' => User::count(),
                'quiz_results' => QuizResult::count(),
            ];
            
            // Check if contacts table exists
            try {
                $stats['contacts'] = Contact::count();
                $stats['unread_contacts'] = Contact::unread()->count();
            } catch (\Exception $e) {
                $stats['contacts'] = 0;
                $stats['unread_contacts'] = 0;
            }
            
            return $stats;
        });

        $recentTracks = Track::latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        // Get additional statistics
        $additionalStats = Cache::remember('admin_additional_stats', 300, function () {
            return [
                'total_quiz_attempts' => QuizResult::count(),
                'average_quiz_score' => QuizResult::avg('score') ? round(QuizResult::avg('score'), 2) : 0,
                'users_with_progress' => UserProgress::distinct('user_id')->count(),
                'completed_tracks' => UserProgress::where('progress_percent', 100)->count(),
            ];
        });

        return view('admin.dashboard', compact('stats', 'recentTracks', 'recentUsers', 'additionalStats'));
    }
}
