<?php

namespace App\Providers;

use App\Events\QuizSubmitted;
use App\Events\TrackCompleted;
use App\Listeners\SendQuizCompletionNotification;
use App\Listeners\SendTrackCompletionNotification;
use App\Models\Track;
use App\Models\Quiz;
use App\Policies\TrackPolicy;
use App\Policies\QuizPolicy;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Track::class => TrackPolicy::class,
        Quiz::class => QuizPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Policies
        Gate::policy(Track::class, TrackPolicy::class);
        Gate::policy(Quiz::class, QuizPolicy::class);

        // Register Events and Listeners
        Event::listen(
            QuizSubmitted::class,
            SendQuizCompletionNotification::class
        );

        Event::listen(
            TrackCompleted::class,
            SendTrackCompletionNotification::class
        );

        // Configure Rate Limiting
        RateLimiter::for('quiz-submissions', function (Request $request) {
            return Limit::perMinute(5)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('progress-updates', function (Request $request) {
            return Limit::perMinute(10)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
