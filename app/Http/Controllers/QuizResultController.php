<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizResultRequest;
use App\Models\Quiz;
use App\Models\Track;
use App\Services\QuizService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuizResultController extends Controller
{
    protected $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    public function store(StoreQuizResultRequest $request, Track $track, Quiz $quiz)
    {
        try {
            $answers = $request->input('answers', []);
            $user = auth()->user();

            if (!$user) {
                // Redirect to login with a message
                return redirect()
                    ->route('auth.login')
                    ->with('error', 'You must be logged in to submit the quiz. Please log in and try again.')
                    ->withInput();
            }

            // Validate that all questions are answered
            $questions = $quiz->questions()->get();
            $answeredCount = count(array_filter($answers, fn($answer) => !empty($answer)));
            
            if ($answeredCount < $questions->count()) {
                return back()
                    ->withErrors(['error' => 'Please answer all questions before submitting.'])
                    ->withInput();
            }

            $result = $this->quizService->submitQuiz($quiz, $answers, $user);

            $message = $result['is_new_record'] 
                ? "Quiz submitted successfully! Score: {$result['score']}%"
                : "Score updated! Score: {$result['score']}%";

            // Determine the correct redirect route based on track slug
            $redirectRoute = match($track->slug) {
                'html' => route('pages.html.quiz'),
                'css' => route('pages.css.quiz'),
                'js' => route('pages.js.quiz'),
                'java' => route('pages.java.quiz'),
                default => route('tracks.quizzes.show', [$track, $quiz]),
            };

            // Redirect back to quiz page with success message
            return redirect($redirectRoute)
                ->with('status', $message)
                ->with('quiz_score', $result['score'])
                ->with('success', true);

        } catch (\Exception $e) {
            Log::error('Quiz submission error: ' . $e->getMessage());
            Log::error('Quiz submission error trace: ' . $e->getTraceAsString());
            
            return back()
                ->withErrors(['error' => 'An error occurred while submitting the quiz: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Get user's quiz results
     */
    public function index(Track $track, Quiz $quiz)
    {
        // Explicitly allow access (bypass policy if needed)
        // The controller will handle authentication check below
        
        $user = auth()->user();
        
        // If user is not logged in, redirect to login with a message
        if (!$user) {
            if (request()->expectsJson()) {
                return response()->json([
                    'error' => 'Unauthorized',
                    'message' => 'You must be logged in to view quiz results.'
                ], 401);
            }
            
            return redirect()->route('auth.login')
                ->with('error', 'You must be logged in to view quiz results.');
        }

        $userResult = $this->quizService->getUserBestScore($quiz, $user);
        $statistics = $this->quizService->getQuizStatistics($quiz);

        // If request expects JSON (API call), return JSON
        if (request()->expectsJson()) {
            return response()->json([
                'user_score' => $userResult,
                'statistics' => $statistics,
            ]);
        }

        // Otherwise, show a view with results
        return view('quizzes.results', compact('track', 'quiz', 'userResult', 'statistics'));
    }
}
