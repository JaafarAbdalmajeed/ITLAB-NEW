<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\CyberController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\QuizResultController;
use App\Http\Controllers\UserProgressController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\TrackController as AdminTrackController;
use App\Http\Controllers\Admin\LessonController as AdminLessonController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\Admin\LabController as AdminLabController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\StatsController as AdminStatsController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReviewController;
use App\Models\NavbarItem;

// ============================================================================
// Route Model Binding
// ============================================================================
Route::bind('navbar', function ($value) {
    return NavbarItem::findOrFail($value);
});

// ============================================================================
// Home Route
// ============================================================================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ============================================================================
// Track Pages - Specific Routes (HTML, CSS, JavaScript)
// ============================================================================

// HTML Routes
Route::get('html', [PagesController::class, 'html'])->name('pages.html');
Route::get('html/track', [PagesController::class, 'htmlTrack'])->name('pages.html.track');
Route::get('html/tutorial', [PagesController::class, 'htmlTutorial'])->name('pages.html.tutorial');
Route::get('html/reference', [PagesController::class, 'htmlReference'])->name('pages.html.reference');
Route::get('html/videos', [PagesController::class, 'htmlVideos'])->name('pages.html.videos');
Route::get('html/labs', [PagesController::class, 'htmlLabs'])->name('pages.html.labs');
Route::get('html/quiz', [PagesController::class, 'htmlQuiz'])->name('pages.html.quiz');

// CSS Routes (using /learn-css to avoid conflict with public/css folder)
Route::get('learn-css', [PagesController::class, 'css'])->name('pages.css');
Route::get('learn-css/track', [PagesController::class, 'cssTrack'])->name('pages.css.track');
Route::get('learn-css/tutorial', [PagesController::class, 'cssTutorial'])->name('pages.css.tutorial');
Route::get('learn-css/reference', [PagesController::class, 'cssReference'])->name('pages.css.reference');
Route::get('learn-css/videos', [PagesController::class, 'cssVideos'])->name('pages.css.videos');
Route::get('learn-css/labs', [PagesController::class, 'cssLabs'])->name('pages.css.labs');
Route::get('learn-css/quiz', [PagesController::class, 'cssQuiz'])->name('pages.css.quiz');

// JavaScript Routes (using /learn-js to avoid conflict with public/js folder)
Route::get('learn-js', [PagesController::class, 'js'])->name('pages.js');
Route::get('learn-js/track', [PagesController::class, 'jsTrack'])->name('pages.js.track');
Route::get('learn-js/tutorial', [PagesController::class, 'jsTutorial'])->name('pages.js.tutorial');
Route::get('learn-js/reference', [PagesController::class, 'jsReference'])->name('pages.js.reference');
Route::get('learn-js/videos', [PagesController::class, 'jsVideos'])->name('pages.js.videos');
Route::get('learn-js/labs', [PagesController::class, 'jsLabs'])->name('pages.js.labs');
Route::get('learn-js/quiz', [PagesController::class, 'jsQuiz'])->name('pages.js.quiz');

// JavaScript Aliases (backward compatibility)
Route::get('javascript', [PagesController::class, 'js'])->name('pages.javascript');
Route::get('javascript/track', [PagesController::class, 'jsTrack'])->name('pages.javascript.track');
Route::get('javascript/videos', [PagesController::class, 'jsVideos'])->name('pages.javascript.videos');
Route::get('javascript/reference', [PagesController::class, 'jsReference'])->name('pages.javascript.reference');
Route::get('javascript/quiz', [PagesController::class, 'jsQuiz'])->name('pages.javascript.quiz');
Route::get('javascript/labs', [PagesController::class, 'jsLabs'])->name('pages.javascript.labs');

// Java Routes
Route::get('learn-java', [PagesController::class, 'java'])->name('pages.java');
Route::get('learn-java/track', [PagesController::class, 'javaTrack'])->name('pages.java.track');
Route::get('learn-java/tutorial', [PagesController::class, 'javaTutorial'])->name('pages.java.tutorial');
Route::get('learn-java/reference', [PagesController::class, 'javaReference'])->name('pages.java.reference');
Route::get('learn-java/videos', [PagesController::class, 'javaVideos'])->name('pages.java.videos');
Route::get('learn-java/labs', [PagesController::class, 'javaLabs'])->name('pages.java.labs');
Route::get('learn-java/quiz', [PagesController::class, 'javaQuiz'])->name('pages.java.quiz');

