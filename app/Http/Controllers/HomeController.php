<?php

namespace App\Http\Controllers;

use App\Models\Track;
use App\Models\Quiz;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard with curated content.
     */
    public function index()
    {
        // Featured tracks (e.g., cyber tracks)
        $featured = Track::whereIn('slug', ['cyber-network', 'cyber-web'])->with(['lessons', 'quizzes'])->get();

        // All tracks for display
        $allTracks = Track::with(['lessons', 'quizzes', 'labs'])->get();
        
        // Programming tracks
        $programmingTracks = Track::whereIn('slug', ['html', 'css', 'js', 'java'])->get();
        
        // Cyber security tracks
        $cyberTracks = Track::whereIn('slug', ['cyber-network', 'cyber-web'])->get();

        // Recent tracks and quizzes for discovery
        $recentTracks = Track::orderBy('created_at', 'desc')->limit(6)->get();
        $recentQuizzes = Quiz::with('track')->orderBy('created_at', 'desc')->limit(6)->get();
        
        // Statistics
        $stats = [
            'total_tracks' => Track::count(),
            'total_lessons' => \App\Models\Lesson::count(),
            'total_labs' => \App\Models\Lab::count(),
            'total_quizzes' => Quiz::count(),
        ];
        
        // Popular tracks (by user progress count)
        $popularTracks = Track::withCount('userProgress')
            ->orderBy('user_progress_count', 'desc')
            ->limit(3)
            ->get();

        // Prepare tracks for search (with keywords and routes)
        $searchTracks = $allTracks->map(function($track) {
            $keywords = [strtolower($track->title), strtolower($track->slug)];
            if ($track->description) {
                $descWords = explode(' ', strtolower($track->description));
                $keywords = array_merge($keywords, $descWords);
            }
            
            // Get route based on slug
            $route = route('tracks.show', $track);
            switch($track->slug) {
                case 'html':
                    $route = route('pages.html');
                    break;
                case 'css':
                    $route = route('pages.css');
                    break;
                case 'js':
                    $route = route('pages.js');
                    break;
                case 'java':
                    $route = route('pages.java');
                    break;
                case 'cyber-network':
                    $route = route('pages.cyber-network');
                    break;
                case 'cyber-web':
                    $route = route('pages.cyber-web');
                    break;
            }
            
            return [
                'keywords' => array_values(array_unique($keywords)),
                'url' => $route,
                'title' => $track->title
            ];
        })->values();

        return view('home.index', compact(
            'featured', 
            'recentTracks', 
            'recentQuizzes',
            'allTracks',
            'programmingTracks',
            'cyberTracks',
            'stats',
            'popularTracks',
            'searchTracks'
        ));
    }
}
