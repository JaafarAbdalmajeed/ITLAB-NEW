<?php

namespace App\Http\Controllers;

use App\Models\Track;
use App\Models\Lab;
use App\Models\Quiz;
use App\Models\Contact;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function html()
    {
        $track = Track::where('slug', 'html')->with(['lessons', 'quizzes', 'labs'])->first();
        
        if (!$track) {
            // Create default Track if it doesn't exist
            $track = Track::create([
                'slug' => 'html',
                'title' => 'HTML',
                'description' => 'Learn HTML for building web pages',
                'show_tutorial' => true,
                'show_reference' => true,
                'show_videos' => true,
                'show_labs' => true,
                'show_quiz' => true,
            ]);
        }
        
        // Get recommendations
        $recommendationService = app(\App\Services\RecommendationService::class);
        $youMightAlsoLike = $recommendationService->getYouMightAlsoLike(auth()->user(), $track, 4);
        
        return view('pages.tracks.main', compact('track', 'youMightAlsoLike'));
    }

    public function htmlTrack()
    {
        $track = Track::where('slug', 'html')->with(['lessons' => function($query) {
            $query->orderBy('order');
        }])->firstOrFail();
        return view('pages.tracks.track', compact('track'));
    }

    public function htmlVideos()
    {
        $track = Track::where('slug', 'html')->with('videos')->firstOrFail();
        return view('pages.tracks.videos', compact('track'));
    }

    public function htmlReference()
    {
        $track = Track::where('slug', 'html')->firstOrFail();
        return view('pages.tracks.reference', compact('track'));
    }

    public function htmlTutorial()
    {
        $track = Track::where('slug', 'html')->firstOrFail();
        return view('pages.tracks.tutorial', compact('track'));
    }

    public function htmlLabs()
    {
        $track = Track::where('slug', 'html')->with('labs')->firstOrFail();
        return view('pages.tracks.labs', compact('track'));
    }

    public function htmlQuiz()
    {
        $track = Track::where('slug', 'html')->with(['quizzes.questions'])->firstOrFail();
        $quiz = $track->quizzes()->with('questions')->first();
        
        if (!$quiz) {
            return redirect()->route('pages.html')
                ->with('error', 'No quiz available for HTML track at the moment');
        }
        
        return view('pages.tracks.quiz', compact('track', 'quiz'));
    }

    /**
     * CSS Track - Main Page
     */
    public function css()
    {
        try {
            $track = Track::where('slug', 'css')->with(['lessons', 'quizzes', 'labs'])->first();
            
            if (!$track) {
                // Create default Track if it doesn't exist
                try {
                    $track = Track::create([
                        'slug' => 'css',
                        'title' => 'CSS',
                        'description' => 'Learn CSS for styling web pages',
                        'show_tutorial' => true,
                        'show_reference' => true,
                        'show_videos' => true,
                        'show_labs' => true,
                        'show_quiz' => true,
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to create CSS track: ' . $e->getMessage());
                    abort(500, 'Unable to create CSS track. Please check database: ' . $e->getMessage());
                }
            }
            
            // Get recommendations
            $recommendationService = app(\App\Services\RecommendationService::class);
            $youMightAlsoLike = $recommendationService->getYouMightAlsoLike(auth()->user(), $track, 4);
            
            return view('pages.tracks.main', compact('track', 'youMightAlsoLike'));
        } catch (\Exception $e) {
            \Log::error('CSS page error: ' . $e->getMessage());
            abort(500, 'Error loading CSS page: ' . $e->getMessage());
        }
    }

    /**
     * CSS Track - Lessons Page
     */
    public function cssTrack()
    {
        $track = Track::where('slug', 'css')->with(['lessons' => function($query) {
            $query->orderBy('order');
        }])->firstOrFail();
        return view('pages.tracks.track', compact('track'));
    }

    /**
     * CSS Track - Tutorial Page
     */
    public function cssTutorial()
    {
        $track = Track::where('slug', 'css')->firstOrFail();
        return view('pages.tracks.tutorial', compact('track'));
    }

    /**
     * CSS Track - Videos Page
     */
    public function cssVideos()
    {
        $track = Track::where('slug', 'css')->with('videos')->firstOrFail();
        return view('pages.tracks.videos', compact('track'));
    }

    /**
     * CSS Track - Reference Page
     */
    public function cssReference()
    {
        $track = Track::where('slug', 'css')->firstOrFail();
        return view('pages.tracks.reference', compact('track'));
    }

    /**
     * CSS Track - Labs Page
     */
    public function cssLabs()
    {
        $track = Track::where('slug', 'css')->with('labs')->firstOrFail();
        return view('pages.tracks.labs', compact('track'));
    }

    /**
     * CSS Track - Quiz Page
     */
    public function cssQuiz()
    {
        $track = Track::where('slug', 'css')->with(['quizzes.questions'])->firstOrFail();
        $quiz = $track->quizzes()->with('questions')->first();
        
        if (!$quiz) {
            return redirect()->route('pages.css')
                ->with('error', 'No quiz available for CSS track at the moment');
        }
        
        return view('pages.tracks.quiz', compact('track', 'quiz'));
    }

    /**
     * JavaScript Track - Main Page
     */
    public function js()
    {
        try {
            $track = Track::where('slug', 'js')->with(['lessons', 'quizzes', 'labs'])->first();
            
            if (!$track) {
                // Create default Track if it doesn't exist
                try {
                    $track = Track::create([
                        'slug' => 'js',
                        'title' => 'JavaScript',
                        'description' => 'Learn JavaScript for interactive web pages',
                        'show_tutorial' => true,
                        'show_reference' => true,
                        'show_videos' => true,
                        'show_labs' => true,
                        'show_quiz' => true,
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to create JS track: ' . $e->getMessage());
                    abort(500, 'Unable to create JavaScript track. Please check database: ' . $e->getMessage());
                }
            }
            
            // Get recommendations
            $recommendationService = app(\App\Services\RecommendationService::class);
            $youMightAlsoLike = $recommendationService->getYouMightAlsoLike(auth()->user(), $track, 4);
            
            return view('pages.tracks.main', compact('track', 'youMightAlsoLike'));
        } catch (\Exception $e) {
            \Log::error('JS page error: ' . $e->getMessage());
            abort(500, 'Error loading JavaScript page: ' . $e->getMessage());
        }
    }

    /**
     * JavaScript Track - Lessons Page
     */
    public function jsTrack()
    {
        $track = Track::where('slug', 'js')->with(['lessons' => function($query) {
            $query->orderBy('order');
        }])->firstOrFail();
        return view('pages.tracks.track', compact('track'));
    }

    /**
     * JavaScript Track - Tutorial Page
     */
    public function jsTutorial()
    {
        $track = Track::where('slug', 'js')->firstOrFail();
        return view('pages.tracks.tutorial', compact('track'));
    }

    /**
     * JavaScript Track - Videos Page
     */
    public function jsVideos()
    {
        $track = Track::where('slug', 'js')->with('videos')->firstOrFail();
        return view('pages.tracks.videos', compact('track'));
    }

    /**
     * JavaScript Track - Reference Page
     */
    public function jsReference()
    {
        $track = Track::where('slug', 'js')->firstOrFail();
        return view('pages.tracks.reference', compact('track'));
    }

    /**
     * JavaScript Track - Quiz Page
     */
    public function jsQuiz()
    {
        $track = Track::where('slug', 'js')->with(['quizzes.questions'])->firstOrFail();
        $quiz = $track->quizzes()->with('questions')->first();
        
        if (!$quiz) {
            return redirect()->route('pages.js')
                ->with('error', 'No quiz available for JavaScript track at the moment');
        }
        
        return view('pages.tracks.quiz', compact('track', 'quiz'));
    }

    /**
     * JavaScript Track - Labs Page
     */
    public function jsLabs()
    {
        $track = Track::where('slug', 'js')->with('labs')->firstOrFail();
        return view('pages.tracks.labs', compact('track'));
    }

    /**
     * Java Track - Main Page
     */
    public function java()
    {
        try {
            $track = Track::where('slug', 'java')->with(['lessons' => function($query) {
                $query->orderBy('order');
            }, 'quizzes', 'labs'])->first();
            
            if (!$track) {
                // Create default Track if it doesn't exist
                try {
                    $track = Track::create([
                        'slug' => 'java',
                        'title' => 'Java',
                        'description' => 'Learn Java programming language - object-oriented programming, classes, methods, and more.',
                        'show_tutorial' => true,
                        'show_reference' => true,
                        'show_videos' => true,
                        'show_labs' => true,
                        'show_quiz' => true,
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to create Java track: ' . $e->getMessage());
                    abort(500, 'Unable to create Java track. Please check database: ' . $e->getMessage());
                }
            }
            
            // Get recommendations
            $recommendationService = app(\App\Services\RecommendationService::class);
            $youMightAlsoLike = $recommendationService->getYouMightAlsoLike(auth()->user(), $track, 4);
            
            return view('pages.tracks.main', compact('track', 'youMightAlsoLike'));
        } catch (\Exception $e) {
            \Log::error('Java page error: ' . $e->getMessage());
            abort(500, 'Error loading Java page: ' . $e->getMessage());
        }
    }

    /**
     * Java Track - Lessons Page
     */
    public function javaTrack()
    {
        $track = Track::where('slug', 'java')->with(['lessons' => function($query) {
            $query->orderBy('order');
        }])->firstOrFail();
        return view('pages.tracks.track', compact('track'));
    }

    /**
     * Java Track - Tutorial Page
     */
    public function javaTutorial()
    {
        $track = Track::where('slug', 'java')->firstOrFail();
        return view('pages.tracks.tutorial', compact('track'));
    }

    /**
     * Java Track - Videos Page
     */
    public function javaVideos()
    {
        $track = Track::where('slug', 'java')->with('videos')->firstOrFail();
        return view('pages.tracks.videos', compact('track'));
    }

    /**
     * Java Track - Reference Page
     */
    public function javaReference()
    {
        $track = Track::where('slug', 'java')->firstOrFail();
        return view('pages.tracks.reference', compact('track'));
    }

    /**
     * Java Track - Labs Page
     */
    public function javaLabs()
    {
        $track = Track::where('slug', 'java')->with('labs')->firstOrFail();
        return view('pages.tracks.labs', compact('track'));
    }

    /**
     * Java Track - Quiz Page
     */
    public function javaQuiz()
    {
        $track = Track::where('slug', 'java')->with(['quizzes.questions'])->firstOrFail();
        $quiz = $track->quizzes()->with('questions')->first();
        
        if (!$quiz) {
            return redirect()->route('pages.java')
                ->with('error', 'No quiz available for Java track at the moment');
        }
        
        return view('pages.tracks.quiz', compact('track', 'quiz'));
    }

    public function labs()
    {
        $labs = Lab::with('track')->orderBy('track_id')->get();
        return view('pages.labs', compact('labs'));
    }

    public function tryIt(Request $request)
    {
        $type = $request->query('type', 'html');
        $example = match($type) {
            'css' => '<button class="btn">Example CSS Button</button>',
            'js' => '<script>console.log("JS example")</script>',
            default => '<p>Try editing HTML and reloading this example.</p>',
        };
        return view('pages.try-it', compact('type', 'example'));
    }

    public function dashboard()
    {
        $featured = Track::whereIn('slug', ['cyber-network', 'cyber-web'])->with('lessons')->get();
        $recentTracks = Track::orderBy('created_at', 'desc')->limit(6)->get();
        
        // Dynamic statistics
        $totalTracks = Track::count();
        $totalLessons = \App\Models\Lesson::count();
        $totalLabs = Lab::count();
        $totalQuizzes = Quiz::count();
        
        // User statistics (if logged in)
        $userStats = null;
        if (auth()->check()) {
            $userStats = [
                'completed_tracks' => \App\Models\UserProgress::where('user_id', auth()->id())
                    ->where('progress_percent', 100)->count(),
                'in_progress_tracks' => \App\Models\UserProgress::where('user_id', auth()->id())
                    ->where('progress_percent', '<', 100)->count(),
                'total_quizzes_taken' => \App\Models\QuizResult::where('user_id', auth()->id())->count(),
                'average_quiz_score' => \App\Models\QuizResult::where('user_id', auth()->id())->avg('score') ?? 0,
            ];
        }
        
        // Most popular tracks
        $popularTracks = Track::withCount('userProgress')
            ->orderBy('user_progress_count', 'desc')
            ->limit(4)
            ->get();
        
        // Smart Recommendations
        $recommendationService = app(\App\Services\RecommendationService::class);
        $recommendedTracks = $recommendationService->getRecommendations(auth()->user(), 6);
        
        return view('pages.dashboard', compact(
            'featured', 
            'recentTracks', 
            'totalTracks', 
            'totalLessons', 
            'totalLabs', 
            'totalQuizzes',
            'userStats',
            'popularTracks',
            'recommendedTracks'
        ));
    }

    public function getCertified()
    {
        // Get all tracks with quizzes for certification
        $certificationTracks = Track::where('show_quiz', true)
            ->with(['quizzes' => function($query) {
                $query->with('questions');
            }])
            ->get();
        
        // Get user's quiz results if logged in
        $userCertifications = null;
        if (auth()->check()) {
            $userCertifications = \App\Models\QuizResult::where('user_id', auth()->id())
                ->with(['quiz.track'])
                ->get()
                ->groupBy('quiz.track_id');
        }
        
        return view('pages.get-certified', compact('certificationTracks', 'userCertifications'));
    }

    public function gettingStarted()
    {
        return view('pages.getting-started');
    }

    // Informational pages
    public function about()
    {
        $page = \App\Models\Page::where('slug', 'about')->with('publishedSections')->first();
        
        // Get platform statistics
        $stats = [
            'total_tracks' => Track::count(),
            'total_lessons' => \App\Models\Lesson::count(),
            'total_labs' => Lab::count(),
            'total_quizzes' => Quiz::count(),
            'total_users' => \App\Models\User::count(),
        ];
        
        // Get all tracks
        $allTracks = Track::with(['lessons', 'quizzes', 'labs'])->get();
        
        return view('pages.about', compact('page', 'stats', 'allTracks'));
    }

    public function students()
    {
        $page = \App\Models\Page::where('slug', 'students')->with('publishedSections')->firstOrFail();
        return view('pages.page', compact('page'));
    }

    public function instructors()
    {
        $page = \App\Models\Page::where('slug', 'instructors')->with('publishedSections')->firstOrFail();
        return view('pages.page', compact('page'));
    }

    public function roadmap()
    {
        $page = \App\Models\Page::where('slug', 'roadmap-2025')->with('publishedSections')->firstOrFail();
        return view('pages.page', compact('page'));
    }

    public function blog()
    {
        $page = \App\Models\Page::where('slug', 'blog')->with('publishedSections')->first();
        
        // Get recent tracks and updates
        $recentTracks = Track::orderBy('created_at', 'desc')->limit(5)->get();
        $featuredTracks = Track::whereIn('slug', ['html', 'css', 'js', 'java'])->get();
        
        // Get statistics
        $stats = [
            'total_tracks' => Track::count(),
            'total_lessons' => \App\Models\Lesson::count(),
            'total_labs' => Lab::count(),
        ];
        
        return view('pages.blog', compact('page', 'recentTracks', 'featuredTracks', 'stats'));
    }

    public function helpCenter()
    {
        $page = \App\Models\Page::where('slug', 'help-center')->with('publishedSections')->firstOrFail();
        return view('pages.page', compact('page'));
    }

    public function contact()
    {
        $page = \App\Models\Page::where('slug', 'contact')->with('publishedSections')->firstOrFail();
        return view('pages.contact', compact('page'));
    }

    public function contactSubmit(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000',
            'subject' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        // Save contact message to database
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'subject' => $request->subject,
            'phone' => $request->phone,
            'read' => false,
        ]);

        // TODO: Send email notification to admin (optional)
        // Mail::to(config('mail.admin_email'))->send(new ContactFormSubmitted($contact));

        return back()->with('status', 'Thank you! Your message has been received and we will get back to you soon.');
    }

    public function reportBug()
    {
        $page = \App\Models\Page::where('slug', 'report-bug')->with('publishedSections')->firstOrFail();
        return view('pages.report-bug', compact('page'));
    }

    public function beginnerPath()
    {
        $page = \App\Models\Page::where('slug', 'beginner-path')->with('publishedSections')->firstOrFail();
        return view('pages.page', compact('page'));
    }

    /**
     * Dynamic page handler - displays any page by slug
     * This allows admins to create new pages without adding routes
     */
    public function showPage($slug)
    {
        $page = \App\Models\Page::where('slug', $slug)
            ->where('published', true)
            ->with('publishedSections')
            ->firstOrFail();
        
        return view('pages.page', compact('page'));
    }

    /**
     * ============================================================================
     * Dynamic Track Routes - Works for any track added from admin
     * ============================================================================
     */

    /**
     * Dynamic track main page
     */
    public function trackMain(Track $track)
    {
        $track->load(['lessons' => function($query) {
            $query->orderBy('order');
        }, 'quizzes', 'labs']);
        
        return view('pages.tracks.main', compact('track'));
    }

    /**
     * Dynamic track lessons page
     */
    public function trackLessons(Track $track)
    {
        $track->load(['lessons' => function($query) {
            $query->orderBy('order');
        }]);
        
        return view('pages.tracks.track', compact('track'));
    }

    /**
     * Dynamic track tutorial page
     */
    public function trackTutorial(Track $track)
    {
        return view('pages.tracks.tutorial', compact('track'));
    }

    /**
     * Dynamic track reference page
     */
    public function trackReference(Track $track)
    {
        return view('pages.tracks.reference', compact('track'));
    }

    /**
     * Dynamic track videos page
     */
    public function trackVideos(Track $track)
    {
        $track->load('videos');
        return view('pages.tracks.videos', compact('track'));
    }

    /**
     * Dynamic track labs page
     */
    public function trackLabs(Track $track)
    {
        $track->load('labs');
        return view('pages.tracks.labs', compact('track'));
    }

    /**
     * Dynamic track quiz page
     */
    public function trackQuiz(Track $track)
    {
        $track->load(['quizzes.questions']);
        $quiz = $track->quizzes()->with('questions')->first();
        
        if (!$quiz) {
            return redirect()->route('pages.track.main', $track)
                ->with('error', 'No quiz available for this track at the moment');
        }
        
        return view('pages.tracks.quiz', compact('track', 'quiz'));
    }
}