// ============================================================================
// Cyber Security Tracks
// ============================================================================

// Network Security
Route::get('cyber-network', [CyberController::class, 'network'])->name('pages.cyber-network');
Route::get('cyber-network/track', function() {
    $track = \App\Models\Track::where('slug', 'cyber-network')->with(['lessons' => function($query) {
        $query->orderBy('order');
    }])->firstOrFail();
    return view('pages.tracks.track', compact('track'));
})->name('pages.cyber-network.track');
Route::get('cyber-network/tutorial', function() {
    $track = \App\Models\Track::where('slug', 'cyber-network')->firstOrFail();
    return view('pages.tracks.tutorial', compact('track'));
})->name('pages.cyber-network.tutorial');
Route::get('cyber-network/reference', function() {
    $track = \App\Models\Track::where('slug', 'cyber-network')->firstOrFail();
    return view('pages.tracks.reference', compact('track'));
})->name('pages.cyber-network.reference');
Route::get('cyber-network/videos', [CyberController::class, 'networkVideos'])->name('pages.cyber-network.videos');
Route::get('cyber-network/labs', [CyberController::class, 'networkLabs'])->name('pages.cyber-network.labs');
Route::get('cyber-network/quiz', [CyberController::class, 'networkQuiz'])->name('pages.cyber-network.quiz');

// Web Security
Route::get('cyber-web', [CyberController::class, 'web'])->name('pages.cyber-web');
Route::get('cyber-web/track', function() {
    $track = \App\Models\Track::where('slug', 'cyber-web')->with(['lessons' => function($query) {
        $query->orderBy('order');
    }])->firstOrFail();
    return view('pages.tracks.track', compact('track'));
})->name('pages.cyber-web.track');
Route::get('cyber-web/tutorial', function() {
    $track = \App\Models\Track::where('slug', 'cyber-web')->firstOrFail();
    return view('pages.tracks.tutorial', compact('track'));
})->name('pages.cyber-web.tutorial');
Route::get('cyber-web/reference', function() {
    $track = \App\Models\Track::where('slug', 'cyber-web')->firstOrFail();
    return view('pages.tracks.reference', compact('track'));
})->name('pages.cyber-web.reference');
Route::get('cyber-web/videos', [CyberController::class, 'webVideos'])->name('pages.cyber-web.videos');
Route::get('cyber-web/labs', [CyberController::class, 'webLabs'])->name('pages.cyber-web.labs');
Route::get('cyber-web/quiz', [CyberController::class, 'webQuiz'])->name('pages.cyber-web.quiz');

// ============================================================================
// General Pages
// ============================================================================
Route::get('dashboard', [PagesController::class, 'dashboard'])->name('pages.dashboard');
Route::get('get-certified', [PagesController::class, 'getCertified'])->name('pages.get-certified');
Route::get('getting-started', [PagesController::class, 'gettingStarted'])->name('pages.getting-started');
Route::get('try-it', [PagesController::class, 'tryIt'])->name('pages.try-it');
Route::get('labs', [PagesController::class, 'labs'])->name('pages.labs');

// Informational Pages
Route::get('about', [PagesController::class, 'about'])->name('pages.about');
Route::get('students', [PagesController::class, 'students'])->name('pages.students');
Route::get('instructors', [PagesController::class, 'instructors'])->name('pages.instructors');
Route::get('roadmap-2025', [PagesController::class, 'roadmap'])->name('pages.roadmap');
Route::get('blog', [PagesController::class, 'blog'])->name('pages.blog');
Route::get('help-center', [PagesController::class, 'helpCenter'])->name('pages.help');
Route::get('beginner-path', [PagesController::class, 'beginnerPath'])->name('pages.beginner-path');
Route::get('report-bug', [PagesController::class, 'reportBug'])->name('pages.report-bug');

// Contact
Route::get('contact', [PagesController::class, 'contact'])->name('pages.contact');
Route::post('contact', [PagesController::class, 'contactSubmit'])->name('pages.contact.submit');

