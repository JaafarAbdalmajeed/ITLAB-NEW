<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;

class CyberController extends Controller
{
    protected function loadTrack(string $slug)
    {
        return Track::where('slug', $slug)->with(['lessons' => function ($q) {
            $q->orderBy('order');
        }, 'quizzes.questions', 'labs', 'videos'])->firstOrFail();
    }

    public function network()
    {
        $track = $this->loadTrack('cyber-network');
        // Get recommendations
        $recommendationService = app(\App\Services\RecommendationService::class);
        $youMightAlsoLike = $recommendationService->getYouMightAlsoLike(auth()->user(), $track, 4);
        return view('pages.tracks.main', compact('track', 'youMightAlsoLike'));
    }

    public function networkVideos()
    {
        $track = $this->loadTrack('cyber-network');
        return view('pages.tracks.videos', compact('track'));
    }

    public function networkLabs()
    {
        $track = $this->loadTrack('cyber-network');
        return view('pages.tracks.labs', compact('track'));
    }

    public function networkQuiz()
    {
        $track = $this->loadTrack('cyber-network');
        $quiz = $track->quizzes()->with('questions')->first();
        
        if (!$quiz) {
            return redirect()->route('pages.cyber-network')
                ->with('error', 'No quiz available for Network Security track at the moment');
        }
        
        return view('pages.tracks.quiz', compact('track', 'quiz'));
    }

    public function web()
    {
        $track = $this->loadTrack('cyber-web');
        // Get recommendations
        $recommendationService = app(\App\Services\RecommendationService::class);
        $youMightAlsoLike = $recommendationService->getYouMightAlsoLike(auth()->user(), $track, 4);
        return view('pages.tracks.main', compact('track', 'youMightAlsoLike'));
    }

    public function webVideos()
    {
        $track = $this->loadTrack('cyber-web');
        return view('pages.tracks.videos', compact('track'));
    }

    public function webLabs()
    {
        $track = $this->loadTrack('cyber-web');
        return view('pages.tracks.labs', compact('track'));
    }

    public function webQuiz()
    {
        $track = $this->loadTrack('cyber-web');
        $quiz = $track->quizzes()->with('questions')->first();
        
        if (!$quiz) {
            return redirect()->route('pages.cyber-web')
                ->with('error', 'No quiz available for Web Security track at the moment');
        }
        
        return view('pages.tracks.quiz', compact('track', 'quiz'));
    }
}