// ============================================================================
// Authentication Routes
// ============================================================================
Route::get('login', [AuthController::class, 'showLogin'])->name('auth.login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegister'])->name('auth.register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

// ============================================================================
// Admin Routes (Protected)
// ============================================================================
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Tracks Management
    Route::resource('tracks', AdminTrackController::class);
    
    // Lessons Management
    Route::resource('tracks.lessons', AdminLessonController::class)->except(['show']);
    
    // Quizzes Management
    Route::resource('tracks.quizzes', AdminQuizController::class);
    Route::get('tracks/{track}/quizzes/{quiz}/questions/create', [AdminQuizController::class, 'createQuestion'])->name('tracks.quizzes.questions.create');
    Route::post('tracks/{track}/quizzes/{quiz}/questions', [AdminQuizController::class, 'storeQuestion'])->name('tracks.quizzes.questions.store');
    Route::get('tracks/{track}/quizzes/{quiz}/questions/{question}/edit', [AdminQuizController::class, 'editQuestion'])->name('tracks.quizzes.questions.edit');
    Route::put('tracks/{track}/quizzes/{quiz}/questions/{question}', [AdminQuizController::class, 'updateQuestion'])->name('tracks.quizzes.questions.update');
    Route::delete('tracks/{track}/quizzes/{quiz}/questions/{question}', [AdminQuizController::class, 'destroyQuestion'])->name('tracks.quizzes.questions.destroy');
    
    // Labs Management
    Route::resource('tracks.labs', AdminLabController::class)->except(['show']);
    
    // Pages Management
    Route::resource('pages', AdminPageController::class);
    
    // Page Sections Management
    Route::resource('pages.sections', \App\Http\Controllers\Admin\PageSectionController::class)->except(['show']);
    Route::post('pages/{page}/sections/update-order', [\App\Http\Controllers\Admin\PageSectionController::class, 'updateOrder'])->name('pages.sections.update-order');
    
    // Home Background Settings
    Route::get('home-background', [\App\Http\Controllers\Admin\HomeBackgroundController::class, 'edit'])->name('home-background.edit');
    Route::put('home-background', [\App\Http\Controllers\Admin\HomeBackgroundController::class, 'update'])->name('home-background.update');
    Route::delete('home-background', [\App\Http\Controllers\Admin\HomeBackgroundController::class, 'destroy'])->name('home-background.destroy');
    
    // Navbar Management
    Route::resource('navbar', \App\Http\Controllers\Admin\NavbarController::class)->except(['show']);
    Route::post('navbar/update-order', [\App\Http\Controllers\Admin\NavbarController::class, 'updateOrder'])->name('navbar.update-order');
    
    // Users Management
    Route::resource('users', AdminUserController::class)->except(['create', 'store']);
    Route::post('users/{user}/tracks/{track}/complete', [AdminUserController::class, 'completeTrack'])->name('admin.users.tracks.complete');
    
    // Certificates Management
    Route::resource('certificates', \App\Http\Controllers\Admin\CertificateController::class);
    Route::get('certificates/{certificate}/view', [\App\Http\Controllers\Admin\CertificateController::class, 'view'])->name('admin.certificates.view');
    Route::get('certificates/{certificate}/download', [\App\Http\Controllers\Admin\CertificateController::class, 'download'])->name('admin.certificates.download');
    
    // Contacts Management
    Route::resource('contacts', AdminContactController::class)->except(['create', 'store', 'edit', 'update']);
    Route::post('contacts/{contact}/mark-read', [AdminContactController::class, 'markAsRead'])->name('contacts.mark-read');
    Route::post('contacts/{contact}/mark-unread', [AdminContactController::class, 'markAsUnread'])->name('contacts.mark-unread');
    Route::put('contacts/{contact}/notes', [AdminContactController::class, 'updateNotes'])->name('contacts.update-notes');
    Route::post('contacts/bulk-delete', [AdminContactController::class, 'bulkDelete'])->name('contacts.bulk-delete');
    
    // Statistics
    Route::get('stats', [AdminStatsController::class, 'index'])->name('stats.index');
});

// ============================================================================
// Track Resources (MUST be at the end to avoid conflicts)
// ============================================================================
// Dynamic routes for all tracks (works with any track added from admin)
Route::resource('tracks', TrackController::class);
Route::resource('tracks.lessons', LessonController::class);
Route::post('tracks/{track}/lessons/{lesson}/complete', [LessonController::class, 'markComplete'])->name('tracks.lessons.complete');
Route::resource('tracks.quizzes', QuizController::class);
Route::resource('tracks.labs', LabController::class);

// Dynamic track pages routes (for any track added from admin)
Route::get('track/{track:slug}', [PagesController::class, 'trackMain'])->name('pages.track.main');
Route::get('track/{track:slug}/lessons', [PagesController::class, 'trackLessons'])->name('pages.track.lessons');
Route::get('track/{track:slug}/tutorial', [PagesController::class, 'trackTutorial'])->name('pages.track.tutorial');
Route::get('track/{track:slug}/reference', [PagesController::class, 'trackReference'])->name('pages.track.reference');
Route::get('track/{track:slug}/videos', [PagesController::class, 'trackVideos'])->name('pages.track.videos');
Route::get('track/{track:slug}/labs', [PagesController::class, 'trackLabs'])->name('pages.track.labs');
Route::get('track/{track:slug}/quiz', [PagesController::class, 'trackQuiz'])->name('pages.track.quiz');

// Quiz Results
Route::middleware(['throttle:quiz-submissions'])->group(function () {
    Route::post('tracks/{track}/quizzes/{quiz}/results', [QuizResultController::class, 'store'])->name('tracks.quizzes.results.store');
    Route::get('tracks/{track}/quizzes/{quiz}/results', [QuizResultController::class, 'index'])->name('tracks.quizzes.results.index');
});

// User Progress
Route::middleware(['throttle:progress-updates'])->group(function () {
    Route::post('tracks/{track}/progress', [UserProgressController::class, 'update'])->name('tracks.progress.update');
    Route::get('tracks/{track}/progress', [UserProgressController::class, 'show'])->name('tracks.progress.show');
    Route::get('progress/overall', [UserProgressController::class, 'overall'])->name('progress.overall');
    Route::post('tracks/{track}/complete', [UserProgressController::class, 'complete'])->name('tracks.complete')->middleware('auth');
});

// Certificates
Route::middleware(['auth'])->group(function () {
    Route::get('certificates', [\App\Http\Controllers\CertificateController::class, 'index'])->name('certificates.index');
    Route::get('tracks/{track}/certificate', [\App\Http\Controllers\CertificateController::class, 'show'])->name('tracks.certificate.show');
    Route::get('tracks/{track}/certificate/download', [\App\Http\Controllers\CertificateController::class, 'download'])->name('tracks.certificate.download');
});

// Achievements
Route::middleware(['auth'])->group(function () {
    Route::get('achievements', [AchievementController::class, 'index'])->name('achievements.index');
    Route::get('api/achievements/progress', [AchievementController::class, 'progress'])->name('achievements.progress');
    Route::get('api/achievements/recent', [AchievementController::class, 'recent'])->name('achievements.recent');
});

// Leaderboard
Route::get('leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
Route::get('api/leaderboard', [LeaderboardController::class, 'api'])->name('leaderboard.api');

// Ratings
Route::middleware(['auth'])->group(function () {
    Route::post('tracks/{track}/ratings', [RatingController::class, 'storeTrack'])->name('tracks.ratings.store');
    Route::post('tracks/{track}/lessons/{lesson}/ratings', [RatingController::class, 'storeLesson'])->name('tracks.lessons.ratings.store');
});
Route::get('tracks/{track}/ratings', [RatingController::class, 'showTrack'])->name('tracks.ratings.show');

// Reviews
Route::get('tracks/{track}/reviews', [ReviewController::class, 'indexTrack'])->name('tracks.reviews.index');
Route::middleware(['auth'])->group(function () {
    Route::post('tracks/{track}/reviews', [ReviewController::class, 'storeTrack'])->name('tracks.reviews.store');
    Route::post('reviews/{review}/vote', [ReviewController::class, 'vote'])->name('reviews.vote');
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// ============================================================================
// Dynamic Pages Route (MUST be at the very end to catch any unmatched routes)
// ============================================================================
// This allows admins to create new pages in admin panel without adding routes
// The controller will check if the page exists, otherwise return 404
Route::get('{slug}', [PagesController::class, 'showPage'])
    ->where('slug', '[a-z0-9\-]+')
    ->name('pages.dynamic');
